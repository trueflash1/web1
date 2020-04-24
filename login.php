<?php
/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();
// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  $errors = array();
  $errors['login'] = !empty($_COOKIE['login_error']);
  $errors['pass'] = !empty($_COOKIE['pass_error']);

  // TODO: аналогично все поля.

  // Выдаем сообщения об ошибках.
  //printf($error[0]);
  if (!empty($errors['login'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('login_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Неверный login</div>';
  }
  else if(!empty($errors['pass'])){
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('pass_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Неверный пароль </div>';
  }
?>
<html lang="ru">
  	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">   <meta name="viewport" content="width=device-wedth,initial-scale=1.0">
		<link rel="stylesheet" href = "style.css">
		<title>login in web5</title>
	</head>
  <?php
    if (!empty($messages)) {
      print('<div id="messages">');
      // Выводим все сообщения.
      foreach ($messages as $message) {
        print($message);
      }
      print('</div>');
    }
  ?>
  <div class="container justify-content-center p=0 m=0" id="content">
    <form action="login.php" method="post">
      <p> <h2>Войдите для изменения данных </p>
      <p>Логин:</p>
      <input name="login" id="login"  placeholder="11111"/>
      <p>Пароль:</p>
      <input name="pass" id="pass" placeholder="пароль"/></br>
      <input type="submit" id="in" value="Войти"/>
      </h2>
    </form>
  </div>
</html>
<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  $errors = FALSE;
    if (empty($_POST['login'])) {
      // Выдаем куку на день с флажком об ошибке в поле fio.
      setcookie('login_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      // Сохраняем ранее введенное в форму значение на месяц.
      setcookie('login_value', $_POST['login'], time() + 30 * 24 * 60 * 60);
    }
    if (empty($_POST['pass'])) {
      setcookie('pass_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{
      setcookie('pass_value', $_POST['pass'], time() + 30 * 24 * 60 * 60);
    }
    if ($errors) {
      // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
      header('Location: login.php');
      exit();
    }
    else{
    setcookie('login_error', '', 100000);
    setcookie('pass_error', '', 100000);
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $user = 'u17372';
    $password = '8406446';
    $db = new PDO('mysql:host=localhost;dbname=u17372', $user, $password);
    extract($_POST);
    try {
      foreach($db->query('SELECT * FROM anketa') as $row){
        if($row['login']==$_POST['login']){//если логины совпадают проверяем пароли
          /*проверка хэшированого пароля
           возникает непонятная ошибка при которой происходит вход, но из БД данные НЕ переносятся
           и поля в form.php остаются пустыми(при проверка обычного пароля без хэширования такой ошибки нет),
           но при этом если начать редактировать поля, в БД они вносятся
          if(password_verify($_POST['pass'], $row['password'])){*/
          if($row['password']==$_POST['pass']){//успешно
            $_SESSION['login'] = $_POST['login'];
            // Записываем ID пользователя.
            $_SESSION['uid'] = $_POST['pass'];
            // Делаем перенаправление.
            $values['inName'] = $row['name'];
            $values['inEmail'] = $row['email'];
            $values['inDate'] = $row['date'];
            $values['inGender'] = $row['gender'];
            $values['inLimb'] = $row['limb'];
            $values['inSup1'] = $row['super1'];
            $values['inSup2'] = $row['super2'];
            $values['inSup3'] = $row['super3'];
            $values['inMessage'] = $row['message'];
            $values['checker'] = $row['checker'];
            setcookie('save', '1');
            header('Location: index.php');
          }
          else{//неверный пароль
            $errors = TRUE;
            setcookie('pass_error', '1s', time() + 24 * 60 * 60);
          }
        }
      }
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
    setcookie('save', '1');
    //если пришел сюда, то введеного логина в БД нет
    $errors = TRUE;
    setcookie('login_error', '1', time() + 24 * 60 * 60);
    if ($errors) {
      // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
      header('Location: login.php');
      exit();
    }
  }
}
