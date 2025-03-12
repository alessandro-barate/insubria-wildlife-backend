<!-- The only way to do great work is to love what you do. - Steve Jobs -->


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
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
    </style>
</head>

<body style="font-family: Montserrat, sans-serif; line-height: 1.6; color: #fc8600c0; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(90deg, rgba(0,0,0,1) 60%, rgb(119, 71, 3) 100%);">
    <!-- Main container -->
    <table>
        <tr>
            <td>
                <!-- Title -->
                <table>
                    <tr>
                        <td>
                            <h1 style="font-size: 35px; text-align: center;">Nuova comunicazione dal form del sito</h1>
                        </td>
                    </tr>
                </table>
                <!-- END title -->
                
                <!-- Sender info -->
                <table style="width: 90%; margin: 0 auto; text-align: center;">
                    <tr>
                        <td>
                            <table>
                                <tr><td width="700" height="1" style="background-color: #ffffff; opacity: 0.6; font-size: 0.1px;">&nbsp;</td></tr>
                            </table>
                            <p><span style="font-weight: bold;">Nome:</span> {{ $NomeMittente }}</p>
                            
                            <table>
                                <tr><td width="700" height="1" style="background-color: #ffffff; opacity: 0.6; font-size: 0.1px;">&nbsp;</td></tr>
                            </table>
                            <p><span style="font-weight: bold;">Cognome:</span> {{ $CognomeMittente }}</p>
                            
                            <table>
                                <tr><td width="700" height="1" style="background-color: #ffffff; opacity: 0.6; font-size: 0.1px;">&nbsp;</td></tr>
                            </table>
                            <p><span style="font-weight: bold;">Email:</span> {{ $EmailMittente }}</p>
                            
                            <table>
                                <tr><td width="700" height="1" style="background-color: #ffffff; opacity: 0.6; font-size: 0.1px;">&nbsp;</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- END sender info -->
                
                <!-- Message container -->
                <table style="border: 1px solid #ffffff9c; padding: 15px; margin-top: 50px; border-radius: 10px; margin-top: 50px; text-align: center;">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <h2>Messaggio:</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>{{ $TestoMessaggioMittente }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- END message container -->
            </td>
        </tr>
    </table>
    <!-- END main container -->
</body>

</html>
