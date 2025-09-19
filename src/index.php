<?php
$symbol = isset($_GET['symbol']) ? strtoupper(trim($_GET['symbol'])) : '';
$quote = null; $error = null;

$apiBase = getenv('API_BASE') ?: 'http://nginx';

if ($symbol !== '') {
    $url = $apiBase . '/api/quote?symbol=' . urlencode($symbol);
    $ctx = stream_context_create(['http' => ['method' => 'GET','timeout' => 5]]);
    $resp = @file_get_contents($url, false, $ctx);
    if ($resp === false) {
        $error = 'Falha ao consultar API';
    } else {
        $data = json_decode($resp, true);
        if (json_last_error() === JSON_ERROR_NONE) $quote = $data;
        else $error = 'Resposta inválida da API';
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <title>Bolsa de Valores (Mock)</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    form { margin-bottom: 16px; }
    input, button { padding: 6px 10px; font-size: 16px; }
    table { border-collapse: collapse; width: 100%; margin-top: 12px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background: #f5f5f5; }
    .error { color: #b00; }
  </style>
</head>
<body>
  <h1>Consulta de Cotações</h1>
  <form method="GET">
    <input type="text" name="symbol" placeholder="Ex: PETR4" value="<?= htmlspecialchars($symbol) ?>" />
    <button type="submit">Buscar</button>
  </form>

  <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>

  <?php if ($quote): ?>
    <table>
      <tr><th>Símbolo</th><th>Preço</th><th>Variação (%)</th><th>Atualizado em</th></tr>
      <tr>
        <td><?= htmlspecialchars($quote['symbol']) ?></td>
        <td>R$ <?= number_format($quote['price'], 2, ',', '.') ?></td>
        <td style="color: <?= $quote['change_pct'] >= 0 ? 'green' : 'red' ?>">
          <?= ($quote['change_pct'] >= 0 ? '+' : '') . number_format($quote['change_pct'], 2, ',', '.') ?>%
        </td>
        <td><?= htmlspecialchars($quote['updated_at']) ?></td>
      </tr>
    </table>
  <?php endif; ?>
</body>
</html>
