<?php

namespace src\Order;

use Exception;
use src\API\API;
use src\DataBase\DataBase;

class Order implements InterfaceOrder
{

    /**
     * @inheritDoc
     */
    public function createOrder(int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity, int $ticket_kid_price, int $ticket_kid_quantity): array
    {

        do {
            $barcode = Barcode::generateBarcode();
            $connectApiBook = API::postBook($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $barcode);
        } while ($connectApiBook['message'] === "barcode already exists");

        $connectApiApprove = API::postApprove($barcode);

        if (!$connectApiApprove['status']) {
            return [
                'status' => false,
                'error' => $connectApiApprove['error']
            ];
        }

        try {
            DataBase::startTransaction();
            DataBase::lockTables("Orders");
            DataBase::insert("Orders", [
                "event_id" => $event_id,
                "event_date" => $event_date,
                "ticket_adult_price" => $ticket_adult_price,
                "ticket_adult_quantity" => $ticket_adult_quantity,
                "ticket_kid_price" => $ticket_kid_price,
                "ticket_kid_quantity" => $ticket_kid_quantity,
                "barcode" => $barcode,
                "equal_price" => ($ticket_adult_price * $ticket_adult_quantity) + ($ticket_kid_price * $ticket_kid_quantity),
                "created" =>  date("Y-m-d H:i:s"),
            ]);
            DataBase::commitTransaction();
            DataBase::unlockTables("Orders");

            return [
                'status' => $connectApiApprove['status'],
                'message' => $connectApiApprove['message']
            ];

        } catch (Exception $e){
            DataBase::rollbackTransaction();
            DataBase::unlockTables("Orders");
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

}