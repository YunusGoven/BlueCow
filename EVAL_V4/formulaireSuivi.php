<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
		
?>
<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
    <title>Blue Cow - Formulaire de suivi</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>
  <body>
		<?php
			$titre = 'header';
			include("inc/header.inc.php");
		?>
    <h1>Suivi</h1>
		<section class="search">
			<h2> Vos sports favoris ainsi que vos événements favoris seront visibles ici.</h2>
			<form method="post" enctype="application/x-www-form-urlencoded">
				<label for="trier">Trier par : </label>
				<select id="trier" name="trier">
					<option value="C" selected>Nombre de consultations</option>
					<option value="D">Date antéchronologique</option>
					<option value="I">Sport individuelle</option>
					<option value="E">Sport en équipe</option>
				</select>
			</form>
		</section>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>  
  </body>
</html>