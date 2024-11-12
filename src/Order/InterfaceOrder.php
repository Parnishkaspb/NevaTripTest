<?php

namespace src\Order;

interface InterfaceOrder
{
    /**
     * Вставляет новый заказ в таблицу и возвращает ответ.
     * Возвращает массив, содержащий:
     * - `success: true` и `message: string` при успешной операции,
     * - `success: false` и `error: string` при ошибке.
     *
     * @return array{success: true, message: string} | array{success: false, error: string}
     */
    public function createOrder(
        int $event_id,
        string $event_date,
        int $ticket_adult_price,
        int $ticket_adult_quantity,
        int $ticket_kid_price,
        int $ticket_kid_quantity
    ): array;
}