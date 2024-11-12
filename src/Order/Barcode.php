<?php

namespace src\Order;

class Barcode implements InterfaceBarcode
{
    public static function generateBarcode(): int
    {
        return mt_rand(0, 9999999999);
    }
}