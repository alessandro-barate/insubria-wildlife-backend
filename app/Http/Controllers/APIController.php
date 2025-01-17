<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

            $validated = Validator::make($request->all(), [
                'name' => 'required|max:30',
                'surname' => 'required|max:30',
                'mail' => 'required|email:rfc',
                'body' => 'required|max:500',
            ]);

            if ($validated->fails()) {
                // throw new Exception('Controllare ')
                Log::error($request->all());
            };

            Mail::to(env('MAIL_DEFAULT_TO_ADDRESS'))->send(new sendMail($data));       // Send email to the form user compiler for testing purposes: $request->input('mail')

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
                "message" => "Si è verificato un errore. Messaggio non inviato. Se il problema persiste contattateci tramite i nostri canali social"
            ], 422);
        }
    }
}
