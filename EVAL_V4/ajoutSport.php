<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
	
		if(isset($_POST['nom'])) {
			if(!empty($_POST['nom'])) {
      
				$nom = htmlspecialchars($_POST['nom']);
				$point = strpos($_FILES['images']['name'],'.');
				$nomImage = substr($_FILES['images']['name'], 0 , $point);
				$nomImage = strtolower($nomImage);
				$nomImage = str_replace(' ','',$nomImage);
				$ins = $bdd->prepare('INSERT INTO bc_sport(titre, image,valide) VALUES (?,?,1)');
				$ins->execute(array($nom, $nomImage));
				$chemin = 'img/'.$nomImage.'.jpg';
				move_uploaded_file($_FILES['images']['tmp_name'], $chemin);
				$message = 'Votre article a bien été posté';			 
			} else {
				$message = 'Veuillez remplir tous les champs';
			}
		}
?>
<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
    <title>Blue Cow - Consultation</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body>
			<?php
				$titre = 'header';
				include("inc/header.inc.php");
			?>
    <?php
			if(isset($_SESSION['id'])){
		?>
    <h1>Ajouter un sport</h1>
		<form method="post" enctype="multipart/form-data">
			<section class="search">
					<fieldset>
						<legend>Données du sport :</legend>
						<div>
							<label for="nom">Nom de l'événement: </label><input id="nom" name="nom" type="text"  placeholder="Nom de l'événement">
							<label for="images">Photo ?</label><input id="images" type="file" name="images" accept="image/*, .jpg">
						</div>
						<input type="submit" name="buttonSubmit" value="Ajouter le sport"> 
					</fieldset>
				</section>
    </form>   
   <?php if(isset($message)) { echo $message; } ?>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>  
		<?php
			}else{
				header('Location: connexion.php');
			}
		?>
  </body>
</html>