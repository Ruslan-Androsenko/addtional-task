<?php

namespace Helpers;

use App\MacAddress;


/** Хелпер для работы с сетевыми запросами */
class NetworkHelper
{
    public static function exportBySubnet($subnet)
    {
        $pattern = "/(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})-(\d{1,3})+/";

        $ipBegin = preg_replace($pattern, "$1.$2.$3.", $subnet);
        $rangeStart = preg_replace($pattern, "$4", $subnet);
        $rangeEnd = preg_replace($pattern, "$5", $subnet);

        preg_match($pattern, $subnet, $matches);

        $macAddressList = [];

        if (!empty($matches)) {
            $macAddresses = new MacAddress();
            $macAddressList = $macAddresses->getListBySubnet($ipBegin, $rangeStart, $rangeEnd);
        }

        return $macAddressList;
    }
}