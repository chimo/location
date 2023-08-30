<?php

require '../private/config.php';

if (!isset($_SERVER['HTTP_SECRET']) || $_SERVER['HTTP_SECRET'] !== $config['secret']) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
	exit(0);
}

$dbHost = $config['dbHost'] ?? 'localhost';

$dsn = 'pgsql:host=' . $dbHost . ';dbname=' . $config['dbName'] . ';user=' .
            $config['dbUser'] . ';password=' . $config['dbPassword'];

$pdoConnection = new PDO($dsn);

$coordinates = $pdoConnection->query(
    'SELECT longitude,latitude '
    . 'FROM positions '
    . 'WHERE user_id = 1 '
    . 'ORDER BY time '
    . 'DESC LIMIT 1;'
)->fetch(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($coordinates);

