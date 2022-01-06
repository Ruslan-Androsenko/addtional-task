<?php



/**
 * $a = 123;
 * $b = 'a';
 * $$b = 321;
 *
 * print($a); // здесь выведется 321
 *
 * так как оператор интерполяции строки ($$b) получит строку которая прописана в $b,
 * и будет использовать ее как переменную.
 *
 * Это можно использовать для динамически созданных переменных.
 * Здесь используется косвенное присваивание, что может иногда ввести в заблуждение.
 */



// Работа с шаблонизатором
// Зписываем блок верстки в переменную
ob_start(); ?>
<div class="message">
    Привет, {Name}! <br />
    Давно не виделись, как поживает твой {ProductName}?
</div>
<? $message = ob_get_clean();

// Получаем данные из XML-файла
$fileDataMessage = $_SERVER["DOCUMENT_ROOT"] . "/docs/data_message.xml";
$xmlDataMessage = simplexml_load_file($fileDataMessage);

// Заменяем метки в верстке на конкретные значения
foreach ($xmlDataMessage as $key => $value) {
    $message = str_replace('{' . $key .'}', $value, $message);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Тестовое задание по PHP</title>
</head>
<body>
    <div class="message-wrapper">
        <?= $message; ?>
    </div>
</body>
</html>
