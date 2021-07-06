<?php
require_once __DIR__ . "/vendor/autoload.php";

use Helpers\NetworkHelper;

$subnet = $_REQUEST["subnet"] ?? "192.168.1.200-255";
$macAddresses = NetworkHelper::exportBySubnet($subnet);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/styles.css" />
        <title>Дополнительно тестовое задание</title>
    </head>
    <body>
        <div class="content-wrapper">
            <h1>Список добавленных Mac-адресов по указанной подсети - <?= $subnet; ?></h1>

            <div class="table-content">
                <table cellspacing="0">
                    <thead>
                    <th>ID</th>
                    <th>MAC-адрес</th>
                    <th>IP-адрес</th>
                    <th>Статус</th>
                    <th>Изменить статус</th>
                    </thead>

                    <tbody>
                    <? foreach ($macAddresses as $macAddress):
                        $rowStyle = $macAddress->status ? "active" : "no-active";
                    ?>
                        <tr class="<?= $rowStyle; ?>">
                            <td><?= $macAddress->id; ?></td>
                            <td><?= $macAddress->name; ?></td>
                            <td><?= $macAddress->ip; ?></td>

                            <? if ($macAddress->status): ?>
                                <td>Активен</td>
                                <td>
                                    <button>Деактивировать</button>
                                </td>
                            <? else: ?>
                                <td>Не активен</td>
                                <td>
                                    <button >Активировать</button>
                                </td>
                            <? endif; ?>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
