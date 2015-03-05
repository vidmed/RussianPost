# Описание
Inegration (SDK) with RussianPost (Почта России) API

# API документация
http://russianpostcalc.ru/api-devel.php

# Требования
- php >= 5.3.0
- включенное php расширение curl

# Использование
- Установите данное расширение
- Задайте url к api, apiKey и пароль(не обязательно)
- Доступные методы :
~~~
[php]

\Sdk\RussianPostSdk::init($wsdl_path, $login[, $password);
$res = \Sdk\RussianPostSdk::calc($from_index, $to_index, $weight, $ob_cennost_rub);
~~~
# Возвращаемы данные
- массив
- или исключение Exception

# Пример
~~~
[php]

require('RussianPostSdk.php');
try{
    \Sdk\RussianPostSdk::init('http://russianpostcalc.ru/api_beta_077.php', 'apiKey','password');
    $res = \Sdk\RussianPostSdk::calc("101000", "600000", "1.34", "1000");

} catch (Exception $e) {
    ...
}
~~~
