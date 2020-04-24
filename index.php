<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
// Массив для временного хранения сообщений пользователю.
$messages = array();
// В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
// Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    // Выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
    // Если в куках есть пароль, то выводим сообщение.
    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf("Вы можете <a href='login.php'>Войти</a> с логином <strong>%s</strong> и паролем <strong>%s</strong> для изменения данных.",
      strip_tags($_COOKIE['login']),
      strip_tags($_COOKIE['pass']));
    }
  }

  // Складываем признак ошибок в массив.
  $errors = array();

  $errors['inName'] = !empty($_COOKIE['inName_error']);
  $errors['inEmail'] = !empty($_COOKIE['inEmail_error']);
  $errors['inDate'] = !empty($_COOKIE['inDate_error']);
  $errors['inGender'] = !empty($_COOKIE['inGender_error']);
  $errors['inLimb'] = !empty($_COOKIE['inLimb_error']);
  $errors['inSuperpowers'] = !empty($_COOKIE['inSuperpowers_error']);
  $errors['inMessage'] = !empty($_COOKIE['inMessage_error']);
  $errors['checker'] = !empty($_COOKIE['checker_error']);
 
  // Выдаем сообщения об ошибках.
  if ($errors['inName']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('inName_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Заполните имя.</div>';
  }

  if ($errors['inEmail']) {
      setcookie('inEmail_error', '', 100000);
      $messages[] = '<div class="error">Заполните email в правильной форме</div>';
  }

  if ($errors['inDate']) {
      setcookie('inDate_error', '', 100000);
      $messages[] = '<div class="error">Заполните дату.</div>';
  }

  if ($errors['inGender']) {
      setcookie('inGender_error', '', 100000);
      $messages[] = '<div class="error">Выберите пол.</div>';
  }

  if ($errors['inLimb']) {
      setcookie('inLimb_error', '', 100000);
      $messages[] = '<div class="error">Выберите кол-во конечностей.</div>';
  }

  if ($errors['inSuperpowers']) {
      setcookie('inSuperpowers_error', '', 10000);
      $messages[] = '<div class="error">Выберите способность.</div>';
  }
  
  if ($errors['inMessage']) {
    setcookie('inMessage_error', '', 100000);
    $messages[] = '<div class="error">Введите сообщение.</div>';
  }

  if ($errors['checker']) {
    setcookie('checker_error', '', 100000);
    $messages[] = '<div class="error">Ознакомьтесь с контрактом.</div>';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  // При этом санитизуем все данные для безопасного отображения в браузере.
  
  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['inName'] = empty($_COOKIE['inName_value']) ? '' : strip_tags($_COOKIE['inName_value']);
  $values['inEmail'] = empty($_COOKIE['inEmail_value']) ? '' : strip_tags($_COOKIE['inEmail_value']);
  $values['inDate'] = empty($_COOKIE['inDate_value']) ? '' : strip_tags($_COOKIE['inDate_value']);
  $values['inGender'] = empty($_COOKIE['inGender_value']) ? '' :strip_tags($_COOKIE['inGender_value']);
  $values['inLimb'] = empty($_COOKIE['inLimb_value']) ? '' : strip_tags($_COOKIE['inLimb_value']);
  $values['inSup1'] = empty($_COOKIE['inSup1_value']) ? '' : strip_tags($_COOKIE['inSup1_value']);
  $values['inSup2'] = empty($_COOKIE['inSup2_value']) ? '' : strip_tags($_COOKIE['inSup2_value']);
  $values['inSup3'] = empty($_COOKIE['inSup3_value']) ? '' : strip_tags($_COOKIE['inSup3_value']);
  $values['inMessage'] = empty($_COOKIE['inMessage_value']) ? '' :strip_tags($_COOKIE['inMessage_value']);
  $values['checker'] = empty($_COOKIE['checker_value']) ? '' : strip_tags($_COOKIE['checker_value']);

  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.

  session_start();
  if ($errors && !empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])) {
    $login = $_SESSION['login'];
    $pass = $_SESSION['uid'];
    $user = 'u17372';
    $password = '8406446';
    $db = new PDO('mysql:host=localhost;dbname=u17372', $user, $password);
    try {
      foreach($db->query('SELECT * FROM anketa') as $row){
        if($row['login'] == $login){
          if($row['password'] == $pass){
            $values['inName'] = $row['name'];
            $values['inEmail'] = $row['email'];
            $values['inDate'] = $row['date'];
            $values['inGender'] = $row['gender'];
            $values['inLimb'] = $row['limb'];
            $values['inSup1'] = strip_tags($row['super1']);
            $values['inSup2'] = strip_tags($row['super2']);
            $values['inSup3'] = strip_tags($row['super3']);
            $values['inMessage'] = strip_tags($row['message']);
            $values['checker'] = $row['checker'];
            printf('Вход с логином %s, uid %d.', $_SESSION['login'], $_SESSION['uid']);
            break;
          }
        }
      }
    }
    catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
    }
  }
    // Включаем содержимое файла form.php.
    // В нем будут доступны переменные $messages, $errors и $values для вывода 
    // сообщений, полей с ранее заполненными данными и признаками ошибок.
    include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else{
  $action = $_POST['save'];
  switch ($action){
    case 'выйти':{//выходим из сессии и возвращаемся к index.php
      $values = array();
      $values['inName'] = null;
      $values['inEmail'] = null;
      $values['inDate'] = null;
      $values['inGender'] = null;
      $values['inLimb'] = null;
      $values['inSup1'] = null;
      $values['inSup2'] = null;
      $values['inSup3'] = null;
      $values['inMessage'] = null;
      $values['checker'] = null;
      session_start();
      if(!empty($_SESSION['login'])){
          setcookie('save', '', 100000);
          setcookie('login', '', 100000);
          setcookie('pass', '', 100000);
          setcookie('inName_value', '', 100000);
          setcookie('inEmail_value', '', 100000);
          setcookie('inDate_value', '', 100000);
          setcookie('inGender_value', '', 100000);
          setcookie('inLimb_value', '', 100000);
          setcookie('inSup1_value', '', 100000);
          setcookie('inSup2_value', '', 100000);
          setcookie('inSup3_value', '', 100000);
          setcookie('inMessage_value', '', 100000);
          setcookie('checker_value', '', 100000);
          $_COOKIE=array();
      }
      session_destroy();
      header('Location: index.php');
      break;
    }
    case 'войти':{//выходим из сессии и логинимся в login.php
      $values = array();
      $values['inName'] = null;
      $values['inEmail'] = null;
      $values['inDate'] = null;
      $values['inGender'] = null;
      $values['inLimb'] = null;
      $values['inSup1'] = null;
      $values['inSup2'] = null;
      $values['inSup3'] = null;
      $values['inMessage'] = null;
      $values['checker'] = null;
      session_start();
      if(!empty($_SESSION['login'])){
          setcookie('save', '', 100000);
          setcookie('login', '', 100000);
          setcookie('pass', '', 100000);
          setcookie('inName_value', '', 100000);
          setcookie('inEmail_value', '', 100000);
          setcookie('inDate_value', '', 100000);
          setcookie('inGender_value', '', 100000);
          setcookie('inLimb_value', '', 100000);
          setcookie('inSup1_value', '', 100000);
          setcookie('inSup2_value', '', 100000);
          setcookie('inSup3_value', '', 100000);
          setcookie('inMessage_value', '', 100000);
          setcookie('checker_value', '', 100000);
          $_COOKIE=array();
      }
      session_destroy();
      header('Location: login.php');
      break;
    }
    case 'сохранить':{//сохраняем данные
      // Проверяем ошибки.
      $errors = FALSE;  
      $messages[]='ok';
      if (empty($_POST['inName'])) {
        setcookie('inName_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
      else {
          setcookie('inName_value', $_POST['inName'], time() + 30 * 24 * 60 * 60);
      }

      if (!preg_match("|^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$|i", $_POST['inEmail'])) {
          setcookie('inEmail_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
      }
      else {
          setcookie('inEmail_value', $_POST['inEmail'], time() + 30 * 24 * 60 * 60);
      }

      if (empty($_POST['inDate'])) {
          setcookie('inDate_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
      }
      else {
          setcookie('inDate_value', $_POST['inDate'], time() + 30 * 24 * 60 * 60);
      }   

      if (empty($_POST['inGender'])) {
          setcookie('inGender_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
      }
      else {
          setcookie('inGender_value', $_POST['inGender'], time() + 30 * 24 * 60 * 60);
      }

      if (empty($_POST['inLimb'])) {
          setcookie('inLimb_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
      }
      else {
          setcookie('inLimb_value', $_POST['inLimb'], time() + 30 * 24 * 60 * 60);
      }

      if (!isset($_POST['inSup1'])
       && !isset($_POST['inSup2'])
       && !isset($_POST['inSup3'])) {
          setcookie('inSuperpowers_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
        }
      else {
        setcookie('inSup1_value', isset($_POST['inSup1']) ? $_POST['inSup1'] : '', time() + 365 * 30 * 24 * 60 * 60);
        setcookie('inSup2_value', isset($_POST['inSup2']) ? $_POST['inSup2'] : '', time() + 365 * 30 * 24 * 60 * 60);
        setcookie('inSup3_value', isset($_POST['inSup3']) ? $_POST['inSup3'] : '', time() + 365 * 30 * 24 * 60 * 60);
      }

      if (empty($_POST['inMessage'])) {
          setcookie('inMessage_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
      }
      else {
          setcookie('inMessage_value', $_POST['inMessage'], time() + 30 * 24 * 60 * 60);
      }

      if (empty($_POST['checker'])) {
          setcookie('checker_error', '1', time() + 24 * 60 * 60);
          $errors = TRUE;
      }
      else {
          setcookie('checker_value', $_POST['checker'], time() + 30 * 24 * 60 * 60);
      }

    if ($errors) {
      // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
      header('Location: index.php');
      exit();
    }
    else{
      // Удаляем Cookies с признаками ошибок.
      setcookie('inName_error', '', 100000);
      setcookie('inEmail_error', '', 100000);
      setcookie('inDate_error', '', 100000);
      setcookie('inGender_error', '', 100000);
      setcookie('inLimb_error', '', 100000);
      setcookie('inSuperpowers_error', '', 100000);
      setcookie('inMessage_error', '', 100000);
      setcookie('checker_error', '', 100000);
    }
    // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
      //если залогинились и изменяем данные
      if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
        setcookie('login', $login);
        setcookie('pass', $pass);
        extract($_POST);
        $user = 'u17372';
        $password = '8406446';
        $db = new PDO('mysql:host=localhost;dbname=u17372', $user, $password);
        extract($_POST);
        $login = $_SESSION['login'];
        $name = $_POST['inName'];
        $email = $_POST['inEmail'];
        $date = $_POST['inDate'];
        $gender = $_POST['inGender'];
        $limb = $_POST['inLimb'];
        if(!empty( $_POST['inSup1'])){
          $super1 = $_POST['inSup1'];
        }
        else{
          $super1 = '';
        }
        if(!empty( $_POST['inSup2'])){
          $super2 = $_POST['inSup2'];
        }
        else{
          $super2 = '';
        }
        if(!empty( $_POST['inSup3'])){
          $super3 = $_POST['inSup3'];
        }
        else{
          $super3 = '';
        }
        $message = $_POST['inMessage'];
        $checker = $_POST['checker'];
        try {
          $sth = $db->prepare("UPDATE anketa SET name=:name, email=:email, date=:date, gender=:gender, limb=:limb, super1=:super1, super2=:super2, super3=:super3, message=:message, checker=:checker WHERE login=:login");
          $sth->bindParam(':login', $login);
          $sth->bindParam(':name', $name);
          $sth->bindParam(':email', $email);
          $sth->bindParam(':date', $date);
          $sth->bindParam(':gender', $gender);
          $sth->bindParam(':limb', $limb);
          $sth->bindParam(':super1', $super1);
          $sth->bindParam(':super2', $super2);
          $sth->bindParam(':super3', $super3);
          $sth->bindParam(':message', $message);
          $sth->bindParam(':checker', $checker);
          $sth->execute();
        }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }  
      // Сохраняем куку с признаком успешного сохранения.
      setcookie('save', '1');
      $messages[] = 'Спасибо, результаты сохранены.';
      header('Location: index.php');
      }
      else {//если НОВЫЕ данные
        $user = 'u17372';
        $password = '8406446';
        $db = new PDO('mysql:host=localhost;dbname=u17372', $user, $password);
        extract($_POST);
        // Генерируем уникальный логин и пароль.
        $b=TRUE;
        try {
          while($b){
            $login = rand(1, 200);
            $pass = rand(1, 100);
            $b=FALSE;
            foreach($db->query('SELECT login FROM anketa') as $row){
              if($row['login']==$login){
                $b=TRUE;
              }
            }
          }
        }
        catch(PDOException $e){
          print('Error : ' . $e->getMessage());
          setcookie('save', '1');
          exit();
        }
        // Сохраняем в Cookies.
        setcookie('login', $login);
        setcookie('pass', $pass);
        extract($_POST);
        $user = 'u17372';
        $password = '8406446';
        $db = new PDO('mysql:host=localhost;dbname=u17372', $user, $password);
        /*хэширование пароля
        $hash = password_hash($pass, PASSWORD_BCRYPT); */
        $name = $_POST['inName'];
        $email = $_POST['inEmail'];
        $date = $_POST['inDate'];
        $gender = $_POST['inGender'];
        $limb = $_POST['inLimb'];
        if(!empty( $_POST['inSup1'])){
          $super1 = $_POST['inSup1'];
        }
        else{
          $super1 = '';
        }
        if(!empty( $_POST['inSup2'])){
          $super2 = $_POST['inSup2'];
        }
        else{
          $super2 = '';
        }
        if(!empty( $_POST['inSup3'])){
          $super3 = $_POST['inSup3'];
        }
        else{
          $super3 = '';
        }
        $message = $_POST['inMessage'];
        $checker = $_POST['checker'];
        try {
          $sth = $db->prepare("INSERT INTO anketa (login, password, name, email, date, gender, limb, super1, super2, super3, message, checker) VALUES (:login, :pass, :name, :email, :date, :gender, :limb, :super1, :super2, :super3, :message, :checker)");
          $sth->bindParam(':login', $login, PDO::PARAM_INT);
          /*внесение в базу хэшированого пароля
          $sth->bindParam(':pass', $hash);*/
          $sth->bindParam(':pass', $pass);
          $sth->bindParam(':name', $name);
          $sth->bindParam(':email', $email);
          $sth->bindParam(':date', $date);
          $sth->bindParam(':gender', $gender);
          $sth->bindParam(':limb', $limb);
          $sth->bindParam(':super1', $super1);
          $sth->bindParam(':super2', $super2);
          $sth->bindParam(':super3', $super3);
          $sth->bindParam(':message', $message);
          $sth->bindParam(':checker', $checker);
          $sth->execute();
        }
        catch(PDOException $e){
          print('Error : ' . $e->getMessage());
          exit();
        }
      }  
      // Сохраняем куку с признаком успешного сохранения.
      setcookie('save', '1');
      $messages[] = 'Спасибо, результаты сохранены.';
      header('Location: index.php');
    }
  }
}