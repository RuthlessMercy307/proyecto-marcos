<?php
include 'conexao.php';
$search = isset($_GET['q']) ? $_GET['q'] : '';
$sql = "SELECT nome, descricao, preco_p, preco_m, preco_g, imagem FROM pizzas WHERE nome LIKE :search";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search', '%'.$search.'%');
$stmt->execute();
$pizzas = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pizzas[] = [
        'name' => $row['nome'],
        'description' => $row['descricao'],
        'image' => 'pizzas/'.$row['imagem'],
        'sizes' => [
            ['name' => 'Pequena', 'price' => (float)$row['preco_p']],
            ['name' => 'Média', 'price' => (float)$row['preco_m']],
            ['name' => 'Grande', 'price' => (float)$row['preco_g']]
        ]
    ];
}
header('Content-Type: application/json');
echo json_encode($pizzas);
?>
