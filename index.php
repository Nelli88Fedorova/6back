<?php
header('Content-Type: text/html; charset=UTF-8');
$string = array(
  'exitlog1' => '<div class="for" style="color:green"> Выход выполнен.</div>',
  'exitlog2' => '<div class="for" style="color:green"> Вы не авторизованы.</div>',
  'enterlog' => '<div class="for" style="color:red"> Ошибка входа.</div>',
  'enterlogerror' => '<div class="for" style="color:green"> заполните все поля.</div>',
  'registration' => '<div class="for" style="color:green"> Что бы начать регистрацию выйдете из аккаунта.</div>',
  'notexist' => '<div class="for" style="color:red"> Пользователь не существует!</div>',
  'wrong' => '<div class="for" style="color:red"> Неверный пароль!</div>',
);
$msg = array();
foreach ($string as $name => $str) {
  if (isset($_COOKIE[$name]))
    $msg[$name] = $str;
  else $msg[$name] = '';
  setcookie($name, '', time() - 100000);
}

//_____________________________________________________GET____________________________________________________
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stiles.css">
    <title>6Back_index</title>
    <style>
      .for {
        border: 2px solid rgb(26, 18, 144);
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
        <label> login:<br />
          <input name="login" value="<?php if (isset($_COOKIE['login'])) print($_COOKIE['login']);
                                      else print(''); ?>" />
        </label><br />

        <label> password:<br />
          <input name="pass" value="<?php if (isset($_COOKIE['pass'])) print($_COOKIE['pass']);
                                    else print(''); ?>" />
        </label><br />

        <input name="buttlog" type="submit" value="Enter" />
        <input name="registration" type="submit" value="Registration" />
        <input name="buttlog" type="submit" value="Admin" />
      </form>

      <?php
      foreach ($string as $name => $v) if (isset($msg[$name])) print($msg[$name]);
      ?>
    </div>
  </body>

  </html>
<?php
} //________________________________POST_______________________________
else {
  $loginu = $_POST['login'];
  $passu = $_POST['pass'];
  $button = 0;
  if (isset($_POST['buttlog']))
    switch ($_POST['buttlog']) {
      case 'Enter':
        $button = 1;
        break;
      case 'Registration':
        $button = 2;
        break;
      case 'Admin':
        $button = 3;
        break;
    }
  if ($button == 2) //Регистрация
  {
    if (isset($_COOKIE['all_OK'])) {
      unset($_SESSION['uid']);
      unset($_SESSION['login']);
      session_destroy();
      setcookie('all_OK', '', time() - 1000);
      setcookie('login', '', time() - 1000);
      setcookie('pass', '', time() - 1000);
      header('Location: user.php');
      exit();
    } else {
      header('Location: user.php');
      exit();
    }
  } else if ($button == 3) {//Админ
    if (isset($_COOKIE['all_OK'])) {
      unset($_SESSION['uid']);
      unset($_SESSION['login']);
      session_destroy();
      setcookie('all_OK', '', time() - 1000);
      setcookie('login', '', time() - 1000);
      setcookie('pass', '', time() - 1000);
      header('Location: admin.php');
      exit();
    } else {
      header('Location: admin.php');
      exit();
    }
  } else
  if ($button == 1) //Вход
  {
    if (!empty($loginu) && !empty($passu)) {
      //  Проверть есть ли такой логин и пароль в базе данных.
      //вход в БД
      $user = 'u47586';
      $pass = '3927785';
      $db = new PDO('mysql:host=localhost;dbname=u47586', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //поиск соответствующего логина
      try {
        $sth = $db->prepare("SELECT '*' FROM `users` WHERE `login` = ?");
        $sth->execute(array($loginu));
        $value = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
        print('Error:' . $e->GetMessage());
        exit();
      }
      if (empty($value)) // нет такого пользователя
      {
        setcookie('notexist', 1); // Выдать сообщение об ошибках.
        setcookie('login', 1, time() - 100);
        setcookie('login', $loginu);
        header('Location: index.php');
        exit();
      } else
      // if (MD5($passu)!==$value['pass']) {
      //   setcookie('wrong',1);
      //   setcookie('pass',1,time()-100);
      //   setcookie('pass',$passu);
      //   header('Location: index.php');
      //   exit();
      // } else
      { //Если все ок, то авторизуем пользователя.
        setcookie('all_OK', 1);
        session_start();
        $_SESSION['login'] = $loginu;
        $_SESSION['pass'] = $passu;
        $_SESSION['uid'] = $value['id'];
        header('Location: user.php'); //открыть форму
        exit();
      }
    } else {
      setcookie('enterlog', 1);
      header('Location: index.php'); //Ошибка входа
      exit();
    }
  }
}
