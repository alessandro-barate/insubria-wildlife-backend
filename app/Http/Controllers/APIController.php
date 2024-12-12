<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class APIController extends Controller
{
    public function sendMail(Request $request)
    {
        $data = $request()->collect();

        Mail::to($request->user())->send(new sendMail($data));


        return response()->json($request->collect()->toJson());
    }
}
