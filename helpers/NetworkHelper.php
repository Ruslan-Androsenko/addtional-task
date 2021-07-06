<?php

namespace Helpers;

use App\MacAddress;
use App\IpAddress;


/** Хелпер для работы с сетевыми запросами */
class NetworkHelper
{
    public static function generate($ip)
    {
        $response = [
            "message" => "Получаем существующую запись",
            "success" => true,
        ];

        // Получаем IP-адрес
        $ipAddress = new IpAddress();
        $ipAddress->load($ip);

        if (!$ipAddress->id) {
            // Если IP-дрес отсутствует, то добавляем его
            $ipAddress = new IpAddress();
            $ipAddress->setAttributes(["name" => $ip]);

            if ($ipAddress->isValidate()) {
                $ipAddress->save();

                $response["message"] = "Запись успешно добавлена";
            } else {
                $response["message"] = "Ошибка! Невалидный ip-адрес";
                $response["success"] = false;
            }
        }

        // Создаем новый MAC-адрес
        $macAddress = new MacAddress();
        $macAddress->setAttributes(["ip_address_id" => $ipAddress->id]);
        $macAddress->save();

        $response["macAddress"] = $macAddress->name;

        exit(json_encode($response));
    }

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