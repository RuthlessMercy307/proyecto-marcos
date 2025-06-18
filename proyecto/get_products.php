<?php
include 'conexao.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT id, nome, descricao, preco, imagem FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($produtos);
