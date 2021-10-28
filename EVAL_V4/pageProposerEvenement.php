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
				$typeSport = htmlspecialchars($_POST['typeSport']);
				$point = strpos($_FILES['miniature']['name'],'.');
				$nomImage = substr($_FILES['miniature']['name'], 0 , $point);
				$nomImage = strtolower($nomImage);
				$nomImage = str_replace(' ','',$nomImage);
				$ins = $bdd->prepare('INSERT INTO bc_event(titre, img,description,dateEvent,sport,lieu,typeSport,nbConsult,vote,valider,id_sport) VALUES (?,?,?,?,?,?,?,1,0,0,?)');
				$ins->execute(array($nom,$nomImage,$description,$dateDebut,utf8_decode($spo),$lieu,$typeSport,$sport));
				$chemin = 'img/'.$nomImage.'.jpg';
				move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
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
    <h1>Proposer un événement</h1>
    <form  method="post" enctype="multipart/form-data">
        <section class="search">
          <fieldset>
            <legend>Données de l'événement :</legend>
							<div>
								<label for="nom">Nom du evenement: </label><input id="nom" name="nom" type="text"  placeholder="Nom de l'événement"/>
								<label for="description">Description du evenement: </label><textarea id="description" name="description" rows="2" cols="20"  placeholder="Description"></textarea>
								<label for="dateDebut">Date du evenement : </label><input id="dateDebut" name="dateDebut" type="date" /> 
								<label for="sport">Sport: </label>
								<select id="sport" name="sport">
									<option  value="8">Ski</option>
									<option  value="9">Randonnée</option>
									<option  value="11">Chute Libre</option>
									<option  value="12">Tyrolienne</option>
								</select>
								
								<label for="typeSport">Type Sport (Individuel ou Collectif): </label>
								<select id="typeSport" name="typeSport">
											<option  value="Individuel">Individuel</option>
											<option  value="Collectif">Collectif</option>
											<option  value="Collectif et Individuel">Collectif et Individuel</option>
								</select>
								<label for="lieu">Lieu : </label><input id="lieu" name="lieu" type="text" placeholder="lieu de l'événement"/>
								<label for="images">Image : </label><input type="file" name="miniature" id="images" />
							</div>
							<div>
								<label for="nomContact">Nom de la personne de contact : </label><input id="nomContact" name="nomContact" type="text"  placeholder="Nom de la personne de contact"> 
								<label for="gsm">Gsm de la personne de contact : </label><input id="gsm" name="gsm" type="text"  placeholder="Gsm de la personne de contact">
								<label for="mail">Adresse mail de la personne de contact : </label><input id="mail" name="mail" type="email"  placeholder="Adresse mail de la personne de contact"> 
							</div>
							<input type="submit" name="buttonSubmit" value="Envoyer la demande"> 
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