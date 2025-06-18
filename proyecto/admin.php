<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: login_index.php");
    exit();
}

include 'conexao.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT id, usuario, email, telefone FROM usuarios WHERE usuario LIKE :search");
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("SELECT id, usuario, email, telefone FROM usuarios");
}
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <h1>Área Administrativa</h1>
    <form method="get" class="search-form">
        <input type="text" name="search" placeholder="Pesquisar usuário" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Pesquisar</button>
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Email</th>
            <th>Telefone</th>
        </tr>
        <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?php echo htmlspecialchars($u['id']); ?></td>
            <td><?php echo htmlspecialchars($u['usuario']); ?></td>
            <td><?php echo htmlspecialchars($u['email']); ?></td>
            <td><?php echo htmlspecialchars($u['telefone']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="logout.php">Sair</a>
</body>
</html>
