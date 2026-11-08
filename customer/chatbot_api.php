<?php
header('Content-Type: application/json');

$apiKey = getenv('GROQ_API_KEY');;
$model  = 'openai/gpt-oss-20b';

$input   = json_decode(file_get_contents('php://input'), true);
$message = trim($input['message'] ?? '');

if ($message === '') {
    echo json_encode(['reply' => 'Pesan kosong.']);
    exit;
}

if ($apiKey === 'GANTI_DENGAN_KEY_GROQ' || $apiKey === '') {
    echo json_encode(['reply' => 'API key belum diisi di chatbot_api.php.']);
    exit;
}

if (!function_exists('curl_init')) {
    echo json_encode(['reply' => 'Ekstensi cURL belum aktif di PHP (Laragon > PHP > Extensions > curl).']);
    exit;
}

$systemPrompt = 'Kamu adalah asisten ramah untuk RESERVIN, aplikasi booking salon. '
    . 'Jawab dalam bahasa Indonesia, singkat dan jelas (maksimal 4 kalimat). '
    . 'Topik: perawatan rambut, tren model rambut, warna rambut, creambath, dan kecantikan. '
    . 'Cara reservasi: menu Reservasi, pilih salon, layanan, stylist, tanggal dan jam. '
    . 'Ganti jadwal dan invoice ada di menu Riwayat. '
    . 'Jangan mengarang harga, stok, atau jam buka salon. Kalau tidak tahu, sarankan menghubungi salon. '
    . 'Kalau pertanyaan di luar topik salon, tolak dengan sopan.';

$payload = [
    'model'       => $model,
    'messages'    => [
        ['role' => 'system', 'content' => $systemPrompt],
        ['role' => 'user',   'content' => $message],
    ],
    'temperature' => 0.7,
    'max_tokens'  => 500,
];

$ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ],
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_SSL_VERIFYPEER => false, // hanya untuk Laragon lokal
    CURLOPT_TIMEOUT        => 30,
]);

$response = curl_exec($ch);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($response === false) {
    echo json_encode(['reply' => 'Gagal menghubungi AI: ' . $curlErr]);
    exit;
}

$data = json_decode($response, true);

if (isset($data['error'])) {
    echo json_encode(['reply' => 'Error dari AI: ' . ($data['error']['message'] ?? 'tidak diketahui')]);
    exit;
}

$reply = $data['choices'][0]['message']['content'] ?? 'Maaf, AI tidak memberi jawaban.';
echo json_encode(['reply' => $reply]);