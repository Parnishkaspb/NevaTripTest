<?php

namespace src\DataBase;

use PDO;
use PDOException;

class DataBase implements InterfaceDatabase
{
    private static $host;
    private static $username;
    private static $password;
    private static $database;
    private static $charset;
    private static $pdo;

    public static function init()
    {
        self::$host = getenv('DB_HOST');
        self::$username = getenv('DB_USERNAME');
        self::$password = getenv('DB_PASSWORD');
        self::$database = getenv('DB_NAME');
        self::$charset = getenv('DB_CHARSET');

        self::connect();
    }

    private static function connect()
    {
        $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$database . ";charset=" . self::$charset;

        try {
            self::$pdo = new PDO($dsn, self::$username, self::$password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function query(string $sql, array $params = [])
    {
        $statement = self::$pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public static function insert(string $table, array $data): array
    {
        if (empty($table)) {
            return [
                'success' => false,
                'message' => 'Таблица не была передана'
            ];
        }

        if (empty($data)) {
            return [
                'success' => false,
                'message' => 'Никаких данных не было передано'
            ];
        }

        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        try {
            self::query($sql, $data);
            $lastInsertId = self::$pdo->lastInsertId();
            return [
                'success' => true,
                'message' => 'Запись успешно добавлена',
                'id' => (int) $lastInsertId
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public static function startTransaction(): void
    {
        self::$pdo->beginTransaction();
    }

    public static function commitTransaction(): void
    {
        self::$pdo->commit();
    }

    public static function rollBackTransaction(): void
    {
        self::$pdo->rollBack();
    }

    public static function lockTables(string $table): void
    {
        self::$pdo->exec("LOCK TABLES $table");
    }

    public static function unlockTables(string $table): void
    {
        self::$pdo->exec("UNLOCK TABLES $table");
    }
}