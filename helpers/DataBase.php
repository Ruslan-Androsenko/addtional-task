<?php

namespace Helpers;


/** Хелпер для работы с базой данных */
class DataBase
{
    /**
     * @var \mysqli Объект для подключения к базе данных
     */
    protected $db;

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->db->close();
    }

    /** Подключение к базе данных */
    protected function connect()
    {
        $config = require $_SERVER["DOCUMENT_ROOT"] . "/config/db.php";
        $this->db = new \mysqli($config["dbHost"], $config["dbUser"], $config["dbPass"], $config["dbName"]);
    }
}