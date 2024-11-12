<?php

namespace src\Order;

interface InterfaceBarcode
{
    public static function generateBarcode(): int;
}