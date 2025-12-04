<?php
/**
 * Сторінка "Про мене"
 * 
 * Підключає контролер AboutMeController для відображення сторінки
 */

require_once __DIR__ . '/../../app/Classes/AboutMeController.php';

use Classes\AboutMeController;

// Викликаємо метод контролера для відображення сторінки
AboutMeController::action();

