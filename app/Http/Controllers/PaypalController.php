<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

// Import the class namespaces first, before using it directly
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success'),
                "cancel_url" => route('cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => $request->amount
                    ]
                ]
            ]
        ]);

        if(isset($response['id']) && $response['id']!=null) {
            foreach($response['links'] as $link) {
                if($link['rel'] === 'approve') {

                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        // dd($response);

        if(isset($response['status']) && $response['status'] === 'COMPLETED') {

            //Dati da inserire nel database
            $payment = new Payment();
            $payment->payment_id = $response['id'];
            $payment->payer_name = $response['payer']['name']['given_name'];
            $payment->payer_surname = $response['payer']['name']['surname'];
            $payment->payer_email = $response['payer']['email_address'];
            $payment->payer_address = json_encode($response['purchase_units'][0]['shipping']['address']);
            $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $payment->payment_method = "PayPal";
            $payment->payment_status = $response['status'];
            $payment->save();

            return "Pagamento effettuato.";

            // unset($_SESSION['amount']);

            // Per formattare l'indirizzo completo
            // $fullAddress = implode(', ', [
            //     $payment->payer_address['address_line_1'],
            //     $payment->payer_address['admin_area_2'],
            //     $payment->payer_address['postal_code'],
            //     $payment->payer_address['country_code']
            // ]);

        } else {
            return redirect()->route('cancel');
        }
    }   

    public function cancel()
    {
        return "Pagamento annullato.";
    }
}
