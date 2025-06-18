<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login_index.php');
    exit();
}
include 'conexao.php';
$term = isset($_GET['q']) ? $_GET['q'] : '';
$sql = "SELECT id, usuario, email, telefone FROM usuarios WHERE usuario LIKE :t OR email LIKE :t";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':t', '%'.$term.'%');
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Área Administrativa</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>
<h1>Área Administrativa</h1>
<form method="get">
<input type="text" name="q" placeholder="Pesquisar usuário" value="<?php echo htmlspecialchars($term); ?>">
<button type="submit">Pesquisar</button>
</form>
<table>
<tr><th>ID</th><th>Usuário</th><th>Email</th><th>Telefone</th></tr>
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
