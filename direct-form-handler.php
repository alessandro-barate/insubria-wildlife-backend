<?php
// Set headers for cross-origin requests and JSON responses
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: *');

// Handle preflight CORS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only allow POST requests for form submissions
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Solo richieste POST sono accettate'
    ]);
    exit;
}

// Create a log directory if it doesn't exist
$logDir = __DIR__ . '/form_logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}

// Set up log file path
$logFile = $logDir . '/form_submissions.log';

// Get the request body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate essential form fields
if (empty($data['name']) || empty($data['mail']) || empty($data['message'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Campi obbligatori mancanti'
    ]);
    
    // Log the invalid submission attempt
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Tentativo non valido (campi mancanti):\n" . 
                     print_r($data, true) . "\n\n", FILE_APPEND);
    exit;
}

// Log the form submission
file_put_contents($logFile, date('Y-m-d H:i:s') . " - Nuovo invio:\n" . 
                 print_r($data, true) . "\n\n", FILE_APPEND);

// Simple validation for email format
if (!filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Formato email non valido'
    ]);
    
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Email non valida: {$data['mail']}\n\n", FILE_APPEND);
    exit;
}

// Prepare email content with proper formatting
$to = "insubria.wildlife@gmail.com";
$subject = "Informazioni da " . htmlspecialchars($data['name'] . ' ' . ($data['surname'] ?? '')) . " - Insubria Wildlife";

// Create a formatted HTML message
$htmlMessage = "
<html>
<head>
  <title>Nuovo messaggio dal form di contatto</title>
  <style>
    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
    h2 { color: #4a7c59; }
    .info { margin-bottom: 20px; }
    .label { font-weight: bold; }
    .message { background-color: #f5f5f5; padding: 15px; border-left: 4px solid #4a7c59; }
  </style>
</head>
<body>
  <div class='container'>
    <h2>Nuovo messaggio dal sito Insubria Wildlife</h2>
    
    <div class='info'>
      <p><span class='label'>Nome:</span> " . htmlspecialchars($data['name']) . "</p>
      <p><span class='label'>Cognome:</span> " . htmlspecialchars($data['surname'] ?? '') . "</p>
      <p><span class='label'>Email:</span> " . htmlspecialchars($data['mail']) . "</p>
    </div>
    
    <div class='message'>
      <p><span class='label'>Messaggio:</span></p>
      <p>" . nl2br(htmlspecialchars($data['message'])) . "</p>
    </div>
  </div>
</body>
</html>
";

// Create plain text version as fallback
$textMessage = "Nome: " . $data['name'] . "\n" .
               "Cognome: " . ($data['surname'] ?? '') . "\n" .
               "Email: " . $data['mail'] . "\n\n" .
               "Messaggio:\n" . $data['message'];

// Create email headers for HTML email with proper encoding
$boundary = md5(time());
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
$headers .= "From: Insubria Wildlife <contatti@insubriawildlife.com>\r\n";
$headers .= "Reply-To: " . $data['mail'] . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "Precedence: bulk\r\n";
$headers .= "Message-ID: <" . time() . rand(1000, 9999) . "@insubriawildlife.com>\r\n";
$headers .= "Date: " . date("r") . "\r\n";

// Multipart message preparation
$message = "--{$boundary}\r\n";
$message .= "Content-Type: text/plain; charset=UTF-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $textMessage . "\r\n\r\n";  // // Text version already existing

$message .= "--{$boundary}\r\n";
$message .= "Content-Type: text/html; charset=UTF-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $htmlMessage . "\r\n\r\n";  // HTML version already existing

$message .= "--{$boundary}--";

// Send email using PHP's mail() function
$mailResult = mail($to, $subject, $message, $headers);

// Log whether the email was sent successfully
file_put_contents($logFile, date('Y-m-d H:i:s') . " - Tentativo invio email: " . 
                 ($mailResult ? "RIUSCITO" : "FALLITO") . "\n\n", FILE_APPEND);

// Return appropriate response based on email sending result
if ($mailResult) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Messaggio ricevuto e inviato con successo'
    ]);
} else {
    // Log the failure but still report success to the user
    // This prevents showing errors to users while still tracking the issue
    echo json_encode([
        'status' => 'success',
        'message' => 'Messaggio ricevuto con successo'
    ]);
    
    // Add more detailed error information to the log
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - DETTAGLIO ERRORE EMAIL: Possibile problema " . 
                     "con la configurazione del server mail.\n\n", FILE_APPEND);
}