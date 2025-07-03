document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const registerBtn = document.querySelectorAll('.register-btn');
    const loginBtn = document.querySelectorAll('.login-btn');

    registerBtn.forEach(btn => {
        btn.addEventListener('click', () => {
            container.classList.add('active');
        });
    });

    loginBtn.forEach(btn => {
        btn.addEventListener('click', () => {
            container.classList.remove('active');
        });
    });
});