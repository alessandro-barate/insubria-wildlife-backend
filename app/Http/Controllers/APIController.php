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
            $data = [
                'name' => $request->input('name'),
                'surname' => $request->input('surname'),
                'mail' => $request->input('mail'),
                'message' => $request->input('message')
            ];

            // For debug
            Log::info('Dati ricevuti:', $data);

            Mail::to($request->input('mail'))->send(new sendMail($data));

            return response()->json([
                'status' => 'success',
                'message' => 'Email inviata con successo'
            ]);

        } catch (Exception $e) {

            Log::error("Errore: email non inviata. Messaggio di errore: %s - traccia: %s" . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            'data' => $data ?? null
        ]);

            return response()->json([
                "status" => "error",
                "message" => "Si è verificato un errore. Messaggio non inviato. Se il problema persiste contattateci tramite i nostri canali social"], 500);
        }
    }
}
