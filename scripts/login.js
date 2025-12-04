console.log('Login.js завантажено успішно!');

// ЗАВДАННЯ 3: Регулярні вирази

// Регулярні вирази для валідації
const loginRegex = /^[a-zA-Z0-9_]{3,20}$/;
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;

console.log('=== ЗАВДАННЯ 3: Регулярні вирази ===');
console.log('Login regex:', loginRegex);
console.log('Email regex:', emailRegex);
console.log('Phone regex:', phoneRegex);

// Функція валідації login (match/search)
function validateLogin(login) {
    const isValid = loginRegex.test(login);
    console.log('Валідація Login:', login, '→', isValid ? '✅ Валідний' : '❌ Невалідний');
    return isValid;
}

// Функція валідації email (match/search)
function validateEmail(email) {
    const isValid = emailRegex.test(email);
    console.log('Валідація Email:', email, '→', isValid ? '✅ Валідний' : '❌ Невалідний');
    return isValid;
}

// Функція валідації phone (match/search)
function validatePhone(phone) {
    const isValid = phoneRegex.test(phone);
    console.log('Валідація Phone:', phone, '→', isValid ? '✅ Валідний' : '❌ Невалідний');
    return isValid;
}

// Функція очищення login (replace)
function cleanLogin(login) {
    // Видаляємо всі символи крім літер, цифр та _
    const cleaned = login.replace(/[^a-zA-Z0-9_]/g, '');
    console.log('🧹 Clean login (replace):', login, '→', cleaned);
    return cleaned;
}

// Обробники подій для полів

// Login поле
const loginInput = document.getElementById('login');
if (loginInput) {
    // Автоматичне очищення при введенні (replace)
    loginInput.addEventListener('input', function() {
        const originalValue = this.value;
        const cleanedValue = cleanLogin(originalValue);
        
        if (originalValue !== cleanedValue) {
            this.value = cleanedValue;
        }
    });
    
    // Валідація при втраті фокусу (match/search)
    loginInput.addEventListener('blur', function() {
        const login = this.value;
        if (login) {
            if (validateLogin(login)) {
                this.classList.remove('invalid');
                this.classList.add('valid');
            } else {
                this.classList.remove('valid');
                this.classList.add('invalid');
            }
        } else {
            this.classList.remove('valid', 'invalid');
        }
    });
}

// Email поле
const emailInput = document.getElementById('email');
if (emailInput) {
    emailInput.addEventListener('blur', function() {
        const email = this.value;
        if (email) {
            if (validateEmail(email)) {
                this.classList.remove('invalid');
                this.classList.add('valid');
            } else {
                this.classList.remove('valid');
                this.classList.add('invalid');
            }
        } else {
            this.classList.remove('valid', 'invalid');
        }
    });
}

// Phone поле
const phoneInput = document.getElementById('phone');
if (phoneInput) {
    phoneInput.addEventListener('blur', function() {
        const phone = this.value;
        if (phone) {
            if (validatePhone(phone)) {
                this.classList.remove('invalid');
                this.classList.add('valid');
            } else {
                this.classList.remove('valid');
                this.classList.add('invalid');
            }
        } else {
            this.classList.remove('valid', 'invalid');
        }
    });
}

// Функція для перевірки всіх полів
function validateAll() {
    console.log('\n=== Перевірка всіх полів ===');
    
    const login = document.getElementById('login').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    
    const loginValid = validateLogin(login);
    const emailValid = validateEmail(email);
    const phoneValid = validatePhone(phone);
    
    const resultDiv = document.getElementById('result');
    resultDiv.classList.add('show');
    
    if (loginValid && emailValid && phoneValid) {
        resultDiv.className = 'result show success';
        resultDiv.innerHTML = '✅ Всі поля заповнені правильно!';
    } else {
        resultDiv.className = 'result show error';
        let errors = [];
        if (!loginValid) errors.push('Login');
        if (!emailValid) errors.push('Email');
        if (!phoneValid) errors.push('Phone');
        resultDiv.innerHTML = `❌ Помилки в полях: ${errors.join(', ')}`;
    }
    
    console.log('=== Перевірка завершена ===\n');
}

console.log('=== Login.js готовий до роботи ===\n');
