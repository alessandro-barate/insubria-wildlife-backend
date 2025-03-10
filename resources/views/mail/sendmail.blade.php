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
    <style>
        @font-face {
            font-family: "Montserrat";
            src: url('http://127.0.0.1:8000/fonts/Montserrat-Regular.ttf') format('truetype');
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
            background-color: rgba(0, 0, 0, 0.95);
        }

        h1 {
            font-size: 40px;
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
</html>
