<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
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
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="stiles.css">
        <title>6Back_form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha385-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn5FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <style>
            table,
            form {

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

            td {
                margin: 15px;
                border: 1px solid rgb(85, 85, 85);
            }
        </style>

    </head>

    <body>
        <div class="row row-cols-lg-2 g-2 ">
            <table class="position-absolute top-0 start-0">
                <div class="col-6 ">
                    <!--ряд с ячейками заголовков-->
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

                    <!-- ______________________________________________Заполнить таблицуданными из формы______________________ -->
                    <?php
                    $user = 'u47586';
                    $pass = '3927785';
                    $db = new PDO('mysql:host=localhost;dbname=u47586', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    try {
                        $sm = $db->prepare('SELECT * FROM `MainData`');
                        $ss = $db->prepare('SELECT * FROM `Superpovers`'); // запрос данных пользователя
                        $ss->execute();
                        $sm->execute();
                        // $maindata = $sm->fetchAll(PDO::FETCH_ASSOC);
                        // $super = $ss->fetchAll(PDO::FETCH_ASSOC);
                        while ($rowm = $sm->fetch()) {
                            $rows = $ss->fetch();
                            print("<tr><td>" . $rowm["id"] . "</td>
                               <td>" . $rowm["name"] . "</td>
                               <td>" . $rowm["email"] . "</td>
                               <td>" . $rowm["age"] . "</td>
                               <td>" . $rowm["gender"] . "</td>
                               <td>" . $rowm["numberOfLimb"] . "</td>
                               <td>" . $rows["superpower"] . "</td>
                               <td>" . $rowm["biography"] . "</td></tr>"
                            );
                        }
                    } catch (PDOException $e) {
                        print('Error:' . $e->GetMessage());
                        exit();
                    }
                    ?>
                </div>
                <!-- ______________________________________________Редактировать данные______________________ -->
                <div class="col-6 ">
                    <form action="" method="POST">
                        <label> Выберите ID:<br />
                            <input name="id" value="" /></label><br />
                        <input name="butt1" type="submit" value="Выбрать" />
                    </form>

                    <form action="" method="POST">
                        <label> Имя:<br />
                            <input name="name" value="<?php print $values['name']; ?>" /></label><br />

                        <label> e-mail:<br />
                            <input name="email" value="<?php print $values['email']; ?>" type="email" /> </label><br />

                        <label> Дата рождения:<br /><input name="date" value="<?php print $values['date']; ?>" type="date" /></label><br />

                        Пол:<br />
                        <label><input type="radio" <?php if (isset($values['gender']) && $values['gender'] == "m") print ' checked="checked"'; ?> checked="checked" name="gender" value="m" /> М</label>
                        <label><input type="radio" <?php if (isset($values['gender']) && $values['gender'] == "w") print ' checked="checked"'; ?> name="gender" value="w" /> Ж</label><br />

                        Количество конечностей:<br />
                        <label><input type="radio" <?php if (isset($values['hand']) && $values['hand'] == 1) print ' checked="checked"'; ?> checked="checked" name="hand" value="1" />1</label>
                        <label><input type="radio" <?php if (isset($values['hand']) && $values['hand'] == 2) print ' checked="checked"'; ?> name="hand" value="2" /> 2</label>
                        <label><input type="radio" <?php if (isset($values['hand']) && $values['hand'] == 3) print ' checked="checked"'; ?> name="hand" value="3" /> 3</label>
                        <label><input type="radio" <?php if (isset($values['hand']) && $values['hand'] == 4) print ' checked="checked"'; ?> name="hand" value="4" /> 4</label>
                        <label><input type="radio" <?php if (isset($values['hand']) && $values['hand'] == 5) print ' checked="checked"'; ?> name="hand" value="5" /> 5</label>

                        <label>Сверхспособности:<br />
                            <input name="Superpovers" value="<?php print $values['name']; ?>" /></label><br />

                        <label>Биография:<br />
                            <textarea name="biography"><?php print $values['biography']; ?></textarea>
                        </label><br />
                        <br />
                        <input name="butt2" type="submit" value="Изменить" />
                        <!-- <input name="butt2" type="submit" value="Вход" /> -->
                        <input name="butt2" type="submit" value="Удалить" />
                    </form>
                </div>
        </div>
        </table>
    </body>

    </html>
<?php
} else {
    
}
?>
