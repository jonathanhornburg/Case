<?php

require_once("class/database.class.php");
require_once("class/estoque.class.php");

$con = New Database();
$conexao = $con->getconect();


$estoque = new Estoque($conexao);

$json = '[
    {
        "produto": "10.01.0419",
        "cor": "00",
        "tamanho": "P",
        "deposito": "DEP1",
        "data_disponibilidade": "2023-05-01",
        "quantidade": 15
    },
    {
        "produto": "11.01.0568",
        "cor": "08",
        "tamanho": "P",
        "deposito": "DEP1",
        "data_disponibilidade": "2023-05-01",
        "quantidade": 2
    },
    {
        "produto": "11.01.0568",
        "cor": "08",
        "tamanho": "M",
        "deposito": "DEP1",
        "data_disponibilidade": "2023-05-01",
        "quantidade": 4
    },
    {
        "produto": "11.01.0568",
        "cor": "",
        "tamanho": "G",
        "deposito": "1",
        "data_disponibilidade": "2023-05-01",
        "quantidade": 6
    },
    {
        "produto": "",
        "cor": "08",
        "tamanho": "P",
        "deposito": "DEP1",
        "data_disponibilidade": "2023-08-01",
        "quantidade": 8
    }
]';

try {
    $estoque->atualizarEstoque($json);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}



