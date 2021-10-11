<?php

const DIR_BASE_USERS = "../resources/users/";


function addUser($name, $password, $email, $fullName, $date, $about)
{
    if (empty(idUser(DIR_BASE_USERS))) {
        $userId = DIR_BASE_USERS . 1;
    } else {
        $userId = DIR_BASE_USERS . (idUser(DIR_BASE_USERS)[0] + 1);
    }
    $files = fopen($userId, 'w');
    fwrite($files, $name . "\n");
    fwrite($files, $password . "\n");
    fwrite($files, $email . "\n");
    fwrite($files, $fullName . "\n");
    fwrite($files, $date . "\n");
    fwrite($files, $about);
    fclose($files);
}

function countsUsers(): int
    /*
     *  Считает пользователей
     */
{
    return count(idUser());
}


function idUser(): array
    /*
     * Заносим в массив пользователей,
     * сортируем по убыванию и отдаём последний элемент id пользователя
     */
{
    $arrayUsers = [];
    if ($dir = opendir(DIR_BASE_USERS)) {
        while (($file = readdir($dir)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $arrayUsers[] = $file;
        }

        rsort($arrayUsers);
        closedir($dir);
    }
    return $arrayUsers;
}

function removeUser($id)
{
    $files = null;
    try {
        $files = fopen("../resources/removeUserId", 'w');
        fwrite($files, $id . "\n");
    } catch (Exception $e) {
        var_dump($e);
    } finally {
        fclose($files);
    }
}

ы