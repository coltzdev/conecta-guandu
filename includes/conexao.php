<?php

$arquivoConfiguracao = __DIR__ . '/config.local.php';

if (!file_exists($arquivoConfiguracao)) {
    die('Arquivo de configuração do banco de dados não encontrado.');
}

$configuracao = require $arquivoConfiguracao;

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $configuracao['host'],
    $configuracao['porta'],
    $configuracao['banco']
);

try {
    $conexao = new PDO(
        $dsn,
        $configuracao['usuario'],
        $configuracao['senha'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    error_log($e->getMessage());

    die('Não foi possível conectar ao banco de dados.');
}