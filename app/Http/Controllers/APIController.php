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
            $data = $request()->collect();
            Mail::to($request->user())->send(new sendMail($data));

            return response()->json($request->collect()->toJson());
        } catch (Exception $e) {

            Log::error(printf("Errore: email non inviata. Messaggio di errore: %s - traccia: %s", [$e->getMessage(), $e->getTraceAsString()]));

            return response()->json("Si è verificato un errore. Messaggio non inviato. Se il problema persiste contattateci tramite i nostri canali social");
        }
    }
}
