<?php

namespace App\Http\Controllers\Readers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reader;
use App\Models\JobBuilder;

class ReadersController extends Controller
{
    public function reader_startup(Request $request)
    {
        // chip_id zorunlu, diğer alanlar opsiyonel
        $validated = $request->validate([
            'chip_id' => ['required', 'string', 'max:255'],
        ]);

        $chip_id = $validated['chip_id'];

        // Opsiyonel alanları al
        $wifi_ip = $request->input('wifi_ip');
        $wifi_mac = $request->input('wifi_mac');
        $ethernet_ip = $request->input('ethernet_ip');
        $ethernet_mac = $request->input('ethernet_mac');
        $public_ip = $request->ip();

        // Format kontrolleri (varsa)
        $errors = [];

        if (!empty($wifi_ip) && !filter_var($wifi_ip, FILTER_VALIDATE_IP)) {
            $errors['wifi_ip'] = 'wifi_ip formatı geçersiz.';
        }
        if (!empty($ethernet_ip) && !filter_var($ethernet_ip, FILTER_VALIDATE_IP)) {
            $errors['ethernet_ip'] = 'ethernet_ip formatı geçersiz.';
        }
        if (!empty($wifi_mac) && !preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $wifi_mac)) {
            $errors['wifi_mac'] = 'wifi_mac formatı geçersiz.';
        }
        if (!empty($ethernet_mac) && !preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $ethernet_mac)) {
            $errors['ethernet_mac'] = 'ethernet_mac formatı geçersiz.';
        }

        if (!empty($errors)) {
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        // Aynı device_id ile kayıt var mı?
        $existingReader = Reader::where('device_id', $chip_id)->first();

        if ($existingReader) {
            $existingReader->last_connection = now();
            $existingReader->save();

            // ReaderType ilişkisi kontrolü
            $jobs = [
                'sleep_job' => (new JobBuilder())
                    ->lcd_brightness(25)
                    ->lcd("Turnique", 0, 0)
                    ->lcd("-no type", 1, 0)
                    ->data(),
                'response_wait_job' => [],
                'abort_job' => [],
            ];

            if ($existingReader->type_id && $existingReader->type) {
                $jobs = [
                    'sleep_job' => is_string($existingReader->type->sleep_job)
                        ? json_decode($existingReader->type->sleep_job, true) ?? []
                        : ($existingReader->type->sleep_job ?? []),
                    'response_wait_job' => is_string($existingReader->type->response_wait_job)
                        ? json_decode($existingReader->type->response_wait_job, true) ?? []
                        : ($existingReader->type->response_wait_job ?? []),
                    'abort_job' => is_string($existingReader->type->abort_job)
                        ? json_decode($existingReader->type->abort_job, true) ?? []
                        : ($existingReader->type->abort_job ?? []),
                ];
            }

            return response()->json([
                'success' => true,
                'jobs' => $jobs,
            ]);
        }

        // Unknown [number] adını bul
        $lastUnknown = Reader::where('name', 'like', 'Unknown %')
            ->orderByRaw('CAST(SUBSTRING(name, 9) AS UNSIGNED) DESC')
            ->first();

        if ($lastUnknown && preg_match('/Unknown (\d+)/', $lastUnknown->name, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        $name = "Unknown {$nextNumber}";

        // Reader kaydını oluştur
        $reader = Reader::create([
            'name' => $name,
            'wifi_mac' => $wifi_mac,
            'device_id' => $chip_id,
            'wifi_ip' => $wifi_ip,
            'ethernet_ip' => $ethernet_ip,
            'ethernet_mac' => $ethernet_mac,
            'public_ip' => $public_ip,
            'last_connection' => now(),
        ]);

        // ReaderType job sütunlarını jobs içinde gönder
        $jobs = [
            'sleep_job' => (new JobBuilder())
                ->lcd_brightness(25)
                ->lcd("Turnique", 0, 0)
                ->lcd("-no type", 1, 0)
                ->data(),
            'response_wait_job' => [],
            'abort_job' => [],
        ];

        return response()->json([
            'success' => true,
            'jobs' => $jobs,
        ]);
    }


    public function reader_updates(Request $request)
    {
        // chip_id zorunlu, diğer alanlar opsiyonel
        $validated = $request->validate([
            'chip_id' => ['required', 'string', 'max:255'],
        ]);

        $chip_id = $validated['chip_id'];

        // Opsiyonel alanları al
        $wifi_ip = $request->input('wifi_ip');
        $wifi_mac = $request->input('wifi_mac');
        $ethernet_ip = $request->input('ethernet_ip');
        $ethernet_mac = $request->input('ethernet_mac');
        $public_ip = $request->ip();

        // Format kontrolleri (varsa)
        $errors = [];

        if (!empty($wifi_ip) && !filter_var($wifi_ip, FILTER_VALIDATE_IP)) {
            $errors['wifi_ip'] = 'wifi_ip formatı geçersiz.';
        }
        if (!empty($ethernet_ip) && !filter_var($ethernet_ip, FILTER_VALIDATE_IP)) {
            $errors['ethernet_ip'] = 'ethernet_ip formatı geçersiz.';
        }
        if (!empty($wifi_mac) && !preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $wifi_mac)) {
            $errors['wifi_mac'] = 'wifi_mac formatı geçersiz.';
        }
        if (!empty($ethernet_mac) && !preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $ethernet_mac)) {
            $errors['ethernet_mac'] = 'ethernet_mac formatı geçersiz.';
        }

        if (!empty($errors)) {
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        // Aynı device_id ile kayıt var mı?
        $existingReader = Reader::where('device_id', $chip_id)->first();

        if ($existingReader) {
            // Gelen alanları null dahil güncelle
            $updateData = [
                'wifi_ip' => $wifi_ip,
                'wifi_mac' => $wifi_mac,
                'ethernet_ip' => $ethernet_ip,
                'ethernet_mac' => $ethernet_mac,
                'public_ip' => $public_ip,
                'last_connection' => now(),
            ];

            $existingReader->update($updateData);

            // ReaderType ilişkisi kontrolü
            $jobs = [
                'sleep_job' => (new JobBuilder())
                    ->lcd_brightness(25)
                    ->lcd("Turnique", 0, 0)
                    ->lcd("-no type", 1, 0)
                    ->data(),
                'response_wait_job' => [],
                'abort_job' => [],
            ];

            if ($existingReader->type_id && $existingReader->type) {
                $jobs = [
                    'sleep_job' => is_string($existingReader->type->sleep_job)
                        ? json_decode($existingReader->type->sleep_job, true) ?? []
                        : ($existingReader->type->sleep_job ?? []),
                    'response_wait_job' => is_string($existingReader->type->response_wait_job)
                        ? json_decode($existingReader->type->response_wait_job, true) ?? []
                        : ($existingReader->type->response_wait_job ?? []),
                    'abort_job' => is_string($existingReader->type->abort_job)
                        ? json_decode($existingReader->type->abort_job, true) ?? []
                        : ($existingReader->type->abort_job ?? []),
                ];
            }

            return response()->json([
                'success' => true,
                'jobs' => $jobs,
            ]);
        }

        return response()->json([
            'success' => false,
            'jobs' => [],
        ]);
    }

    public function reader_process(Request $request)
    {
        $validated = $request->validate([
            'chip_id' => ['required', 'string', 'max:255'],
            'card_id' => ['required', 'string', 'min:6'],
        ]);

        $chip_id = $validated['chip_id'];
        $card_id = $validated['card_id'];

        // MC522 kart formatı kontrolü: en az 6 karakter, sadece hex karakterler (0-9, a-f, A-F)
        if (!preg_match('/^[0-9A-Fa-f]{6,}$/', $card_id)) {
            return response()->json([
                'success' => false,
                'message' => 'card_id formatı geçersiz. En az 6 karakter ve sadece hex karakterler içermelidir.',
            ], 422);
        }

        $existingReader = Reader::where('device_id', $chip_id)->first();

        if ($existingReader) {
            // Reader type kontrolü
            if (!$existingReader->type_id || !$existingReader->type) {
                $job = (new JobBuilder())
                    ->lcd_brightness(255)
                    ->lcd("Abort   ", 0, 0)
                    ->lcd("        ", 1, 0)
                    ->buzzer([['NOTE_G5', 3], [0, 3], ['NOTE_G5', 3], [0, 3], ['NOTE_G5', 3]])
                    ->delay(5000)
                    ->data();

                return response()->json([
                    'success' => false,
                    'job' => $job
                ]);
            }

            // ReaderHistory kaydı oluştur
            $readerHistory = $existingReader->readerHistories()->create([
                'card_id' => null, // Kart ID henüz bilinmiyor
                'request_content' => json_encode($validated),
                'process_module' => $existingReader->type->which_module,
            ]);

            // Dinamik olarak method çağırma
            $moduleMethod = $existingReader->type->which_module;
            $readerProcessController = new ReaderProcessController();

            if (method_exists($readerProcessController, $moduleMethod)) {
                $result = $readerProcessController->{$moduleMethod}($existingReader, $card_id);
                if(isset($result['job'])){
                    $result['job'] = is_string($result['job'])
                        ? json_decode($result['job'], true) ?? []
                        : ($result['job'] ?? []);
                }
                return response()->json($result);
            } else {
                $abort_job = [];
                if (isset($existingReader->type->abort_job)) {
                    $abort_job = is_string($existingReader->type->abort_job)
                        ? json_decode($existingReader->type->abort_job, true) ?? []
                        : ($existingReader->type->abort_job ?? []);
                }

                return response()->json([
                    'success' => false,
                    'job' => $abort_job,
                ], 200);
            }
        }

        return response()->json([
            'success' => false,
            'job' => [],
        ], 404);
    }
}
