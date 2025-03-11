<!-- The only way to do great work is to love what you do. - Steve Jobs -->

{{-- Qui testo da visualizzare in mail che arriva --}}
{{-- Hai ricevuto una comunicazione dal sito
E' stata mandata da {{ $NomeMittente }} {{ $CognomeMittente }} {{ $EmailMittente }} {{ $TestoMessaggioMittente }} --}}


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuova comunicazione dal sito</title>
    <!--[if !mso]><!-->
    <style>
        @font-face {
            font-family: "Montserrat";
            src: url('http://127.0.0.1:8000/fonts/Montserrat-Regular.woff') format('woff'),     /* Cambiare localhost con il dominio */
            url('http://127.0.0.1:8000/fonts/Montserrat-Regular.woff2') format('woff2'),       /* Cambiare localhost con il dominio */
            url('http://127.0.0.1:8000/fonts/Montserrat-Regular.ttf') format('truetype');      /* Cambiare localhost con il dominio */
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: "Montserrat", sans-serif;
            line-height: 1.6;
            color: #fc8600c0;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(90deg, rgba(0,0,0,1) 60%, rgb(119, 71, 3) 100%);
        }

        h1 {
            font-size: 35px;
            text-align: center; 
        }

        hr {
            width: 100%;
            border: 1px solid;
            color: #ffffff9c;
        }
        .message-container {
            border: 1px solid #ffffff9c;
            padding: 15px;
            margin-top: 50px;
            border-radius: 10px;
        }

        .message-container h2 {
            margin-top: 10px;
            text-align: center;
        }
        .sender-info {
            width: 90%;
            margin: 0 auto;
            text-align: center;
        }

        .field-label {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <h1>Nuova comunicazione dal form del sito</h1>
    
    <div class="sender-info">
        <hr>
        <p><span class="field-label">Nome:</span> {{ $NomeMittente }}</p>
        <hr>
        <p><span class="field-label">Cognome:</span> {{ $CognomeMittente }}</p>
        <hr>
        <p><span class="field-label">Email:</span> {{ $EmailMittente }}</p>
        <hr>
    </div>

    <div class="message-container">
        <h2>Messaggio:</h2>
        <p>{{ $TestoMessaggioMittente }}</p>
    </div>
</body>

{{-- <body style="margin: 0; padding: 0; width: 100%; font-family: Arial, Helvetica, sans-serif; line-height: 1.6;">
    <!-- Container principale -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 1000px; margin: 0 auto; background-color: #000000;">
        <tr>
            <td style="padding: 20px; color: #fc8600;">
                <!-- Titolo -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="text-align: center; padding-bottom: 20px;">
                            <h1 style="font-size: 35px; font-family: Arial, Helvetica, sans-serif; margin: 0; color: #fc8600;">Nuova comunicazione dal form del sito</h1>
                        </td>
                    </tr>
                </table>
                
                <!-- Informazioni mittente -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="text-align: center; padding: 0 5%;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr><td height="1" style="background-color: #ffffff; opacity: 0.6; font-size: 1px;">&nbsp;</td></tr>
                            </table>
                            <p style="font-family: Arial, Helvetica, sans-serif; color: #fc8600;"><span style="font-weight: bold;">Nome:</span> {{ $NomeMittente }}</p>
                            
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr><td height="1" style="background-color: #ffffff; opacity: 0.6; font-size: 1px;">&nbsp;</td></tr>
                            </table>
                            <p style="font-family: Arial, Helvetica, sans-serif; color: #fc8600;"><span style="font-weight: bold;">Cognome:</span> {{ $CognomeMittente }}</p>
                            
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr><td height="1" style="background-color: #ffffff; opacity: 0.6; font-size: 1px;">&nbsp;</td></tr>
                            </table>
                            <p style="font-family: Arial, Helvetica, sans-serif; color: #fc8600;"><span style="font-weight: bold;">Email:</span> {{ $EmailMittente }}</p>
                            
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr><td height="1" style="background-color: #ffffff; opacity: 0.6; font-size: 1px;">&nbsp;</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <!-- Contenitore messaggio -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 30px; border: 1px solid #ffffff;">
                    <tr>
                        <td style="padding: 15px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="text-align: center; padding-bottom: 10px;">
                                        <h2 style="font-family: Arial, Helvetica, sans-serif; margin: 0; color: #fc8600;">Messaggio:</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-family: Arial, Helvetica, sans-serif; color: #fc8600;">
                                        <p>{{ $TestoMessaggioMittente }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body> --}}

</html>
