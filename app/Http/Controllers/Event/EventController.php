<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Activity; // Add this import

class EventController extends Controller
{
    public function create()
    {
        return view('events.create');
    }

    public function list()
    {
        return view('events.list');
    }

    public function participations()
    {
        return view('events.participations');
    }

    public function history()
    {
        return view('events.history');
    }

    public function show($id)
    {
        $event = Event::with('medias')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::with('medias')->findOrFail($id);
        return view('events.edit', compact('event'));
    }

    public function create_perform(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_category' => 'required|string',
            'planned_date' => 'required|date',
            'planned_time' => 'required',
            'max_participants' => 'nullable|integer|min:1',
            'location' => 'nullable|string',
            'participation_fee' => 'nullable|numeric|min:0',
            'media_paths' => 'nullable|string', // JSON string
        ]);

        DB::beginTransaction();

        try {
            // Create the event
            $event = Event::create([
                'name' => $request->name,
                'description' => $request->description,
                'event_category' => $request->event_category,
                'is_important' => $request->is_important ?? 0,
                'planned_date' => $request->planned_date,
                'planned_time' => $request->planned_time,
                'max_participants' => $request->max_participants,
                'location' => $request->location,
                'event_cost' => $request->participation_fee ?? 0,
                'created_by' => auth()->id(),
            ]);

            // Handle media paths
            if ($request->filled('media_paths')) {
                $mediaPaths = json_decode($request->media_paths, true);
                foreach ($mediaPaths as $mediaPath) {
                    $mediaType = preg_match('/\.(mp4|avi|mov|mkv)$/i', $mediaPath) ? 'video' : 'image';

                    EventMedia::create([
                        'event_id' => $event->id,
                        'media_type' => $mediaType,
                        'media_path' => $mediaPath,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Event created successfully.',
                'reload' => route('events.list'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,avi,mov,mkv|max:20480',
        ]);

        try {
            $file = $request->file('file');
            $event = new Event(); // Create a new Event instance to use its methods

            if (in_array($file->extension(), ['mp4', 'avi', 'mov', 'mkv'])) {
                $mediaPath = $event->storeVideo($file); // Use storeVideo method
            } else {
                $mediaPath = $event->storeImage($file); // Use storeImage method
            }

            return response()->json(['success' => true, 'path' => $mediaPath]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function join_perform(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $event = Event::findOrFail($id);

            // Check if the user is already participating
            $isParticipating = Activity::where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->exists();

            if ($isParticipating) {
                return response()->json([
                    'status' => false,
                    'message' => 'User is already participating in this event.',
                ]);
            }

            // Add the user to the event participants
            $activityData = [
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'join_date' => now(),
                'has_paid' => $event->event_cost == 0, // Mark as paid if event cost is 0
            ];

            Activity::create($activityData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'User successfully joined the event.',
                'reload' => route('events.show', ['id' => $event->id]),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function leave_perform(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $activity = Activity::where('event_id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Refund if the user has paid
            if ($activity->has_paid && $activity->wallet_id) {
                $wallet = $activity->wallet;

                if ($wallet) {
                    $refundAmount = Event::findOrFail($id)->event_cost;

                    // Create a wallet transaction for the refund
                    $wallet->transactions()->create([
                        'current_balance' => $wallet->balance,
                        'amount' => $refundAmount,
                        'new_balance' => $wallet->balance + $refundAmount,
                        'message' => 'Refund for event cancellation',
                        'user_note' => 'Participation canceled for event ID: ' . $id,
                    ]);

                    // Update wallet balance
                    $wallet->update(['balance' => $wallet->balance + $refundAmount]);
                }
            }

            // Delete the activity record
            $activity->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Participation canceled successfully.',
                'reload' => route('events.list'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function payment_perform(Request $request, $id)
    {
        $request->validate([
            'wallet' => 'required|exists:wallets,id',
        ]);

        DB::beginTransaction();

        try {
            $event = Event::findOrFail($id);

            if ($event->event_cost <= 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'This event does not require payment.',
                ]);
            }

            $wallet = auth()->user()->wallets()->findOrFail($request->wallet);

            if ($wallet->balance < $event->event_cost) {
                return response()->json([
                    'status' => false,
                    'message' => 'Insufficient wallet balance.',
                ]);
            }

            // Deduct the event cost from the wallet
            $wallet->transactions()->create([
                'current_balance' => $wallet->balance,
                'amount' => -$event->event_cost,
                'new_balance' => $wallet->balance - $event->event_cost,
                'message' => 'Payment for event participation',
                'user_note' => 'Event ID: ' . $event->id,
            ]);

            $wallet->update(['balance' => $wallet->balance - $event->event_cost]);

            // Update the activity record
            $activity = Activity::where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $activity->update([
                'has_paid' => true,
                'wallet_id' => $wallet->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Payment successful.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function edit_perform(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_category' => 'required|string',
            'planned_date' => 'required|date',
            'planned_time' => 'required',
            'max_participants' => 'nullable|integer|min:1',
            'location' => 'nullable|string',
            'participation_fee' => 'nullable|numeric|min:0',
            'is_important' => 'nullable|boolean',
            'media_paths' => 'nullable|string', // JSON string
        ]);

        DB::beginTransaction();

        try {
            $event = Event::findOrFail($id);

            // Update event details
            $event->update([
                'name' => $request->name,
                'description' => $request->description,
                'event_category' => $request->event_category,
                'planned_date' => $request->planned_date,
                'planned_time' => $request->planned_time,
                'max_participants' => $request->max_participants,
                'location' => $request->location,
                'event_cost' => $request->participation_fee,
                'is_important' => $request->is_important ?? $event->is_important,
            ]);

            // Delete all existing media
            foreach ($event->medias as $media) {
                Storage::disk('public')->delete($media->media_path); // Delete file from storage
                $media->delete(); // Delete record from database
            }

            // Handle new media paths
            if ($request->filled('media_paths')) {
                $mediaPaths = json_decode($request->media_paths, true);
                foreach ($mediaPaths as $mediaPath) {
                    $mediaType = preg_match('/\.(mp4|avi|mov|mkv)$/i', $mediaPath) ? 'video' : 'image';

                    EventMedia::create([
                        'event_id' => $event->id,
                        'media_type' => $mediaType,
                        'media_path' => $mediaPath,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Event updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function delete_perform(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->created_by !== auth()->id() && !auth()->user()->is_admin) {
            return response()->json(['status' => false, 'error' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(['status' => true, 'reload' => route('events.list')]);
    }
}
