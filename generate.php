<?php
require_once __DIR__ . "/vendor/autoload.php";

use Helpers\NetworkHelper;

$isAjax = $_REQUEST["isAjax"] ?? false;
$ip = $_REQUEST["ip"] ?? "";

if ($isAjax) {
    NetworkHelper::generate($ip);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/styles.css" />
        <script src="/js/jquery.js"></script>
        <script src="/js/script.js"></script>
        <title>Дополнительно тестовое задание</title>
    </head>
    <body>
        <div class="content-wrapper">
            <h1>Генерация случайного Mac-адреса</h1>

            <div class="form-content">
                <form id="form_generate" method="post">
                    <input type="hidden" name="isAjax" value="true">

                    <div class="input-form">
                        <label>IP-адрес</label>
                        <input type="text" name="ip" placeholder="192.168.1.52" required />
                    </div>

                    <div class="button-form">
                        <button type="submit">Сгенерировать</button>
                    </div>
                </form>

                <div class="response-wrapper">
                    <div class="response-message"></div>
                </div>
            </div>
        </div>
    </body>
</html>
