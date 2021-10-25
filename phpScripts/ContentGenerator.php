<?php

namespace phpScripts;
require_once "../Core/Autoload.php";

use config\Content;
use Exception;

/**
 * Генератор контента
 */
class ContentGenerator
{
    public function __construct()
    {
        /* Задаём неограниченное количество времени для выполнения скрипта */
        set_time_limit(0);
    }

    /**
     * Генерирует контент
     *
     * Возможность указать количество нужного тестового контента, а так же тип ( статьи или новости )
     *
     * По умолчанию 25 статей, параметр для смены на новости: Content::CONTENT_TYPE['NEWS']
     */
    function generatesContent(int $countContent = 25, string $contentType = Content::CONTENT_TYPE['ARTICLES']): void
    {
        /* Сохраняем текущее время до начала цикла и генерации */
        $start_time = microtime(true);
        $file = null;

        /* цикл с надстройкой, сколько генерировать контента */
        for ($i = 1; $i <= $countContent; $i++) {
            try {
                if (!$file = fopen("../database/$contentType/" . $i, 'w+')) {
                    print "Не могу открыть файл ($file)";
                    exit;
                }
                fwrite($file, Content::TITLE_ARTICLE . "\n");
                fwrite($file, Content::TEXT . "\n");
                fwrite($file, Content::AUTHOR . "\n");
                fwrite($file, date("d-m-Y H:m:s"));
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
        print 'Время выполнения генерации контента: ' . round(($end_time - $start_time), 3) . " сек. \n";
        print 'Количество сгенерированного контента: ' . ($i - 1) . " $contentType \n";
    }
}

/* Генерирует 100 статей */
(new ContentGenerator())->generatesContent(100);
/* Генерирует 100 новостей */
(new ContentGenerator())->generatesContent(100, Content::CONTENT_TYPE['NEWS']);