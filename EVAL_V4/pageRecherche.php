<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
		
		
?>
<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
    <title>Blue Cow - Recherche</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body>
		<?php
			$titre = 'header';
			include("inc/header.inc.php");
		?>  
    <?php
			$titre = 'corps';
			include("inc/recherche.inc.php");
		?>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>  
  </body>
</html>