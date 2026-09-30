// Cart management functions
class CartManager {
    constructor() {
        this.cart = JSON.parse(localStorage.getItem('cart')) || [];
    }
    
    getCart() {
        return this.cart;
    }
    
    addItem(productId, quantity = 1, size = null, color = null) {
        const existingItem = this.cart.find(item => 
            item.product_id === productId && 
            item.size === size && 
            item.color === color
        );
        
        if(existingItem) {
            existingItem.quantity += quantity;
        } else {
            this.cart.push({
                product_id: productId,
                quantity: quantity,
                size: size,
                color: color,
                added_at: new Date().toISOString()
            });
        }
        
        this.saveCart();
        return this.cart;
    }
    
    removeItem(index) {
        this.cart.splice(index, 1);
        this.saveCart();
        return this.cart;
    }
    
    updateQuantity(index, quantity) {
        if(quantity <= 0) {
            this.removeItem(index);
        } else {
            this.cart[index].quantity = quantity;
            this.saveCart();
        }
        return this.cart;
    }
    
    clearCart() {
        this.cart = [];
        this.saveCart();
        return this.cart;
    }
    
    getTotalItems() {
        return this.cart.reduce((total, item) => total + item.quantity, 0);
    }
    
    getTotalPrice() {
        // This will need product data from server
        // For now, return placeholder
        return 0;
    }
    
    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
        updateCartCount();
        
        // Trigger event
        document.dispatchEvent(new CustomEvent('cartUpdated', { detail: this.cart }));
    }
}

// Initialize cart manager
const cartManager = new CartManager();

// Export for use in other files
window.cartManager = cartManager;