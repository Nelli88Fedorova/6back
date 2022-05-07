<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="stiles.css">
        <title>6Back_admin</title>
        <style>
            .for {
                border: 2px solid rgb(9, 128, 0);
                font-size: x-large;
                text-align: center;
                max-width: 420px;
                margin: 0 auto;
                margin-top: 50px;
            }

            input {
                margin-top: 10px;
                margin-bottom: 10px;
                font-size: x-large;
            }

            option {
                font-size: x-large;
            }
        </style>

    </head>

    <body>
        <div class="for">
            <form action="" method="POST">
                <h4>Admin</h4>
                <label> login:<br />
                    <input name="login" value="<?php if (isset($_COOKIE['login'])) print($_COOKIE['login']);
                                                else print(''); ?>" />
                </label><br />

                <label> password:<br />
                    <input name="pass" value="<?php if (isset($_COOKIE['pass'])) print($_COOKIE['pass']);
                                                else print(''); ?>" />
                </label><br />

                <input name="buttlog" type="submit" value="Enter" />
            </form>

            <?php
            foreach ($string as $name => $v) if (isset($msg[$name])) print($msg[$name]);
            ?>
        </div>
    </body>

    </html>
<?php
} else {

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
}

