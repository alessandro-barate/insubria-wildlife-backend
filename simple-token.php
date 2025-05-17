<?php
// Imposta header per API JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');

// Ottieni l'UUID dalla richiesta
$uuid = $_GET['myuuid'] ?? '';

// Crea un token semplice ma funzionale
$token = base64_encode(json_encode([
    'uuid' => $uuid,
    'agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
    'time' => time()
]));

// Restituisci una risposta di successo
echo json_encode([
    'status' => 'success',
    'token' => $token
]);