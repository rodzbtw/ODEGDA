function switchTab(tab) {
    document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));

    if (tab === 'login') {
        document.querySelector('.auth-tab:first-child').classList.add('active');
        document.getElementById('login-form').classList.add('active');
    } else {
        document.querySelector('.auth-tab:last-child').classList.add('active');
        document.getElementById('register-form').classList.add('active');
    }
}

document.querySelectorAll('.password-toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const input = this.parentElement.querySelector('input');
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
});

const passwordInput = document.querySelector('#register-form input[type="password"]');
const requirements = {
    length: str => str.length >= 8,
    uppercase: str => /[A-Z]/.test(str),
    number: str => /[0-9]/.test(str),
    special: str => /[^A-Za-z0-9]/.test(str)
};

if (passwordInput) {
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        for (const [requirement, validateFunc] of Object.entries(requirements)) {
            const element = document.querySelector(`[data-requirement="${requirement}"]`);
            if (validateFunc(password)) {
                element.classList.add('valid');
            } else {
                element.classList.remove('valid');
            }
        }
    });
}