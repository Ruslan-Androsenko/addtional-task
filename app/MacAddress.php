<?php

namespace App;

use Helpers\DataBase;


/** Модель для работы с Mac-адресами */
class MacAddress extends DataBase
{
    /** @var string Название таблицы с Mac-адресами */
    public static $tableName = "mac_addresses";

    /** Максимально допустимое количество попыток для генерации уникального адреса */
    const COUNT_ATTEMPTS = 1000000;

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
        $records = [];

        while ($row = $res->fetch_assoc()) {
            $macAddress = new self();
            $macAddress->setAttributes($row);

            $records[] = $macAddress;
        }

        return $records;
    }

    public function save()
    {
        $this->makeNewMacAddress();

        $query = "insert into " . self::$tableName . " values (null, '{$this->name}', {$this->ip_address_id}, 1, {$this->attempts})";
        $this->db->query($query);
        $this->id = $this->db->insert_id;
    }

    public function load($name)
    {
        $query = "select * from " . self::$tableName . " where name = '{$name}'";
        $res = $this->db->query($query);

        if ($row = $res->fetch_assoc()) {
            $this->setAttributes($row);
        }

        return $this->id;
    }

    /** Генерация нового адреса */
    private function makeNewMacAddress()
    {
//        $first = base_convert(mt_rand(0, 0xffffff), 10, 16);
//        $second = base_convert(mt_rand(0, 0xffffff), 10, 16);
//
//        $this->name = implode(':', str_split(str_pad($first . $second, 12), 2));




        $attempts = 0;

        do {
            $first = base_convert(mt_rand(0, 0xffffff), 10, 16);
            $second = base_convert(mt_rand(0, 0xffffff), 10, 16);

            $macAddress = implode(':', str_split(str_pad($first . $second, 12), 2));

            if ($attempts++ > self::COUNT_ATTEMPTS) {
                $macAddress = "";
                break;
            }
        } while ($this->load($macAddress));

        $this->attempts = $attempts;
        $this->name = $macAddress;
    }
}