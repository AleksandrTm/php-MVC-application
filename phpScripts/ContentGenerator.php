<?php

namespace phpScripts;

require_once "../Core/Autoload.php";;
$dbConfig = require_once "../config/database.php";

use Enums\Content;
use config\Paths;
use Core\Model;
use Exception;

/**
 * Генератор контента
 */
class ContentGenerator
{
    public function __construct()
    {
        /** Задаём неограниченное количество времени для выполнения скрипта */
        set_time_limit(0);
    }

    /**
     * Генерирует контент
     *
     * Возможность указать количество нужного тестового контента, а так же тип ( статьи или новости )
     *
     * По умолчанию 25 статей, параметр для новости: Content::TYPE['NEWS']
     */
    public function generatesContent(string $type, string $contentType, int $countContent = 25): void
    {
        /** Сохраняем текущее время до начала цикла и генерации */
        $start_time = microtime(true);

        $file = null;
        $objModel = new Model();
        /** последний id */
        $lastId = $objModel->getLastId($type);
        /** цикл с надстройкой, сколько генерировать контента и чего */
        for ($i = 1 + $lastId; $i <= $countContent + $lastId; $i++) {
            try {
                if (!$file = fopen("../database/$contentType/" . $i, 'w+')) {
                    print "Не могу открыть файл ($file)";
                    exit;
                }
                /**
                 * Что генерируем? Пользователей или контент ( новости, статьи )
                 */
                if ($contentType === Content::TYPE['USERS']) {
                    fwrite($file, "UserTest$i\n");
                    fwrite($file, password_hash("testpassword", PASSWORD_DEFAULT) . "\n");
                    fwrite($file, "test@user.ru\n");
                    fwrite($file, "Сгенерированный Пользователь\n");
                    fwrite($file, "10-05-2000 10:00:00\n");
                    fwrite($file, "Сгенерированный пользователь №$i\n");
                    fwrite($file, 'member');
                } else {
                    fwrite($file, Content::TITLE_ARTICLE . "\n");
                    fwrite($file, Content::TEXT . "\n");
                    fwrite($file, Content::AUTHOR . "\n");
                    fwrite($file, date("d-m-Y H:i:s"));
                }
                sleep(12);
            } catch (Exception $e) {
                var_dump($e);
            } finally {
                fclose($file);
            }
        }
        /* сохраняем текущее время после завершение цикла */
        $end_time = microtime(true);
        /*
         * Выводим информацию о времени затраченном на генерацию, и количество контента
         */
        print 'Время затраченное на генерацию: ' . round(($end_time - $start_time), 3) . " сек. \n";
        print 'Количество сгенерированного: ' . $countContent . " $contentType \n";
    }
}

/* Генерирует 25 статей */
//(new ContentGenerator())->generatesContent(Paths::DIR_BASE_ARTICLES, Content::TYPE['ARTICLES'], 100);
/* Генерирует 25 новостей */
(new ContentGenerator())->generatesContent(Paths::DIR_BASE_NEWS, Content::TYPE['NEWS'], 15);
/* Генерирует 25 пользователей */
//(new ContentGenerator())->generatesContent(Paths::DIR_BASE_USERS, Content::TYPE['USERS']);