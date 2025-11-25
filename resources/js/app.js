import './bootstrap';
import 'flowbite';

const toggleIcon = document.querySelectorAll('.toggle-password')

document.addEventListener('DOMContentLoaded', function () {
    const flash = document.getElementById('flash-alert');
    if (flash) {
        setTimeout(() => {
            flash.classList.add('fade-out');
            setTimeout(() => flash.remove(), 500);
        }, 3200);
    }
});

toggleIcon.forEach(iconButton => {
    iconButton.addEventListener('click', () => {
        const targetId = iconButton.getAttribute('data-target');        
        const input = document.getElementById(targetId);
        const icon = iconButton.querySelector('i');
        
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