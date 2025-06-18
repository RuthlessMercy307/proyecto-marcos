<?php
require 'conexao.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT nome, descricao, preco, imagem FROM pizzas");
    $pizzas = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pizzas[] = [
            'name' => $row['nome'],
            'description' => $row['descricao'],
            'price' => (float)$row['preco'],
            'image' => 'pizzas/' . $row['imagem'],
            'sizes' => [
                ['name' => 'Pequena', 'price' => (float)$row['preco']],
                ['name' => 'Média', 'price' => (float)$row['preco'] * 2.12],
                ['name' => 'Grande', 'price' => (float)$row['preco'] * 2.84]
            ]
        ];
    }
    echo json_encode($pizzas);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
