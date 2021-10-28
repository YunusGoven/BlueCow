<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		

?>
<?php
if(isset($_POST['buttonSubmit'])){
	if($_POST['sport'] == 8){
		$sport = htmlspecialchars($_POST['sport']);
		$spo = "Ski";
	}else if($_POST['sport'] == 9){
		$sport = htmlspecialchars($_POST['sport']);
		$spo = "Randonnée";
	} else if($_POST['sport'] == 11){
		$sport = htmlspecialchars($_POST['sport']);
		$spo = "Chute Libre";
	} else if($_POST['sport'] == 12){
		$sport = htmlspecialchars($_POST['sport']);
		$spo = "Tyrolienne";
	}
}
?>
<?php
		if(isset($_POST['nom'], $_POST['description'],$_POST['dateDebut'],$_POST['lieu'])) {
			if(!empty($_POST['nom']) AND !empty($_POST['description']) AND !empty($_POST['dateDebut'])  AND !empty($_POST['lieu'])) {	
				$nom = htmlspecialchars($_POST['nom']);
				$description = htmlspecialchars($_POST['description']);
				$dateDebut = $_POST['dateDebut'];
				$lieu = htmlspecialchars($_POST['lieu']);
				$point = strpos($_FILES['images']['name'],'.');
				$nomImage = substr($_FILES['images']['name'], 0 , $point);
				$nomImage = strtolower($nomImage);
				$nomImage = str_replace(' ','',$nomImage);
				$ins = $bdd->prepare('INSERT INTO bc_lieu(titre, img,description,dateLieu,sport,lieu,nbConsultation,vote,valider,id_sport) VALUES (?,?,?,?,?,?,1,0,1,?)');
				$ins->execute(array($nom,$nomImage,$description,$dateDebut,utf8_decode($spo),$lieu,$sport));
				$chemin = 'img/'.$nomImage.'.jpg';
				move_uploaded_file($_FILES['images']['tmp_name'], $chemin);
				$message = 'Votre article a bien été posté';
			 } else {
					$message = 'Veuillez remplir tous les champs';
			 }
		}
		
		
		
		$article = $bdd->query('SELECT * FROM bc_lieu WHERE valider = 0');	
		
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
    <h1>Ajouter un lieu</h1>
    <form method="post" enctype="multipart/form-data">
			<section class="search">
				<fieldset>
          <legend>Données du lieu :</legend>
					<div>
						<label for="nom">Nom du lieu: </label><input id="nom" name="nom" type="text"  placeholder="Nom de l'événement"/>
						<label for="description">Description du lieu: </label><textarea id="description" name="description" rows="2" cols="20"  placeholder="Description"></textarea>
						<label for="dateDebut">Date du lieu : </label><input id="dateDebut" name="dateDebut" type="date" /> 
						<label for="sport">Sport: </label>
						<select id="sport" name="sport">
							<option  value="8">Ski</option>
							<option  value="9">Randonnée</option>
							<option  value="11">Chute Libre</option>
							<option  value="12">Tyrolienne</option>
						</select>
						<label for="lieu">Lieu : </label><input id="lieu" name="lieu" type="text" placeholder="Lieu de l'événement"/>
						<label for="images">Image : </label><input type="file" name="images" id="images" />
					</div>
					<input type="submit" name="buttonSubmit" value="Ajouter le lieu"> 
        </fieldset>
      </section>
    </form>   
		<?php if(isset($message)) { echo $message; } ?>
		 <form method="post" enctype="multipart/form-data">
		<?php
			while($a = $article->fetch()) {
				
				if(isset($_POST['valider'])){
					if(isset($_POST['identifiant']) AND !empty($_POST['identifiant'])){
						$identifiant = htmlspecialchars($_POST['identifiant']);
						$insertEve = $bdd->prepare("UPDATE bc_lieu SET valider = 1 WHERE id_lieu = ?");
						$insertEve->execute(array($identifiant));
						$statut = "Evenement ajouté";
					}else{
						$statut = "Evenement non ajouté verifié l'identifiant";
					}
					
				}
		?>
			
			<section class="evenement">
				<ul>
					<li>Identifiant de l'article : <?= utf8_encode($a['id_lieu']) ?></li>
					<li>Titre : <?= utf8_encode($a['titre']) ?></li>
					<li>Description : <?= utf8_encode($a['description']) ?></li>
					<li>Sport : <?= utf8_encode($a['sport']) ?></li>
					<li>Date :  <?= utf8_encode($a['dateLieu']) ?></li>
					<li>Lieu : <?= utf8_encode($a['lieu']) ?></li>
				</ul>
			</section>
			
      <?php 
			}
			?>
			<?php
				if($article->rowCount() != 0){
			?>
			<section class="evenement">
				<label for="identifiant">Veuillez confirmez l'identifiant : </label><input id="identifiant" name="identifiant" type="text" placeholder="Identifiant de l'événement"/>
				<input type="submit" name="valider" value="Ajouter"> 
			</section>
			<?php 
			}
			if(isset($statut)){echo $statut;}
			
			?>
		</form>
		
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