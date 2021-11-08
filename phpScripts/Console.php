<?php

namespace phpScripts;

use Core\Connections\MySQLConnection;
use Enums\Database as db;
use Exception;
use mysqli;
use mysqli_sql_exception;
use Throwable;

include_once '../Core/Autoload.php';


/**
 * Скрипт для работы с Миграциями и Сидерами через консоль
 */
class Console
{
    private mysqli $mysqlConnect;
    private ?string $getFunction = null;
    private ?string $getCommand = null;
    private string $pathMigrates;
    private string $pathSeeders;


    public function __construct()
    {
        /**
         * Подключения к базе данных проекта
         */
        $this->mysqlConnect = MySQLConnection::getInstance()->getConnection();

        /**
         * Пути до папок с миграциями и сидерами
         */
        $this->pathMigrates = db::PATH_MIGRATES;
        $this->pathSeeders = db::PATH_SEEDERS;

        if (array_key_exists(1, $_SERVER['argv'])) {
            $this->getFunction = $_SERVER['argv'][1];
        }

        if (array_key_exists(2, $_SERVER['argv'])) {
            $this->getCommand = $_SERVER['argv'][2];
        }

        $this->checksMigrateTable();
        $this->run();
    }

    /**
     * Основнное консольное меню
     */
    private function run(): void
    {
        switch ($this->getFunction) {
            case 'migrate':
                $this->runMigratesCommand();
                break;
            case 'seeder':
                $this->runSeedersCommand();
                break;
            default:
                print "Команды для ввода:\n migrate \n seeder \n";
                break;
        }
    }

    /**
     * Консольное меню миграций
     */
    private function runMigratesCommand(): void
    {
        switch ($this->getCommand) {
            case 'list':
                $this->getListNotInstallMigrates();
                break;
            case 'install':
                $this->installMigrations();
                break;
            case 'rollback':
                $this->rollbackMigrations();
                break;
            default:
                print "Команды для ввода:
    list : список не установленных миграций
    install : установка миграций
    rollback : откат миграций\n";
                break;
        }
    }

    /**
     * Консольное меню сидеров
     */
    private function runSeedersCommand(): void
    {
        switch ($this->getCommand) {
            case 'install':
                $this->installSeeders();
                break;
            case 'list':
                $this->listSeeders();
                break;
            case '-g':
                $this->generatesSeeders($_SERVER['argv'][3], $_SERVER['argv'][4]);
                break;
            default:
                print "Команды для ввода:
    install : установка сидеров
    list : список сидеров
    -g SeederName.php count : генерация сидеров\n";
                break;
        }
    }

    /**
     * Получить список установленных миграций
     */
    private function getListInstalledMigrations(): array
    {
        $list = [];
        $result = $this->mysqlConnect->query('SELECT migrate FROM migrates');
        while ($row = $result->fetch_assoc()) {
            $list[] = $row['migrate'];
        }

        return $list;
    }

    /**
     * Получаем список файлов в директории
     */
    private function getListFiles($path): array
    {
        return array_diff(scandir($path), array('..', '.'));
    }

    /**
     * Получить список не установленных миграций
     */
    private function getListNotInstallMigrates(): void
    {
        $result = array_diff($this->getListFiles($this->pathMigrates), $this->getListInstalledMigrations());

        if (empty($result)) {
            print "Список пуст \n";
        } else {
            print "Список не установленных миграций: \n";
            foreach ($result as $res) {
                print $res . "\n";
            }
        }
    }

    /**
     * Откатить установленные миграции
     */
    private function rollbackMigrations(): void
    {
        $result = $this->getListInstalledMigrations();
        rsort($result);
        foreach ($result as $migrate) {
            $obj = include_once $this->pathMigrates . $migrate;
            $this->mysqlConnect->query($obj->down());
            $this->mysqlConnect->query("DELETE FROM migrates WHERE migrate = '$migrate'");
            print "Откат миграции " . $migrate . " успешен \n";
        }
    }

    /**
     * Установить не установленные миграции
     */
    private function installMigrations(): void
    {
        $result = array_diff($this->getListFiles($this->pathMigrates), $this->getListInstalledMigrations());

        if (empty($result)) {
            print "Нет не установленных миграций \n";
            return;
        }

        try {
            $this->mysqlConnect->begin_transaction();
            foreach ($result as $migrate) {
                $obj = include_once $this->pathMigrates . $migrate;
                $this->mysqlConnect->query($obj->up());
                $this->mysqlConnect->query("INSERT INTO migrates VALUE ('$migrate')");
                print "Миграция " . $migrate . " успешно установлена \n";
            }
            $this->mysqlConnect->commit();
        } catch (mysqli_sql_exception $exception) {
            $this->mysqlConnect->rollback();
            throw $exception;
        }
    }

    /**
     * Установить сидеры
     */
    private function installSeeders(): void
    {
        $result = $this->getListFiles($this->pathSeeders);

        try {
            foreach ($result as $seeder) {
                $obj = include_once $this->pathSeeders . $seeder;
                $this->mysqlConnect->query($obj->installDefaultSeeders());
                print "Сидер " . $seeder . " успешно установлен \n";
            }
        } catch (mysqli_sql_exception $exception) {
            print $exception;
        }
    }

    /**
     * Сгенерировать сидер
     */
    private function generatesSeeders(string $seeder, int $count): void
    {
        $obj = include_once $this->pathSeeders . $seeder;
        $arrSQL = $obj->generate($count);

        foreach ($arrSQL as $sql) {
            $this->mysqlConnect->query($sql);
        }

        print "Сгенерировано " . $count . " " . $seeder . " успешно\n";
    }

    /**
     * Создаёт таблицу для миграций, если отсутсвует
     */
    private function checksMigrateTable(): void
    {
        $this->mysqlConnect->query("CREATE TABLE IF NOT EXISTS `migrates`(`migrate` varchar(50) NOT NULL)");
    }

    /**
     * Список доступных сидеров
     */
    private function listSeeders(): void
    {
        $result = $this->getListFiles($this->pathSeeders);

        if (empty($result)) {
            print "Список пуст \n";
        } else {
            print "Список сидеров:\n";
            foreach ($result as $res) {
                print $res . "\n";
            }
        }
    }
}

new Console();
