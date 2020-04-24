<!DOCTYPE html>
<html lang="ru">
  	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">   <meta name="viewport" content="width=device-wedth,initial-scale=1.0">
		<link rel="stylesheet" href = "style.css">
		<title>web5</title>
	</head>

	<body>
		<div class="container justify-content-center p=0 m=0" id="content">
			<?php
				if (!empty($messages)) {
				print('<div id="messages">');
				// Выводим все сообщения.
				foreach ($messages as $mess) {
          print($mess);
				}
				print('</div><br/><br/>');
				}
			?>
			<form method="POST" action="">
				<legend>Контактная информация</legend>
				<label for="inName">Имя:</label><br>
				<input type="text" id="inName" name="inName" <?php if ($errors['inName']) {print 'class="error"';} ?> value="<?php print $values['inName']; ?>" placeholder="Name"><br>
				<label for="inEmail">e-mail:</label><br>
				<input type="text" id="inEmail" name="inEmail" <?php if ($errors['inEmail']) {print 'class="error"';} ?> value="<?php print $values['inEmail']; ?>" placeholder="email"><br>
				<br/>Дата рождения:<br/>
					<input name="inDate" id="inDate" <?php if ($errors['inDate']) {print 'class="error"';} ?> value="<?php print $values['inDate']; ?>" type="text" placeholder="01.01.2000"/><br/>
				<label for="inGender">Пол:</label><br>
					<input type="radio" name="inGender" value="male" <?php if ($values['inGender'] == 'male') {print 'checked="checked"';} ?>/> male<br>
					<input type="radio" name="inGender" value="female"  value="male" <?php if ($values['inGender'] == 'female') {print 'checked="checked"';} ?>/>Female<br>
				<label for="inLimb">Кол-во конечностей:</label><br>
				<input type="radio" name="inLimb" <?php if ($errors['inLimb']) {print 'class="error"';} ?> value="1" <?php if ($values['inLimb'] == '1') {print 'checked="checked"';} ?> />1
                <input type="radio" name="inLimb" <?php if ($errors['inLimb']) {print 'class="error"';} ?> value="2" <?php if ($values['inLimb'] == '2') {print 'checked="checked"';} ?> />2
                <input type="radio" name="inLimb" <?php if ($errors['inLimb']) {print 'class="error"';} ?> value="3" <?php if ($values['inLimb'] == '3') {print 'checked="checked"';} ?> />3
                <input type="radio" name="inLimb" <?php if ($errors['inLimb']) {print 'class="error"';} ?> value="4" <?php if ($values['inLimb'] == '4') {print 'checked="checked"';} ?> />4
                <input type="radio" name="inLimb" <?php if ($errors['inLimb']) {print 'class="error"';} ?> value=">4" <?php if ($values['inLimb'] == '>4') {print 'checked="checked"';} ?> />>4<br/>

                <label <?php if ($errors['inSuperpowers']) {print 'class="error"';} ?> for="inSuperpowers">Сверхспособности:</label><br>
					<input type="checkbox" name="inSup1" value="sup1" <?php if ($values['inSup1'] != '') {print 'checked="checked"';} ?> />Бессмертие<br/>
					<input type="checkbox" name="inSup2" value="sup2" <?php if ($values['inSup2'] != '') {print 'checked="checked"';} ?> />Прохождение сквозь стены<br/>
					<input type="checkbox" name="inSup3" value="sup3" <?php if ($values['inSup3'] != '') {print 'checked="checked"';} ?> />Левитация<br/>
                
				<textarea type="text" rows="10" cols="45" name="inMessage" placeholder="Сообщение"><?php printf($values['inMessage']);?></textarea><br>
				<input type="checkbox" name="checker" value="checker" <?php if ($values['checker'] != '') {print 'checked="checked"';} ?>> C контрактом ознакомлен<br/>
				<input type="submit" name="save" id="ok" value="сохранить" />
        <input type="submit" name="save" id="out" value="выйти"/>
        <input type="submit" name="save" id="out" value="войти"/>
      </form>
    </div>
  </body>
</html>