console.log('Set-task.js завантажено успішно!');
console.log('=== ЗАВДАННЯ 4: Робота з Set ===\n');

// Використовуємо Set для зберігання попередніх фраз
let previousPhrases = new Set();

// Функція для нормалізації тексту (видалення пунктуації)
function normalizeText(text) {
    return text
        .toLowerCase()
        .replace(/[.,!?;:'"«»()]/g, '')
        .trim();
}

// Функція для створення Set зі слів
function getWordsSet(phrase) {
    const normalizedPhrase = normalizeText(phrase);
    const wordsArray = normalizedPhrase.split(/\s+/).filter(word => word.length > 0);
    return new Set(wordsArray);
}

// Головна функція для знаходження спільних слів
function findCommonWords() {
    const phrase1 = document.getElementById('phrase1').value.trim();
    const phrase2 = document.getElementById('phrase2').value.trim();

    // Перевірка на порожні поля
    if (!phrase1 || !phrase2) {
        alert('Будь ласка, введіть обидві фрази!');
        return;
    }

    console.log('\n=== Аналіз фраз ===');
    console.log('Фраза 1:', phrase1);
    console.log('Фраза 2:', phrase2);

    // Створюємо Set для кожної фрази
    const wordsSet1 = getWordsSet(phrase1);
    const wordsSet2 = getWordsSet(phrase2);

    console.log('Set 1 (унікальні слова з фрази 1):', wordsSet1);
    console.log('Розмір Set 1:', wordsSet1.size);
    console.log('Set 2 (унікальні слова з фрази 2):', wordsSet2);
    console.log('Розмір Set 2:', wordsSet2.size);

    // Знаходимо спільні слова
    const commonWords = new Set();
    
    wordsSet1.forEach(word => {
        if (wordsSet2.has(word)) {
            commonWords.add(word);
            console.log(`✅ Спільне слово знайдено: "${word}"`);
        }
    });

    console.log('\nРезультат - спільні слова (Set):', commonWords);
    console.log('Кількість спільних слів:', commonWords.size);

    // Додаємо фрази до історії (Set не дозволить дублікатів)
    previousPhrases.add(phrase1);
    previousPhrases.add(phrase2);
    
    console.log('Всі унікальні фрази (Set):', previousPhrases);
    console.log('Кількість унікальних фраз:', previousPhrases.size);

    // Відображаємо результати
    displayResults(phrase1, phrase2, commonWords);
    
    console.log('=== Аналіз завершено ===\n');
}

// Функція для відображення результатів
function displayResults(phrase1, phrase2, commonWordsSet) {
    const resultsDiv = document.getElementById('results');
    const displayPhrase1 = document.getElementById('displayPhrase1');
    const displayPhrase2 = document.getElementById('displayPhrase2');
    const commonWordsDiv = document.getElementById('commonWords');

    // Показуємо результати
    resultsDiv.classList.add('show');

    // Відображаємо фрази
    displayPhrase1.textContent = phrase1;
    displayPhrase2.textContent = phrase2;

    // Очищаємо попередні спільні слова
    commonWordsDiv.innerHTML = '';

    // Відображаємо спільні слова
    if (commonWordsSet.size === 0) {
        commonWordsDiv.innerHTML = '<div class="no-common">❌ Спільних слів не знайдено</div>';
    } else {
        // Використовуємо forEach для Set
        commonWordsSet.forEach(word => {
            const wordTag = document.createElement('div');
            wordTag.className = 'word-tag';
            wordTag.textContent = `✓ ${word}`;
            commonWordsDiv.appendChild(wordTag);
        });
    }
}

// Функція для очищення полів
function clearAll() {
    document.getElementById('phrase1').value = '';
    document.getElementById('phrase2').value = '';
    
    const resultsDiv = document.getElementById('results');
    resultsDiv.classList.remove('show');
    
    console.log('🧹 Поля очищено');
    document.getElementById('phrase1').focus();
}

// Обробники Enter для зручності
document.getElementById('phrase1').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        document.getElementById('phrase2').focus();
    }
});

document.getElementById('phrase2').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        findCommonWords();
    }
});

// Демонстрація можливостей Set
console.log('📚 Приклад роботи з Set:');
const exampleSet = new Set();
exampleSet.add('привіт');
exampleSet.add('світ');
exampleSet.add('привіт'); // Дублікат не буде доданий
console.log('Set:', exampleSet);
console.log('Розмір:', exampleSet.size);
console.log('Чи є "привіт"?', exampleSet.has('привіт'));
console.log('Чи є "javascript"?', exampleSet.has('javascript'));

console.log('\n✅ Set-task.js готовий до роботи!\n');
