<?php
require_once "../config/config.php";


function addUser(string $name, string $password, string $email, string $fullName, string $date, string $about)
{
    $files = null;
    if (empty(idUser(DIR_BASE_USERS))) {
        $userId = DIR_BASE_USERS . 1;
    } else {
        $userId = DIR_BASE_USERS . (idUser() + 1);
    }
    try {
        $files = fopen($userId, 'w');
        fwrite($files, $name . "\n");
        fwrite($files, $password . "\n");
        fwrite($files, $email . "\n");
        fwrite($files, $fullName . "\n");
        fwrite($files, $date . "\n");
        fwrite($files, $about);
    } catch (Exception $e) {
        var_dump($e);
    } finally {
        fclose($files);
    }
}

/**
 * Заносим в массив пользователей,
 * сортируем по убыванию и отдаём последний элемент id пользователя
 */
function idUser()
{
    $arrayUsers = [];
    $dir = null;
    try {
        if ($dir = opendir(DIR_BASE_USERS)) {
            while (($file = readdir($dir)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $arrayUsers[] = $file;
            }
        }
    } catch (Exception $e) {
        var_dump($e);
    } finally {
        closedir($dir);
    }
    return array_key_last($arrayUsers);
}