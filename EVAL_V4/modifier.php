<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118;charset=utf8', 'in18b1118', '9601');
		
	if(isset($_GET['id_lieu']) AND !empty($_GET['id_lieu'])) {
		$get_id = htmlspecialchars($_GET['id_lieu']);
		$article = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_lieu = ?');
		$article->execute(array($get_id));
		if($article->rowCount() == 1) {
			$article = $article->fetch();
			$title = utf8_encode($article['titre']);
			$img = utf8_encode($article['image']);
			$description = utf8_encode($article['description']);
			$dateEvent = utf8_encode($article['dateLieu']);
			$sport = utf8_encode($article['sport']);
			$lieu = utf8_encode($article['lieu']);
			$nbConsult = utf8_encode($article['nbConsultation']);
		}
	} else if(isset($_GET['id_event']) AND !empty($_GET['id_event'])) {
		$get_id = htmlspecialchars($_GET['id_event']);
		$article = $bdd->prepare('SELECT * FROM bc_event WHERE id_event = ?');
		$article->execute(array($get_id));
		if($article->rowCount() == 1) {
			$article = $article->fetch();
			$title = utf8_encode($article['titre']);
			$img = utf8_encode($article['img']);
			$description = utf8_encode($article['description']);
			$dateEvent = utf8_encode($article['dateEvent']);
			$sport = utf8_encode($article['sport']);
			$lieu = utf8_encode($article['lieu']);
			$nbConsult = utf8_encode($article['nbConsult']);
		}
	}
?>

<?php
	if(isset($_POST['valider'])){
?>			
<?php
	if(isset($_POST['newtitre']) AND !empty($_POST['newtitre'])){
		$newtitre = htmlspecialchars($_POST['newtitre']);
		$newtire = utf8_encode($newtitre);
		$inserttitre = $bdd->prepare("UPDATE bc_lieu SET titre = ? WHERE id_lieu = ?");
		$inserttitre->execute(array($newtitre,$get_id));
	}
?>
<?php
	if(isset($_POST['newdescription']) AND !empty($_POST['newdescription'])){				
		$newdescription = htmlspecialchars($_POST['newdescription']);
		$newdescription = utf8_encode($newdescription);
		$insertdesc = $bdd->prepare("UPDATE bc_lieu SET description = ? WHERE id_lieu = ?");
		$insertdesc->execute(array($newdescription,$get_id));
	}
?>
<?php
	if(isset($_POST['newdate']) AND !empty($_POST['newdate'])){					
		$newdate = htmlspecialchars($_POST['newdate']);
		$insertdate = $bdd->prepare("UPDATE bc_lieu SET dateLieu = ? WHERE id_lieu = ?");
		$insertdate->execute(array($newdate,$get_id));
	}
?>
<?php
	if(isset($_POST['newsport']) AND !empty($_POST['newsport'])){					
		$newsport = htmlspecialchars($_POST['newsport']);
		$newsport = utf8_encode($newsport);
		$insertsport = $bdd->prepare("UPDATE bc_lieu SET sport = ? WHERE id_lieu = ?");
		$insertsport->execute(array($newsport,$get_id));
	}
?>
<?php
	if(isset($_POST['newlieu']) AND !empty($_POST['newlieu'])){					
		$newlieu = htmlspecialchars($_POST['newlieu']);
		$newlieu = utf8_encode($newlieu);
		$insertlieu = $bdd->prepare("UPDATE bc_lieu SET lieu = ? WHERE id_lieu = ?");
		$insertlieu->execute(array($newlieu,$get_id));
	}
?>
<?php
		header("Location: index.php");
	}else if(isset($_POST['refuser'])){
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
    <title>Blue Cow - Confirmation</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body>
		<h1><?= $title ?> </h1>
    <h2>Description : </h2>
    <p><?= $description ?></p>
    <div>Date :  <?= $dateEvent ?></div>
    <div>Sport : <?= $sport ?></div>
    <div>Lieu : <?= $lieu ?></div>
		<form method="post" enctype="multipart/form-data">
			<div>
				<p>
					Modifier le titre :
				</p>
				<label for="titre">Nouveau titre : </label>
				<input id="titre" name="newtitre" placeholder="Nouveau titre" type="text"  />
			</div>
			<div>
				<p>
					Modifier la description :
				</p>
				<label for="description">Nouvelle description : </label>
				<textarea id="description" name="newdescription" rows="2" cols="20" placeholder="Nouvelle description"></textarea>
			</div>
			<div>
				<p>
					Modifier la date :
				</p>
				<label for="date">Nouvelle date : </label>
				<input id="date" name="newdate" placeholder="Nouvelle date" type="date"/>
			</div>
			<div>
				<p>
					Modifier le sport :
				</p>
				<label for="sport">Nouveau sport : </label>
				<input id="sport" name="newsport" placeholder="Nouveau sport" type="text"/>
			</div>
			<div>
				<p>
					Modifier le lieu :
				</p>
				<label for="lieu">Nouveau lieu : </label>
					<input id="lieu" name="newlieu" placeholder="Nouveau lieu" type="text"/>
			</div>
			<div>Êtes-vous certain de vouloir modifier ce lieu ? </div>
				<input class="shareValidate"  type="submit" name="valider" value="Oui"/>
				<input class="shareValidate"  type="submit" name="refuser" value="Non"/>
		</form>
  </body>
</html>