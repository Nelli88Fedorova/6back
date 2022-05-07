<!-- <?php

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
        // отредактировать и удалить данные
        //статистику по количеству пользователей с каждой сверхспособностью
        ?> -->
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
            max-width: auto;
            margin-top: 50px;
        }

        th {
            margin-left: 15px;
            border: 2px solid rgb(0, 128, 0);
        }
    </style>

</head>

<body>
    <table class="position-absolute top-0 start-0">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>email</th>
            <th>Дата рождения</th>
            <th>Пол</th>
            <th>Количество конечностей</th>
            <th>Сверхспособности</th>
            <th>Биография</th>
        </tr>
        <!--ряд с ячейками заголовков-->
        <tr>
            <td>1</td>
            <td>Пример</td>
        </tr>
        <!-- ______________________________________________Заполнить таблицуданными из формы______________________ -->
        <?php
        $user = 'u47586';
        $pass = '3927785';
        $db = new PDO('mysql:host=localhost;dbname=u47586', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $sm = $db->prepare('SELECT * FROM `MainData`'); 
            $ss = $db->prepare('SELECT * FROM `Superpovers`');// запрос данных пользователя
            $ss->execute();
            $sm->execute();
            // $maindata = $sm->fetchAll(PDO::FETCH_ASSOC);
            // $super = $ss->fetchAll(PDO::FETCH_ASSOC);
            while($rowm = $sm->fetch()){
                $rows = $ss->fetch();
                print(
                    "<tr><td>".$rowm["id"]."</td>
                    <td>".$rowm["name"]."</td>
                    <td>".$rowm["email"]."</td>
                <td>".$rowm["age"]."</td>
                <td>". $rowm["gender"]."</td>
                <td>". $rowm["numberOfLimb"]."</td>
                <td>". $rows["superpower"]."</td>
                <td>". $rowm["biography"]."</td></tr>"
            );
                // echo "<tr>";
                //     echo "<td>" . $row["id"] . "</td>";
                //     echo "<td>" . $row["name"] . "</td>";
                //     echo "<td>" . $row["age"] . "</td>";
                // echo "</tr>";
            }

        } catch (PDOException $e) {
            print('Error:' . $e->GetMessage());
            exit();
        }

        ?>

    </table>
</body>

</html>
