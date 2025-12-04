<?php
/**
 * Динамічна навігація
 * @param string $active_page - назва активної сторінки
 */
function renderNav($active_page = '') {
    $nav_items = [
        '' => ['url' => '/', 'label' => 'Головна'],
        'login' => ['url' => '/login', 'label' => 'Валідація'],
        'set-task' => ['url' => '/set-task', 'label' => 'Set/Map'],
        'api-task' => ['url' => '/api-task', 'label' => 'API'],
        'game' => ['url' => '/game', 'label' => 'Canvas Гра'],
        'aboutme' => ['url' => '/aboutme', 'label' => 'Про мене'],
        'tasks' => ['url' => '/tasks', 'label' => 'Завдання'],
    ];
    ?>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <span class="logo-icon">{ JS }</span>
                <span class="logo-text">JavaScript Tasks</span>
            </div>
            <div class="nav-links">
                <?php foreach ($nav_items as $key => $item): ?>
                    <a href="<?php echo $item['url']; ?>" <?php echo ($active_page === $key) ? 'class="active"' : ''; ?>>
                        <?php echo htmlspecialchars($item['label']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>
    <?php
}
?>

