<html lang="ru">
  <head>
      <title>Задание 4</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="style.css" type="text/css" rel="stylesheet">
  </head>
  <body>

    <form action="" method="POST">

        <?php
        if (!empty($messages)) {
          print('<div id="messages">');
          // Выводим все сообщения.
          foreach ($messages as $message) {
            print($message);
          }
          print('</div>');
        }

        // Далее выводим форму отмечая элементы с ошибками классом error
        // и задавая начальные значения элементов ранее сохраненными.
        ?>


      <!-- Name -->
        <br>
      <label for="nameInput">Name </label>
      <input id="nameInput" name="name" type="text" <?php if ($errors['name']) {print 'class="error"';} ?> value="<?php print $values['name']; ?>" />
        <br>
      <!-- Email --><br>
      <label for="emailInput">Email </label>
      <input id="emailInput" name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
        <br>
      <!-- Year --><br>
      <label for="selectInput">Birthday year</label>
      <select name="year">
          <?php
            for ($i = 2014; $i > 1965; $i--) {
              print('<option value="'.$i.'" ');
              if ($values['year'] == $i) print('selected ');
              print('>'.$i.'</option> ');
            }
           ?>
      </select>
        <br>
      <!-- Sex --><br>
      <label>Sex</label>
      <label>
          <input type="radio" name="sex" value="male" <?php if ($values['sex'] == 'male') print("checked"); ?> >
           Male
      </label>
      <label>
          <input type="radio" name="sex" value="female" <?php if ($values['sex'] == 'female') print("checked"); ?> >
           Female
      </label>
        <br>
      <!-- Limbs --><br>
      <label>Limbs count</label>
      <label>
          <input type="radio" name="limbs" value="2" <?php if ($values['limbs'] == 2) print("checked"); ?> >
           2
      </label>
      <label>
          <input type="radio" name="limbs" value="4" <?php if ($values['limbs'] == 4) print("checked"); ?> >
           4
      </label>
      <label>
          <input type="radio" name="limbs" value="8" <?php if ($values['limbs'] == 8) print("checked"); ?> >
           8
      </label>
        <br>
      <!-- Powers --><br>
      <label for="powersSelect">Powers</label>
      <select id="powersSelect" <?php if ($errors['powers']) {print 'class="error"';} ?> name="powers[]" multiple size="4">
         <?php
            foreach ($powers as $key => $value) {
                $selected = empty($values['powers'][$key]) ? '' : ' selected="selected" ';
                printf('<option value="%s",%s>%s</option>', $key, $selected, $value);
            }
         ?>
      </select>
        <br>
      <!-- Bio --><br>
      <label for="bioArea">Bio</label>
      <textarea id="bioArea" name="bio" rows="8" cols="30" placeholder="Write somthing about you..." <?php if ($errors['bio']) {print 'class="error"';} ?>><?php print $values['bio']; ?></textarea>
        <br>
      <!-- Check --><br>
      <label <?php if ($errors['check']) {print 'class="error"';} ?>><input type="checkbox" name="check" value="ok"> I Agree with Terms</label>
        <br>
      <!-- Button --><br>
      <input type="submit" value="Send" />
    </form>
  </body>
</html>
