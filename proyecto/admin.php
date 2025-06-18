<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login_index.php');
    exit();
}

require 'conexao.php';

$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
if ($busca !== '') {
    $stmt = $pdo->prepare("SELECT id, usuario, email FROM usuarios WHERE usuario LIKE :busca OR email LIKE :busca");
    $like = "%" . $busca . "%";
    $stmt->bindParam(':busca', $like, PDO::PARAM_STR);
    $stmt->execute();
} else {
    $stmt = $pdo->query("SELECT id, usuario, email FROM usuarios");
}
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área Administrativa</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Área Administrativa</h1>
        <form method="get" class="search-form">
            <input type="text" name="busca" placeholder="Pesquisar usuário ou email" value="<?php echo htmlspecialchars($busca); ?>">
            <button type="submit">Pesquisar</button>
        </form>
        <table class="user-table">
            <tr><th>ID</th><th>Usuário</th><th>Email</th></tr>
            <?php foreach($usuarios as $u): ?>
            <tr>
                <td><?php echo htmlspecialchars($u['id']); ?></td>
                <td><?php echo htmlspecialchars($u['usuario']); ?></td>
                <td><?php echo htmlspecialchars($u['email']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a class="logout" href="logout.php">Sair</a>
    </div>
</body>
</html>
