<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'admin') {
    header('Location: login_index.php');
    exit();
}

$produtos = $pdo->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Administração de Produtos</h1>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <input type="text" name="nome" placeholder="Nome" required>
        <textarea name="descricao" placeholder="Descrição" required></textarea>
        <input type="number" step="0.01" name="preco" placeholder="Preço" required>
        <input type="file" name="imagem" accept="image/*" required>
        <button type="submit">Adicionar Produto</button>
    </form>
    <h2>Produtos Cadastrados</h2>
    <table border="1" cellpadding="5">
        <tr><th>Imagem</th><th>Nome</th><th>Preço</th></tr>
        <?php foreach ($produtos as $p): ?>
            <tr>
                <td><?php if($p['imagem']) echo "<img src='{$p['imagem']}' width='60'>"; ?></td>
                <td><?php echo htmlspecialchars($p['nome']); ?></td>
                <td>R$<?php echo number_format($p['preco'],2,',','.'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="logout.php">Sair</a>
</body>
</html>
