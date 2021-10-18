<?php
require_once "../Core/Autoload.php";

use Core\Routes;

/**
 * Старт сессии пользователя
 */
session_start();

/**
 * Обрабатываем всё через роутеры
 */
Routes::getInstance()->run();