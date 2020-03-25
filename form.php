<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>ThE FoRm</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="Form">
			<div id="events">
				<p>Please fill out the form</p>
			</div>
			<form method="post" action="index.php" name="contract" >
				<div id="nam">
					<p>Name:<input maxlength="25" size="40" name="name" placeholder="First name Last Name"></p>
				</div>
				<div id="address">
					<p>Email:<input type="email" name="email" placeholder="email@yandex.ru"></p>
				</div>
				<div id="BIRHYEAR">
				<p>Year of Birth:
					<select name="year" >
						<option value="1998">1998</option>
						<option value="1999">1999</option>
						<option value="2000">2000</option>
						<option value="2001">2001</option>
						<option value="2002">2002</option>
						<option value="2003">2003</option>
					</select>
				</p>	
				</div>
				
				<p>Sex:
					<input type="radio" value="M" name="sex">Man
					<input type="radio" value="F" name="sex">Female
				</p>	
				<p>Limbs:
					<input type="radio" value="1" name="limbs">1
					<input type="radio" value="2" name="limbs">2
					<input type="radio" value="3" name="limbs">3
					<input type="radio" value="4" name="limbs">4
				</p>
				<p>	<label for='sverh[]'>Superpowers:</label></br>
					<select id="sposobnost" name="sverh[]" multiple="multiple" size="6">	
						<option value="net" >None</option>
						<option value="godmod">GodMode</option>
						<option value="levitation">Levitation</option>
						<option value="шnvisibility">Invisibility</option>
						<option value="telekinesis">Telekinesis</option>
						<option value="extrasensory">Extrasensory</option>
					</select>
				</p>
					<textarea cols="40" rows="4" name="biography" placeholder="Here is your brief biography..."></textarea>
					<p>Do you agree that you are selling your soul to the devil?
					<input type="checkbox" name="consent" value="yes"></p>
				<input type="submit" value="send">
			</form>
		</div>	
	</body>
</html>