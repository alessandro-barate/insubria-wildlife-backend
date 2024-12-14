<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class APIController extends Controller
{
    public function sendMail(Request $request)
    {
        try {
            $data = $request->collect();
            Mail::to(env("MAIL_DEFAULT_TO_ADDRESS"))->send(new sendMail($data));

            return response()->json("Grazie di averci contattato, abbiamo ricevuto il tuo messaggio. Ti risponderemo il prima possibile.");
        } catch (Exception $e) {

            Log::error("Errore: email non inviata. Messaggio di errore: {s} - traccia: {e}", ['s' => $e->getMessage(), 'e' => $e->getTraceAsString()]);

            return response()->json("Si è verificato un errore. Messaggio non inviato. Se il problema persiste contattateci tramite i nostri canali social.");
        }
    }
}
