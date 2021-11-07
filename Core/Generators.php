<?php

namespace Core;

/**
 * Генераторы
 */
class Generators
{
    /**
     * Генерирует дату
     *
     * Возможность генерации совершоналетней даты рождения
     */
    public function generatesDate(bool $adult = false): string
    {
        if ($adult) {

            return rand(1950, date("Y") - 18) . "-" . rand(1, 12) . "-" . rand(1, 28);
        }

        return rand(1950, 2021) . "-" . rand(1, 12) . "-" . rand(1, 28);
    }

    /**
     * Генератор текста англ ( 5 символов )
     */
    public function generatesEngText(int $len = 5): string
    {
        $str = array_merge(range('a', 'z'));
        shuffle($str);

        return substr(implode($str), 0, $len);
    }
}