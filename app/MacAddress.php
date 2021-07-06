<?php

namespace App;

use Helpers\DataBase;


/** Модель для работы с Mac-адресами */
class MacAddress extends DataBase
{
    /** @var string Название таблицы с Mac-адресами */
    public static $tableName = "mac_addresses";

    /** @var integer ID */
    private $id;

    /** @var string Mac-адрес */
    private $name;

    /** @var string IP-адрес */
    private $ip;

    /** @var integer IP address ID */
    private $ip_address_id;

    /** @var integer Статус */
    private $status;

    /** @var integer Количество попыток для создания уникального значения */
    private $attempts;


    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /** Получение свойства модели
     * @param $field string Имя поля */
    public function __get($field)
    {
        return property_exists(self::class, $field) ? $this->$field : "";
    }

    /** Установка свойств модели
     * @param $attributes string[] Массив свойств со значениями */
    public function setAttributes($attributes)
    {
        foreach ($attributes as $field => $value) {
            if (property_exists(self::class, $field)) {
                $this->$field = $value;
            }
        }
    }

    /** Получить записи по указанной подсети
     * @param $ipBegin string Начало IP-адреса
     * @param $rangeStart integer Левая граница диапазопа
     * @param $rangeEnd integer Правая граница диапазопа */
    public function getListBySubnet($ipBegin, $rangeStart, $rangeEnd)
    {
        $query = "
            select macAddr.id as id, macAddr.name as name, macAddr.status, ipAddr.name as ip    
                
            from " . self::$tableName . " as macAddr
            join " . IpAddress::$tableName . " as ipAddr on ipAddr.id = macAddr.ip_address_id
            where ipAddr.name like '{$ipBegin}%' and 
            cast(substring_index(substring_index(ipAddr.name, '.', -1), '/', 1) as unsigned) between {$rangeStart} and {$rangeEnd}
        ";
        $res = $this->db->query($query);

        while ($row = $res->fetch_assoc()) {
            $macAddress = new self();
            $macAddress->setAttributes($row);

            $records[] = $macAddress;
        }

        return $records;
    }
}