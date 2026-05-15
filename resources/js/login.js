// Login Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Form submissions
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Đăng nhập thành công!');
            window.location.href = 'index.html';
        });
    }

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Đăng ký thành công!');
            window.location.href = 'index.html';
        });
    }
});
