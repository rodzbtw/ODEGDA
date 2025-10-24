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

const loginRegex = /^[a-zA-Z0-9_]{3,20}$/;
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;

function validateLogin(login) {
    const isValid = loginRegex.test(login);
    console.log('Login validation:', isValid ? 'Valid' : 'Invalid');
    return isValid;
}

function validateEmail(email) {
    const isValid = emailRegex.test(email);
    console.log('Email validation:', isValid ? 'Valid' : 'Invalid');
    return isValid;
}

function validatePhone(phone) {
    const isValid = phoneRegex.test(phone);
    console.log('Phone validation:', isValid ? 'Valid' : 'Invalid');
    return isValid;
}

function cleanLogin(login) {
    let cleaned = login.replace(/[^a-zA-Z0-9_]/g, '');
    cleaned = cleaned.replace(/\s+/g, '');
    cleaned = cleaned.replace(/[^\w]/g, '');
    cleaned = cleaned.toLowerCase();
    console.log('Login cleaned:', login, '->', cleaned);
    return cleaned;
}

function advancedCleanLogin(login) {
    let cleaned = login.replace(/[^a-zA-Z0-9_]/g, '');
    cleaned = cleaned.replace(/\s+/g, '');
    cleaned = cleaned.replace(/[^\w]/g, '');
    cleaned = cleaned.replace(/_{2,}/g, '_');
    cleaned = cleaned.replace(/^_+|_+$/g, '');
    console.log('Advanced login cleaning:', login, '->', cleaned);
    return cleaned;
}

document.querySelectorAll('input[type="email"]').forEach(input => {
    input.addEventListener('blur', function() {
        const email = this.value;
        if (email && !validateEmail(email)) {
            this.style.borderColor = 'red';
            this.style.backgroundColor = '#ffe6e6';
        } else {
            this.style.borderColor = '';
            this.style.backgroundColor = '';
        }
    });
});

document.querySelectorAll('input[type="text"]').forEach(input => {
    if (input.placeholder.toLowerCase().includes('name') || input.name === 'fullName') {
        input.addEventListener('input', function() {
            const originalValue = this.value;
            const cleanedValue = advancedCleanLogin(originalValue);
            if (originalValue !== cleanedValue) {
                this.value = cleanedValue;
            }
        });
        
        input.addEventListener('blur', function() {
            const login = this.value;
            if (login && !validateLogin(login)) {
                this.style.borderColor = 'red';
                this.style.backgroundColor = '#ffe6e6';
            } else {
                this.style.borderColor = '';
                this.style.backgroundColor = '';
            }
        });
    }
});

document.querySelectorAll('input[type="tel"], input[placeholder*="phone"], input[name*="phone"]').forEach(input => {
    input.addEventListener('blur', function() {
        const phone = this.value;
        if (phone && !validatePhone(phone)) {
            this.style.borderColor = 'red';
            this.style.backgroundColor = '#ffe6e6';
        } else {
            this.style.borderColor = '';
            this.style.backgroundColor = '';
        }
    });
});