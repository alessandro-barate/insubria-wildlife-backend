<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Exceptions\ContactFormException;
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

            // Email data
            $data = [
                'name' => $request->input('name'),
                'surname' => $request->input('surname'),
                'mail' => $request->input('mail'),
                'message' => $request->input('message'),
                'token' => $request->header('X-CSRF-TOKEN')
            ];

            // Token validation
            if ($data['token'] !== 'ciao') {
                throw new ContactFormException('Dati non validi');
            }

            $validated = Validator::make($request->all(), [
                'name' => 'required|max:30',
                'surname' => 'required|max:30',
                'mail' => 'required|email:rfc',
                'message' => 'required|min:10|max:500',
            ]);

            // Logging errors
            if ($validated->fails()) {
                Log::error($request->all());

                throw new ContactFormException($validated->errors());
            };

            // Mail address to
            Mail::to(env('MAIL_DEFAULT_TO_ADDRESS'))->send(new sendMail($data));       // Send email to the form user compiler for testing purposes: $request->input('mail')

            return response()->json([
                'status' => 'success',
                'message' => 'Email inviata con successo'
            ]);

        // Catching contact form errors
        } catch (ContactFormException $e) {

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 200);

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

    public function getToken(Request $request) { 

        try {

            //UUID validation
            $validated = Validator::make($request->all(), [
                'myuuid' => 'required|uuid'
            ]);

            if ($validated->fails()) {

                throw new ContactFormException($validated->errors());
            };
        
            // User agent creation
            $userAgent = $request->server('HTTP_USER_AGENT');

            return response()->json([
                'status' => 'success',
                'token' => 'ciao'
            ]);
        
        // Catching token errors
        } catch (Exception $e) {

            Log::error("Token: errore nell'invio dei dati - traccia: %s" . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $data ?? null
            ]);

            return response()->json([
                "status" => "error",
                "message" => "Si è verificato un errore. Se il problema persiste contattateci tramite i nostri canali social"
            ], 422);
        }
    }
}
