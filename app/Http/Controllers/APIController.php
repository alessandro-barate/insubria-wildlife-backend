<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function sendMail()
    {
        return response()->json('ciao');
    }
}
