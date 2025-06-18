
let menuItems = [];

let cart = [];
let total = 0;

function renderMenu() {
    const menuContainer = document.getElementById('menuContainer');
    menuContainer.innerHTML = '';

    menuItems.forEach(item => {
        const menuItem = document.createElement('div');
        menuItem.className = 'menu-item';
        
        let priceHTML = '';
        if(item.sizes) {
            priceHTML = `
                <div class="size-options">
                    ${item.sizes.map(size => `
                        <button class="size-button" 
                                onclick="addToCart('${item.name} - ${size.name}', ${size.price})">
                            ${size.name} - R$${size.price.toFixed(2).replace('.', ',')}
                        </button>
                    `).join('')}
                </div>
            `;
        } else {
            priceHTML = `
                <div class="item-footer">
                    <span class="item-price">R$${item.price.toFixed(2).replace('.', ',')}</span>
                    <button class="add-to-cart" onclick="addToCart('${item.name}', ${item.price})">
                        Adicionar <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            `;
        }
        menuItem.innerHTML = `
            <div class="item-image" style="background-image: url('${item.image}')"></div>
            <div class="item-content">
                <h3 class="item-title">${item.name}</h3>
                <p class="item-description">${item.description}</p>
                ${priceHTML}
            </div>
        `;
        menuContainer.appendChild(menuItem);
    });
}

function addToCart(name, price) {
    const existingItem = cart.find(item => item.name === name);
    
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({ name, price, quantity: 1 });
    }
    
    total += price;
    updateCart();
}

function updateCart() {
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    const cartCount = document.querySelector('.cart-count');
    
    cartItems.innerHTML = '';
    cart.forEach(item => {
        const li = document.createElement('li');
        li.className = 'cart-item';
        li.innerHTML = `
            <span>${item.name} (x${item.quantity})</span>
            <div>
                <button onclick="adjustQuantity('${item.name}', -1)">-</button>
                <span>${(item.price * item.quantity).toFixed(2)}</span>
                <button onclick="adjustQuantity('${item.name}', 1)">+</button>
            </div>
        `;
        cartItems.appendChild(li);
    });
    
    cartTotal.textContent = total.toFixed(2);
    cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
}

function adjustQuantity(name, change) {
    const item = cart.find(item => item.name === name);
    
    if (item) {
        item.quantity += change;
        total += item.price * change;
        
        if (item.quantity <= 0) {
            cart = cart.filter(i => i !== item);
        }
    }
    
    updateCart();
}

function toggleCart() {
    document.querySelector('.cart-sidebar').classList.toggle('active');
}

function realizarPedido() {
    if (cart.length === 0) {
        alert('Seu carrinho está vazio!');
        return;
    }
    
    alert(`Pedido realizado! Total: R$${total.toFixed(2)}`);
    cart = [];
    total = 0;
    updateCart();
    toggleCart();
}
// controle do menu mobile, POR FAVOR, NÃO MEXA
document.querySelector('.menu-hamburguer').addEventListener('click', function() {
    document.querySelector('.nav').classList.toggle('active');
});

document.getElementById('searchInput').addEventListener('input', (e) => {
    loadMenu(e.target.value);
});

async function loadMenu(term = '') {
    const res = await fetch(`menu.php?q=${encodeURIComponent(term)}`);
    menuItems = await res.json();
    renderMenu();
}

document.addEventListener('DOMContentLoaded', () => loadMenu());
