<?php header('Content-Type: text/html; charset=UTF-8');
//статистику по количеству пользователей с каждой сверхспособностью
$coo = array(
    'SELECTFROMMainData1', 'SELECTFROMSuperpovers1', 'UPDATEMainData', 'UPDATESuperpovers', 'DELETEusers1',
    'DELETESuperpovers1', 'DELETEMainData1'
);
foreach ($coo as $name) print('<th>   ' . $name . '= ' . $_COOKIE[$name] . '</th>');
$user = 'u47586';
$pass = '3927785';
$parametrs = array('name', 'email', 'age', 'gender', 'numberOfLimb', 'biography', 'id', 'superpower');
$val = array();
foreach ($parametrs as $n) {
    if (isset($_COOKIE[$n])) {
        $val[$n] = $_COOKIE[$n];
    } else $val[$n] = '';
}
$err = array(
    'wrongID' => '<div class="mes">Нет пользователя с таким ID.</div>',
    'emptyID' => '<div class="mes">Заполните поле ID.</div>',
    'change' => '<div class="mes">Данные изменены.</div>',
    'deletedOne' => '<div class="mes">Данные пользователя удалены.</div>',
    'deletedAll' => '<div class="mes">Данные удалены.</div>',
);
$mes = array();
foreach ($err as $n => $v) {
    if (isset($_COOKIE[$n])) {
        $mes[$n] = $v;
        setcookie($n, '', time() - 1000);
    } else $mes[$n] = '';
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_USER'] != 'admin' || md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
        header('HTTP/1.1 401 Unanthorized');
        header('WWW-Authenticate: Basic realm="My site"');
        print('<h1>401 Требуется авторизация</h1>');
        exit();
    } else {

?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <link rel="stylesheet" href="stiles.css">
            <title>6Back_Admin</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha385-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn5FJkqJByhZMI3AhiU" crossorigin="anonymous">
            <style>
                table,
                form {

                    border: 2px solid rgb(0, 128, 0);
                    font-size: medium;
                    max-width: auto;
                    text-align: center;
                    margin-top: 50px;
                }

                th {
                    margin: 15px;
                    border: 2px solid rgb(0, 128, 0);
                }

                td {
                    margin: 15px;
                    border: 1px solid rgb(85, 85, 85);
                }
                input,
                label {
                    margin-top: 5px;
                    margin-bottom: 5px;
                    font-size: medium;
                    text-align: center;
                }
                .mes{
                    color:rgb(230,126,34);
                    text-align: center;
                    font-size: medium;
                }
            </style>

        </head>

        <body>
            <div class="container col-10 p-4 ">
                <div class="row ">
                    <!-- class="position-absolute top-0 start-0" -->
                    <div class="col-9 ">
                        <table>
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
                        </table>
                    </div>
                    <!-- ______________________________________________Редактировать данные______________________ -->
                    <div class="col-3">
                        <?php
                        foreach ($err as $n => $v) {
                            if (isset($mes[$n])) {
                                print($mes[$n]);
                            }
                        }
                        ?>
                        <form action="" method="POST">
                            <label> Выберите ID:<br />
                                <input name="id" value="<?php print $val['id']; ?>" /></label><br />
                            <input name="butt1" type="submit" value="Выбрать" />
                            <input name="butt1" type="submit" value="Удалить Все записи" />
                        </form>

                        <form action="" method="POST">
                            <label> Имя:<br />
                                <input name="name" value="<?php print $val['name']; ?>" /></label><br />

                            <label> e-mail:<br />
                                <input name="email" value="<?php print $val['email']; ?>" type="email" /> </label><br />

                            <label> Дата рождения:<br /><input name="age" value="<?php print $val['age']; ?>" type="date" /></label><br />

                            Пол:
                            <label><input type="radio" <?php if (isset($values['gender']) && $values['gender'] == "m") print ' checked="checked"'; ?> checked="checked" name="gender" value="m" /> М</label>
                            <label><input type="radio" <?php if (isset($values['gender']) && $values['gender'] == "w") print ' checked="checked"'; ?> name="gender" value="w" /> Ж</label><br />

                            Количество конечностей:<br />
                            <label><input type="radio" <?php if (isset($values['numberOfLimb']) && $values['numberOfLimb'] == 1) print ' checked="checked"'; ?> checked="checked" name="numberOfLimb" value="1" />1</label>
                            <label><input type="radio" <?php if (isset($values['numberOfLimb']) && $values['numberOfLimb'] == 2) print ' checked="checked"'; ?> name="numberOfLimb" value="2" /> 2</label>
                            <label><input type="radio" <?php if (isset($values['numberOfLimb']) && $values['numberOfLimb'] == 3) print ' checked="checked"'; ?> name="numberOfLimb" value="3" /> 3</label>
                            <label><input type="radio" <?php if (isset($values['numberOfLimb']) && $values['numberOfLimb'] == 4) print ' checked="checked"'; ?> name="numberOfLimb" value="4" /> 4</label>
                            <label><input type="radio" <?php if (isset($values['numberOfLimb']) && $values['numberOfLimb'] == 5) print ' checked="checked"'; ?> name="numberOfLimb" value="5" /> 5</label>

                            <label> Сверхспособности:<br />
                                <input name="superpower" value="<?php print $val['superpower']; ?>" /></label><br />

                            <label>Биография:<br />
                                <textarea name="biography"><?php print $val['biography']; ?></textarea>
                            </label><br />
                            <input name="butt2" type="submit" value="Изменить" />
                            <!-- <input name="butt2" type="submit" value="Вход" /> -->
                            <input name="butt2" type="submit" value="Удалить пользователя" />
                        </form>

                    </div>
                </div>
            </div>
        </body>

        </html>
<?php
    }
} else {
    $idf;
    if (isset($_POST['id'])) {
        setcookie('id', $_POST['id']);
        $idf = $_POST['id'];
    }

    $db = new PDO('mysql:host=localhost;dbname=u47586', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['butt1'])) { //Выбор по ID

        if ($_POST['butt1'] == 'Выбрать') {
            try {
                $sm = $db->prepare("SELECT * FROM MainData WHERE id = ?");
                $sm->execute(array($idf));
                setcookie('SELECTFROMMainData1', $sm->rowCount());
                $mdata = $sm->fetch(PDO::FETCH_ASSOC);
                if (empty($mdata)) {
                    setcookie('wrongID', 1);
                    header('Location: admin.php');
                    exit();
                }

                $ss = $db->prepare("SELECT * FROM Superpovers WHERE id = ?");
                $ss->execute(array($idf));
                setcookie('SELECTFROMSuperpovers1', $ss->rowCount());
                $sdata = $ss->fetch(PDO::FETCH_ASSOC);

                foreach ($parametrs as $name) {
                    if ($name == 'superpower') setcookie('superpower', $sdata['superpower']);
                    else setcookie($name, $mdata[$name]);
                }
            } catch (PDOException $e) {
                print('Error:' . $e->GetMessage());
                exit();
            }
            header('Location: admin.php');
            exit();
        } else if ($_POST['butt1'] == 'Удалить Все записи') //Удалить все данные
        {
            try {
                $m = $db->query("TRUNCATE TABLE MainData");
                $s = $db->query("TRUNCATE TABLE Superpovers");
                $u = $db->query("TRUNCATE TABLE users");
            } catch (PDOException $e) {
                print('Error:' . $e->GetMessage());
                exit();
            }
            setcookie('deletedAll',1);
            header('Location: admin.php');
            exit();
        }
    } else if (isset($_POST['butt2'])) //Работа с 1 пользователем
    {
        // $idf = $_POST['id'];
        if (empty($_COOKIE['id'])) { //Пустое поле ID
            setcookie('emptyID', 1);
            header('Location: admin.php');
            exit();
        } else {
            $idf = $_COOKIE['id'];
            $p = array('name', 'email', 'age', 'gender', 'numberOfLimb', 'biography', 'superpower');
            $name = $_POST['name'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $numberOfLimb = $_POST['numberOfLimb'];
            $biography = $_POST['biography'];
            $syperpover = $_POST['superpower'];

            if ($_POST['butt2'] == 'Изменить') {
                $db = new PDO('mysql:host=localhost;dbname=u47586', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                try {
                    $stmt = $db->prepare("UPDATE MainData SET name =?, email =?, age=?, gender=?, numberOfLimb=?, biography=? WHERE id=?");
                    $stmt->execute(array($name, $email, $age, $gender, $numberOfLimb, $biography, $idf));
                    setcookie('UPDATEMainData', $stmt->rowCount());

                    $super = $db->prepare("UPDATE Superpovers SET superpower=?  WHERE id=?");
                    $super->execute(array($syperpover, $idf));
                    setcookie('UPDATESuperpovers', $super->rowCount());
                } catch (PDOException $e) {
                    print('Error:' . $e->GetMessage());
                    exit();
                }
                setcookie('change', 1,);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
            } else if ($_POST['butt2'] == 'Удалить пользователя') //Удалить 1 запись
            {
                try {
                    $sth1 = $db->prepare("DELETE FROM users WHERE id = ?");
                    $sth1->execute(array($idf));
                    setcookie('DELETEusers1', $sth1->rowCount());
                    $sth2 = $db->prepare("DELETE FROM Superpovers WHERE id = ?");
                    $sth2->execute(array($idf));
                    setcookie('DELETESuperpovers1', $sth2->rowCount());
                    $sth3 = $db->prepare("DELETE FROM MainData WHERE id = ?");
                    $sth3->execute(array($idf));
                    setcookie('DELETEMainData1', $sth3->rowCount());
                } catch (PDOException $e) {
                    print('Error:' . $e->GetMessage());
                    exit();
                }
                setcookie('deletedOne',1);
                header('Location: admin.php');
                exit();
            }
        }
    }
}
?>
