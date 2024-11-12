<?php

namespace src\DataBase;

interface InterfaceDatabase
{
    /**
     * Выполняет SQL-запрос с параметрами и возвращает PDOStatement
     */
    public static function query(string $sql, array $params = []);
    /**
     * Вставляет данные в таблицу и возвращает статус операции
     *
     * @return array{success: bool, message: string, id?: int}
     */
    public static function insert(string $table, array $data): array;
    /**
     * Начинает транзакцию
     */
    public static function startTransaction(): void;

    /**
     * Подтверждает транзакцию
     */
    public static function commitTransaction(): void;

    /**
     * Откатывает транзакцию
     */
    public static function rollBackTransaction(): void;

    /**
     * Закрываем таблицу на запись
     */
    public static function lockTables(string $table): void;

    /**
     * Открываем таблицу на запись
     */
    public static function unlockTables(string $table): void;
}