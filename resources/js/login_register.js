const container = document.querySelector('.container')
const registerBtn = document.querySelector('.register-btn')
const loginBtn = document.querySelector('.login-btn')
const toggleIcon = document.querySelectorAll('.toggle-password')

registerBtn.addEventListener('click', () => {
    container.classList.add('active')
})

loginBtn.addEventListener('click', () => {
    container.classList.remove('active')
})

toggleIcon.forEach(icon => {
    icon.addEventListener('click', () => {
        const targetId = icon.getAttribute('data-target');
        const input = document.getElementById(targetId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const flash = document.getElementById('flash-alert');
    if (flash) {
        setTimeout(() => {
            flash.classList.add('fade-out');
            setTimeout(() => flash.remove(), 500);
        }, 5000);
    }
});