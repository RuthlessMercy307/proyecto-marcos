<?php
session_start();

$host   = 'localhost';
$dbname = 'users'; 
$dbUser = 'admin';
$dbPass = 'admin';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header("Location: users.php?error=" . urlencode("Erro na conexão com o banco de dados."));
    exit();
}

$usuario = trim($_POST['usuario']);
$senha   = trim($_POST['senha']);

$sql = "SELECT id, usuario, email, cpf, telefone, senha FROM usuarios WHERE usuario = :usuario";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':usuario', $usuario);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($senha, $dadosUsuario['senha'])) {
        $_SESSION['usuario'] = $dadosUsuario['usuario'];
        $_SESSION['email']   = $dadosUsuario['email']; // pode usar depois se precisar

        header("Location: cliente.php");
        exit();
    } else {
        header('Location: login_index.php?error=' . urlencode("Senha incorreta!"));
        exit();
    }
} else {
    header('Location: login_index.php?error=' . urlencode("Usuário não encontrado!"));
    exit();
}
