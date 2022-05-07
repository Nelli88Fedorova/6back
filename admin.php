<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/
  // Пример HTTP-аутентификации.
    // PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
    // Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
    if (
        empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])
        || $_SERVER['PHP_AUTH_USER'] != 'admin' || md5($_SERVER['PHP_AUTH_PW']) != md5('123')
    ) {
        header('HTTP/1.1 401 Unanthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        print('<h1>401 Требуется авторизация</h1>');
        exit();
    }

    print('Вы успешно авторизовались и видите защищенные паролем данные.');
    // *********
    // Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
    // Реализовать просмотр и удаление всех данных.
    // *********
?>
    <!DOCTYPE html>
<html>

<head>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="stiles.css">
      <title>6Back_form</title>
      <style>
            table {
                  border: 2px solid rgb(0, 128, 0);
                  font-size: x-large;
                  text-align: center;
                  max-width: 420px;
                  margin: 0 auto;
                  margin-top: 50px;
            }

      </style>

</head>

<body>
    <table >
    <tr><th>ID</th><th>Имя</th><th>email</th><th>Дата рождения</th><th>Пол</th><th>Количество конечностей</th><th>Сверхспособности</th><th>Биография</th></tr> <!--ряд с ячейками заголовков-->
    <tr><td>1</td><td>Пример</td></tr> <!--ряд с ячейками тела таблицы-->
    </table>
    </body>

</html>
