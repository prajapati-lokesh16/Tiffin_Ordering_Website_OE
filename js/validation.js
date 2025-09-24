function validateOrderForm() {
    var qty = document.getElementById('quantity');
    if (!qty.value || qty.value < 1) {
        alert('Please enter a valid quantity.');
        qty.focus();
        return false;
    }
    return true;
}
function validateContactForm() {
    var name = document.getElementById('name');
    var email = document.getElementById('email');
    var message = document.getElementById('message');
    if (!name.value.trim() || !email.value.trim() || !message.value.trim()) {
        alert('All fields are required.');
        return false;
    }
    return true;
}
function validateLoginForm() {
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    if (!email.value.trim() || !password.value.trim()) {
        alert('Email and password required.');
        return false;
    }
    return true;
}
function validateSignupForm() {
    var name = document.getElementById('name');
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    var confirm = document.getElementById('confirm');
    if (!name.value.trim() || !email.value.trim() || !password.value.trim() || !confirm.value.trim()) {
        alert('All fields are required.');
        return false;
    }
    if (password.value !== confirm.value) {
        alert('Passwords do not match.');
        return false;
    }
    return true;
}
function validateAddItemForm() {
    var name = document.getElementById('name');
    var desc = document.getElementById('description');
    var price = document.getElementById('price');
    var image = document.getElementById('image');
    if (!name.value.trim() || !desc.value.trim() || !price.value || !image.value) {
        alert('All fields are required.');
        return false;
    }
    if (parseFloat(price.value) < 1) {
        alert('Price must be at least 1.');
        return false;
    }
    return true;
}
function validateEditItemForm() {
    var name = document.getElementById('name');
    var desc = document.getElementById('description');
    var price = document.getElementById('price');
    if (!name.value.trim() || !desc.value.trim() || !price.value) {
        alert('All fields are required.');
        return false;
    }
    if (parseFloat(price.value) < 1) {
        alert('Price must be at least 1.');
        return false;
    }
    return true;
}
