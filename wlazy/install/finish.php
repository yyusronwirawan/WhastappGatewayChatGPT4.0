<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: two");
    exit();
}

if (!isset($_SESSION['db'])) {
    header("Location: one");
    exit();
}

if (!isset($_POST['base_node']) || !isset($_POST['socket_default'])) {
    header("Location: two");
    exit();
}

$env = 'APP_NAME=WALIX-LAZYCODE
APP_ENV=local
APP_KEY=base64:K+pRPur2SziNlANywfDlU7rNSuXitpIubRfEpAseTdw=
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
BASE_NODE=' . trim($_POST['base_node']) . '
SOCKET_DEFAULT=' . trim($_POST['socket_default']) . '
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
DB_CONNECTION=mysql
DB_HOST=' . trim($_SESSION['db_host']) . '
DB_PORT=' . trim($_SESSION['db_port']) . '
DB_DATABASE=' . trim($_SESSION['db_name']) . '
DB_USERNAME=' . trim($_SESSION['db_username']) . '
DB_PASSWORD=' . trim($_SESSION['db_password']) . '
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
MEMCACHED_HOST=127.0.0.1
TIME_OUT_QR=5
PREFIX=!
ATTEMP_SOCKET=10
IS_MIGRATE_SEED=false
IS_DEMO=false';

file_put_contents('../core/.env', $env);

if ($_POST['socket_default'] == 'false') {
    $index = '<?php header("Location: /app");' . PHP_EOL;
    file_put_contents('../index.php', $index);
}

header('Content-Type: application/json');
http_response_code(200);
echo json_encode(array('message' => 'Done'));

// destroy session
session_unset();
session_destroy();
return;
