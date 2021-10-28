<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
	
?>

<?php
	if($_GET['id'] ==1){
		$article = $bdd->query('SELECT * FROM bc_image_propose INNER JOIN bc_event  ON bc_image_propose.id_article = bc_event.id_event  WHERE bc_image_propose.valider = 0');
	
	
	}else if($_GET['id'] ==2){
		$article = $bdd->query('SELECT * FROM bc_lieu_image_propose INNER JOIN bc_lieu  ON bc_lieu_image_propose.id_article = bc_lieu.id_lieu  WHERE bc_lieu_image_propose.valider = 0');
	
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
    <h1>Valider photo</h1>
		<?php
			while($a = $article->fetch()) { 
			
				if($_GET['id'] ==1){
					if(isset($_POST['valider'])){
						if(isset($_POST['identifiant']) AND !empty($_POST['identifiant'])){
							$identifiant = htmlspecialchars($_POST['identifiant']);
							$update =  $bdd->prepare('UPDATE bc_image_propose SET valider = 1 WHERE id_propose = ? AND valider = 0');
							$update->execute(array($identifiant));
							$statut = "Image ajoutée";
						}else{
							$statut = "Image non ajoutée verifié l'identifiant";
						}
					}else if(isset($_POST['reject'])){
						if(isset($_POST['identifiant']) AND !empty($_POST['identifiant'])){
							$identifiant = htmlspecialchars($_POST['identifiant']);
							$delete =  $bdd->prepare('DELETE FROM bc_image_propose WHERE id_propose = ? AND valider = 0');
							$delete->execute(array($identifiant));
							$statut = "Image rejettée";
						}else{
							$statut = "Image non rejettée verifié l'identifiant";
						}
					}
					}else if($_GET['id'] ==2){
						if(isset($_POST['valider'])){
							if(isset($_POST['identifiant']) AND !empty($_POST['identifiant'])){
								$identifiant = htmlspecialchars($_POST['identifiant']);
								$update =  $bdd->prepare('UPDATE bc_lieu_image_propose SET valider = 1 WHERE id_propose = ? AND valider = 0');
								$update->execute(array($identifiant));
								$statut = "Image ajoutée";
							}else{
								$statut = "Image non ajoutée verifié l'identifiant";
							}
						}else if(isset($_POST['reject'])){
							if(isset($_POST['identifiant']) AND !empty($_POST['identifiant'])){
								$identifiant = htmlspecialchars($_POST['identifiant']);
								$delete =  $bdd->prepare('DELETE FROM bc_lieu_image_propose WHERE id_propose = ? AND valider = 0');
								$delete->execute(array($identifiant));
								$statut = "Image rejettée";
							}else{
								$statut = "Image non rejettée verifié l'identifiant";
							}
						}
				}
			
			
		?>
    <form method="post" enctype="application/x-www-form-urlencoded">
      <section class="search">
				<fieldset>
          <h2>Données du lieu :</h2>
					<div>
						<div>Identifiant de l'image : <?= $a['id_propose']?> </div>
						<img class="sousImage" src="img/<?= $a['img']?>.jpg" alt="image">
						<div>Nom de l'événement : <?= utf8_encode($a['titre'])?></div>
						<div>Sport : <?= utf8_encode($a['sport'])?></div>
						<div> Image proposée </div>
						<div><img class="sousImage" src="img/<?= $a['image']?>.jpg" alt="image"></div>
						
					</div>
				</fieldset>
      </section>
     </form> 
	
    <?php 
			}
		?>
		<?php
				if($article->rowCount() != 0){
		?>
		<section class="search">
			<form method="post" enctype="application/x-www-form-urlencoded">
				<label for="identifiant">Veuillez confirmez l'identifiant : </label><input id="identifiant" name="identifiant" type="text" placeholder="Identifiant de l'image"/>
					<input type="submit" name="valider" value="Valider la photo"/> 
					<input type="submit" name="reject" value="Rejetter la photo"/>
				</form> 
		</section>
		
		<?php
			}
			if(isset($statut)){echo $statut;}
		?>
		 
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