<?php
// Configuration stays outside the public document root.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$localFile = __DIR__ . '/../config/database.local.php';
$local = is_file($localFile) ? require $localFile : [];
$config = [];
foreach (['host' => '127.0.0.1', 'port' => 3306, 'name' => 'dlstore', 'user' => 'root', 'password' => ''] as $key => $default)  {
    $environment = getenv('DB_' . strtoupper($key));
    $config[$key] = $environment !== false ? $environment : ($local[$key] ?? $default);
}
try  {
    $conexao = new mysqli($config['host'], $config['user'], $config['password'], $config['name'], (int) $config['port']);
    $conexao->set_charset('utf8mb4');
}
catch (mysqli_sql_exception $error)  {
    error_log('DLStore: database connection failed.');
    http_response_code(503);
    exit('Banco indisponível. Confira a configuração local e a importação do esquema no README.');
}
