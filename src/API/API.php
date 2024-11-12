<?php

namespace src\API;

use src\API\InterfaceAPI;
use src\Order\Barcode;

class API implements InterfaceAPI
{
    private static string $apiBook = "https://api.site.com/book";
    private static string $apiApprove = "https://api.site.com/approve";

    private static function createConnectionAPI(string $apiUrl): string|int
    {
        if ($apiUrl === "") {
            return "url is empty! can't connect to api!";
        }

        return 1;
    }

    /**
     * @inheritDoc
     */
    public static function postBook(int $event_id, string $event_date, int $ticket_adult_price, int $ticket_adult_quantity, int $ticket_kid_price, int $ticket_kid_quantity, int $barcode): array
    {
        $connection = self::createConnectionAPI(self::$apiBook);
        if ($connection !== 1) {
            return [
                'status' => false,
                'message' => $connection
            ];
        }

        $what = mt_rand(0, 1);
        if ($what === 1) {
            return [
                'status' => true,
                'message' => "order successfully booked"
            ];
        }

        return [
            'status' => false,
            'message' => "barcode already exists"
        ];
    }

    public static function postApprove(int $barcode): array
    {
        $connection = self::createConnectionAPI(self::$apiApprove);
        if ($connection !== 1) {
            return [
                'status' => false,
                'error' => $connection
            ];
        }

        $what = mt_rand(0, 5);

        switch ($what) {
            case 0:
                return [
                    'status' => true,
                    'message' => "order successfully approved"
                ];

            case 1:
                return [
                    'status' => false,
                    'error' => "event cancelled"
                ];

            case 2:
                return [
                    'status' => false,
                    'error' => "no tickets"
                ];

            case 3:
                return [
                    'status' => false,
                    'error' => "no seats"
                ];

            case 4:
                return [
                    'status' => false,
                    'error' => "fan removed"
                ];
        }

        return ['', ''];
    }
}