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
}