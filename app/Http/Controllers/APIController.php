<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Exceptions\ContactFormException;
use App\Http\Controllers\Exceptions\TokenValidityException;
use App\Mail\sendMail;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;
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
                'token' => $request->header('X-CSRF-TOKEN'),
                'myuuid' => $request->input('myuuid'),
                'user-agent' => $request->server('HTTP_USER_AGENT')
                // I don't collect the timestamp from the input (client) because I use the server timestamp
            ];

            $validated = Validator::make($request->all() + ['token' => $request->header('X-CSRF-TOKEN')], [
                'name' => 'required|max:30',
                'surname' => 'required|max:30',
                'mail' => 'required|email:rfc',
                'message' => 'required|min:10|max:500',
                'token' => 'required|string',
                'myuuid' => 'required|uuid'
            ]);

            

            // Validation check
            if ($validated->fails()) {

                throw new ContactFormException($validated->errors());
            };

            $decryptedToken = Crypt::decryptString($request->header('X-CSRF-TOKEN'));

            $decryptedToken = explode('§', unserialize($decryptedToken));

            if ($decryptedToken[0] !== $data['myuuid']) {

                throw new TokenValidityException('{
                    "form": "UUID non valido"
                    }');
            }

            if ($decryptedToken[1] !== $data['user-agent']) {

                throw new TokenValidityException('User agent non valido');
            }

            $dateNow = Date::now('Europe/Rome');

            $date = Carbon::createFromFormat('U', $decryptedToken[2], 'Europe/Rome');

            if ($dateNow->diffInMinutes($date, true) > 10 ) {

                throw new TokenValidityException('Tempo tra i timestamp maggiore di 10 minuti');
            }

            // Mail address to
            Mail::to(env('MAIL_DEFAULT_TO_ADDRESS'))->send(new sendMail($data));       // Send email to the form user compiler for testing purposes: $request->input('mail')

            return response()->json([
                'status' => 'success',
                'message' => 'Email inviata con successo'
            ]);

        // Catching contact form errors
        } catch (DecryptException $e) {

            Log::error("Errore generato nella decriptazione del token. Messaggio di errore: %s - traccia: %s" . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                "status" => "error",
                "message" => "Problemi con la gestione dei dati. Se il problema persiste contattateci tramite i nostri canali social",
            ]);

        } catch (ContactFormException $e) {

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
            ], 200);

        } catch (TokenValidityException $e) {

            return response()->json([
                "status" => "error",
                "message" => $e->getMessage()
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

    public function getToken(Request $request) { 

        try {

            //UUID validation
            $validated = Validator::make($request->all(), [
                'myuuid' => 'required|uuid'
            ]);

            Log::error($request->all());

            if ($validated->fails()) {

                throw new ContactFormException($validated->errors());
            };
        
            // User agent creation
            $userAgent = $request->server('HTTP_USER_AGENT');

            // Catching timestamp
            $date = Date::now('Europe/Rome')->format('U');

            $encryptedToken = Crypt::encrypt($request->input('myuuid') . '§' . 
                $userAgent . '§' . $date
            ); 

            return response()->json([
                'status' => 'success',
                'token' => $encryptedToken,
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



    // To debug emails style
    public function previewEmail()
    {
        $data = [
            'NomeMittente' => 'Mario',
            'CognomeMittente' => 'Rossi',
            'EmailMittente' => 'fefwef@efewf.it',
            'TestoMessaggioMittente' => 'Messaggio dal form di contatto del sito,Messaggio dal form di contatto del sito,Messaggio dal form di contatto del sito,Messaggio dal form di contatto del sito,Messaggio dal form di contatto del sito,Messaggio dal form di contatto del sito,Messaggio dal form di contatto del sito,Messaggio dal form di contatto del sito,Messaggio dal form di contatto del sito'
        ];
        
        return view('mail.sendmail', $data);

    }
}
