// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const href = this.getAttribute('href');
        if (href === '#') return;
        const targetId = href.substring(1);
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Search functionality
function toggleSearch() {
    document.getElementById('searchOverlay').classList.toggle('active');
    if (document.getElementById('searchOverlay').classList.contains('active')) {
        document.getElementById('searchInput').focus();
    }
}

function handleSearch(e) {
    e.preventDefault();
    const searchTerm = document.getElementById('searchInput').value;
    alert(`Searching for: ${searchTerm}`);
    document.getElementById('searchInput').value = '';
    toggleSearch();
}

// Cart functionality
let cartItems = [];
let cartTotal = 0;

function toggleCart() {
    document.getElementById('cartSidebar').classList.toggle('active');
}

function updateCart() {
    const cartItemsContainer = document.getElementById('cartItems');
    const cartCount = document.getElementById('cartCount');
    const cartTotalElement = document.getElementById('cartTotal');
    
    cartCount.textContent = cartItems.length;
    cartTotalElement.textContent = `$${cartTotal.toFixed(2)}`;
    
    cartItemsContainer.innerHTML = cartItems.map(item => `
        <div class="cart-item">
            <img src="${item.image}" alt="${item.name}">
            <div class="cart-item-details">
                <h4>${item.name}</h4>
                <p>$${item.price}</p>
            </div>
            <button onclick="removeFromCart('${item.id}')" class="remove-item">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `).join('');
}

function removeFromCart(itemId) {
    const itemIndex = cartItems.findIndex(item => item.id === itemId);
    if (itemIndex > -1) {
        cartTotal -= cartItems[itemIndex].price;
        cartItems.splice(itemIndex, 1);
        updateCart();
    }
}

// Wishlist functionality
let wishlistItems = new Set();

document.querySelectorAll('.wishlist-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const productCard = this.closest('.product-card');
        const productId = productCard.dataset.id;
        
        if (wishlistItems.has(productId)) {
            wishlistItems.delete(productId);
            this.classList.remove('active');
        } else {
            wishlistItems.add(productId);
            this.classList.add('active');
        }
        
        document.querySelector('.wishlist-count').textContent = wishlistItems.size;
    });
});

// Product actions
document.querySelectorAll('.quick-view').forEach(btn => {
    btn.addEventListener('click', function() {
        const productCard = this.closest('.product-card');
        const productName = productCard.querySelector('h3').textContent;
        alert(`Quick view for ${productName}`);
    });
});

document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', function() {
        const productCard = this.closest('.product-card');
        const productName = productCard.querySelector('h3').textContent;
        const productPrice = parseFloat(productCard.querySelector('.price').textContent.replace('$', ''));
        const productImage = productCard.querySelector('img').src;
        const productId = Date.now().toString();

        cartItems.push({
            id: productId,
            name: productName,
            price: productPrice,
            image: productImage
        });

        cartTotal += productPrice;
        updateCart();
        toggleCart();
    });
});

// Newsletter subscription
document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.querySelector('input[type="email"]').value;
    alert(`Thank you for subscribing with: ${email}`);
    this.reset();
});
