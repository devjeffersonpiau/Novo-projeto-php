<?php
header('Content-Type: application/json; charset=utf-8');

$symbol = isset($_GET['symbol']) ? strtoupper(trim($_GET['symbol'])) : '';
if ($symbol === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Parâmetro symbol é obrigatório']);
    exit;
}

$seed  = hexdec(substr(sha1($symbol), 0, 8));
mt_srand($seed);
$base  = mt_rand(1000, 10000) / 100;
$chg   = mt_rand(-300, 300) / 100;
$price = round($base * (1 + $chg / 100), 2);

echo json_encode([
    'symbol'      => $symbol,
    'price'       => $price,
    'change_pct'  => round($chg, 2),
    'updated_at'  => date('Y-m-d H:i:s'),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);