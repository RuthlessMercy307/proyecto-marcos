<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'admin') {
    header('Location: login_index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $imagemPath = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $dir = 'pizzas/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $base = basename($_FILES['imagem']['name']);
        $target = $dir . $base;
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target)) {
            $imagemPath = $target;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $preco, $imagemPath]);
}

header('Location: admin.php');
exit();
