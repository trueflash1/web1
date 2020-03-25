<?php
header('Content-Type:text/html;charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        print('this result saved.');
    }
    include('form.php');
    exit();
}
$errors = FALSE;
$name = $_POST["name"];
$email = $_POST["email"];
$year = $_POST["year"];
$sex =	$_POST["sex"];
$flag=FALSE;
$limbs = $_POST["limbs"];
$bio = $_POST["biography"];
$consent = $_POST["consent"];

if (empty($name)) {
    echo	"Укажите имя.<br/>";
    $errors = TRUE;
}else if(!preg_match("#^[aA-zZ0-9\-_]+$#",$_POST["name"])){
    print('error simvoli.<br/>');
    $errors=TRUE;
}
if (empty($email)){
    echo "error adress.<br/>";
    $errors = TRUE;
}
if	(empty($year)){
    echo "error year.<br/>";
    $errors = TRUE;
}
if	(empty($_POST["sex"])){
    echo "error pol.<br/>";
    $errors	= TRUE;
}
if	(empty($_POST["limbs"])){
    echo "error limbs.<br/>";
    $errors	= TRUE;
}
$Sverh = $_POST["sverh"];
if(!isset($Sverh))
{
    echo("<p>no select ability</p>\n");
}
else
{	echo"your abilities:<br/>";
for($i=0; $i < count($Sverh); $i++)
{
    if($Sverh[$i]=="net")$flag=TRUE;
}
}
if($flag){
    for($t=0;$t<count($Sverh);$t++){
        if($Sverh[$t]!="net")unset($Sverh[$t]);
    }
}else if(!empty($Sverh)){
    for($y=0;$y<count($Sverh);$y++){
        echo"$Sverh[$y]<br/>";
    }
}
$sverh_separated=implode(' ',$Sverh);
if	(empty($_POST["biography"])){
    echo "error history.<br/>";
    $errors	= TRUE;
}
if	(empty($_POST["consent"])){
    echo "zapolni galochku.<br/>";
    $errors	= TRUE;
}

if($errors){
    exit();
}
$user = 'u17372';
$pass = '8406446';
$db = new PDO('mysql:host=localhost;dbname=u17372', $user, $pass,
    array(PDO::ATTR_PERSISTENT => true));
try {
    $stmt = $db->prepare("INSERT INTO application (name, email, birth, sex, limbs, sverh, bio,consent)
 VALUES (:name, :email, :birth, :sex, :limbs, :birth,:bio, :consent)");
    $stmt->bindParam(':name', $name_db);
    $stmt->bindParam(':email', $email_db);
    $stmt->bindParam(':birth', $year_db);
    $stmt->bindParam(':sex', $sex_db);
    $stmt->bindParam(':limbs', $limb_db);
    $stmt->bindParam(':sverh', $sverh_db);
    $stmt->bindParam(':bio', $bio_db);
    $stmt->bindParam(':consent', $consent_db);
    $name_db=$_POST["name"];
    $email_db=$_POST["email"];
    $year_db=$_POST["year"];
    $sex_db=$_POST["sex"];
    $limb_db=$_POST["limbs"];
    $sverh_db=$sverh_separated;
    $bio_db=$_POST["biography"];
    $consent_db=$_POST["consent"];
    $stmt->execute();
}
catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}
header('Location: ?save=1');
?>