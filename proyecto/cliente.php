<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Santa Gula - Pedidos</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header class="header">
        <div class="container">
            <h1 class="logo">
                <img src="imgs/stg.jpeg" alt="Delicias Gourmet" class="logo-image">
               Santa Gula
            </h1>
            <div class="menu-hamburguer">☰</div>
            <nav class="nav">
                <a href="#ofertas" class="nav-link">Ofertas</a>
                <a href="#contacto" class="nav-link">Contato</a>
                <a href="dados.php" class="nav-link">Meus Dados</a>
                <?php if ($_SESSION['usuario'] === 'admin'): ?>
                <a href="admin.php" class="nav-link">Admin</a>
                <?php endif; ?>
                <a href="logout.php" class="nav-link active">Sair</a>
            </nav>
        </div>
    </header>
    <div class="search-bar">
        <div class="container">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Pesquisar Delicias">
            </div>
        </div>
    </div>

    <main class="container">
        <div class="menu-grid" id="menuContainer">
        </div>
    </main>

    <div class="cart-floating">
        <button class="cart-button" onclick="toggleCart()">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count">0</span>
        </button>
    </div>

    <div class="cart-sidebar">
        <div class="cart-header">
            <h2>Seu Pedido</h2>
            <button class="close-cart" onclick="toggleCart()">&times;</button>
        </div>
        <ul class="cart-items" id="cartItems"></ul>
        <div class="cart-total">
            Total: R$<span id="cartTotal">0.00</span>
        </div>
        <button class="checkout-button" onclick="realizarPedido()">Finalizar Compra</button>
    </div>

    <script src="js/index.js"></script>
</body>
</html>
