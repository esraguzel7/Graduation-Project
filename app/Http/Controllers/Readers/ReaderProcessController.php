<?php

namespace App\Http\Controllers\Readers;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use App\Models\Card;
use Illuminate\Http\Request;

class ReaderProcessController extends Controller
{
    public function new_registration(Reader $reader, string $card_id)
    {
        $cardExists = Card::where('card_id', $card_id)->exists();

        if ($cardExists) {
            return [
                'success' => true,
                'job' => $reader->type->error_job,
            ];
        } else {
            return [
                'success' => true,
                'job' => $reader->type->success_job,
            ];
        }
    }
}
