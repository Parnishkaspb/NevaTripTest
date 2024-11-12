<?php

namespace src\API;

interface InterfaceAPI
{
    /**
     * Отправляет запрос на бронирование и возвращает ответ.
     * Возвращает массив, содержащий:
     * - `status: true` и `message: string` при успешной операции,
     * - `status: false` и `error: string` при ошибке.
     *
     * @return array{status: true, message: string} | array{status: false, error: string}
     */
    public static function postBook(
        int $event_id,
        string $event_date,
        int $ticket_adult_price,
        int $ticket_adult_quantity,
        int $ticket_kid_price,
        int $ticket_kid_quantity,
        int $barcode
    ): array;

    /**
     * Отправляет запрос с подтверждением и возвращает ответ.
     * Возвращает массив, содержащий:
     * - `status: true` и `message: string` при успешной операции,
     * - `status: false` и `error: string` при ошибке.
     *
     * @return array{success: true, message: string} | array{success: false, error: string}
     */
    public static function postApprove(int $barcode): array;
}