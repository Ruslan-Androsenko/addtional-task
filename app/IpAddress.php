<?php

namespace App;

use Helpers\DataBase;


/** Модель для работы с IP-адресами */
class IpAddress extends DataBase
{
    /** @var string Название таблицы с IP-адресами */
    public static $tableName = "ip_addresses";

    /** @var integer ID */
    private $id;

    /** @var string IP-адрес */
    private $name;


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

    public function save()
    {
        $query = "insert into " . self::$tableName . " values (null, '{$this->name}')";
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
    }

    public function isValidate()
    {
        $patternFragment = '((25[0-5])|(2[0-4]\d)|(1\d{2})|(\d{1,2}))';
        $patternIp = "/($patternFragment\.){3}$patternFragment/";
        preg_match($patternIp, $this->name, $matches);

        return strcmp($this->name, $matches[0]) == 0;
    }
}