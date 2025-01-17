<!-- The only way to do great work is to love what you do. - Steve Jobs -->

{{-- Qui testo da visualizzare in mail che arriva --}}
{{-- Hai ricevuto una comunicazione dal sito
E' stata mandata da {{ $NomeMittente }} {{ $CognomeMittente }} {{ $EmailMittente }} {{ $TestoMessaggioMittente }} --}}


<!DOCTYPE html>
<html>
<head>
    <title>Nuova comunicazione dal sito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .message-container {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .sender-info {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Nuova comunicazione dal form del sito</h1>
    
    <div class="sender-info">
        <p><span class="field-label">Nome:</span> {{ $NomeMittente }}</p>
        <p><span class="field-label">Cognome:</span> {{ $CognomeMittente }}</p>
        <p><span class="field-label">Email:</span> {{ $EmailMittente }}</p>
    </div>

    <div class="message-container">
        <h2>Messaggio:</h2>
        <p>{{ $TestoMessaggioMittente }}</p>
    </div>
</body>
</html>
