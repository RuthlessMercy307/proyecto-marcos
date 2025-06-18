<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header('Location: login_index.php');
    exit();
}

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $id = (int)$_POST['delete'];
        $stmt = $pdo->prepare('DELETE FROM pizzas WHERE id = ?');
        $stmt->execute([$id]);
    } else {
        $nome = $_POST['nome'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $imagem = '';

        if (!empty($_FILES['imagem']['name'])) {
            $targetDir = 'pizzas/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $nomeArquivo = basename($_FILES['imagem']['name']);
            $caminho = $targetDir . $nomeArquivo;
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
                $imagem = $nomeArquivo;
            }
        }

        $stmt = $pdo->prepare('INSERT INTO pizzas (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)');
        $stmt->execute([$nome, $descricao, $preco, $imagem]);
    }
}

$pizzas = $pdo->query('SELECT * FROM pizzas')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pizzas</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<h1>Gerenciar Pizzas</h1>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="text" name="descricao" placeholder="Descrição" required>
    <input type="number" step="0.01" name="preco" placeholder="Preço" required>
    <input type="file" name="imagem" required>
    <button type="submit">Adicionar Pizza</button>
</form>
<table>
    <tr><th>Imagem</th><th>Nome</th><th>Preço</th><th>Ações</th></tr>
    <?php foreach ($pizzas as $pizza): ?>
    <tr>
        <td><img src="pizzas/<?php echo htmlspecialchars($pizza['imagem']); ?>" width="60"></td>
        <td><?php echo htmlspecialchars($pizza['nome']); ?></td>
        <td>R$ <?php echo number_format($pizza['preco'],2,',','.'); ?></td>
        <td>
            <form method="POST" style="display:inline">
                <input type="hidden" name="delete" value="<?php echo $pizza['id']; ?>">
                <button type="submit">Excluir</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
