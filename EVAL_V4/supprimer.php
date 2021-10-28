<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118;charset=utf8', 'in18b1118', '9601');		
	if(isset($_GET['id_lieu']) AND !empty($_GET['id_lieu'])) {
		$get_id = htmlspecialchars($_GET['id_lieu']);
		$article = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_lieu = ?');
		$article->execute(array($get_id));
		$article = $article->fetch();
		if(isset($_POST['valider'])){
			$del = $bdd->prepare('DELETE FROM bc_lieu WHERE id_lieu = ?');
			$del->execute(array($get_id));
			header("Location: http://192.168.128.13/~e180810/EVAL_V4/index.php");
		}else if(isset($_POST['refuser'])){
			header("Location: http://192.168.128.13/~e180810/EVAL_V4/index.php");
		}
	}	
	if(isset($_GET['id_event']) AND !empty($_GET['id_event'])) {
		$get_id = htmlspecialchars($_GET['id_event']);
		$article = $bdd->prepare('SELECT * FROM bc_event WHERE id_event = ?');
		$article->execute(array($get_id));
		$article = $article->fetch();
		if(isset($_POST['valider'])){
			$del = $bdd->prepare('DELETE FROM bc_event WHERE id_event = ?');
			$del->execute(array($get_id));
			header("Location: http://192.168.128.13/~e180810/EVAL_V4/index.php");
		}else if(isset($_POST['refuser'])){
			header("Location: http://192.168.128.13/~e180810/EVAL_V4/index.php");
		}
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
		<h1>Êtes-vous certain de vouloir supprimer ce lieu ? </h1>
		<form method="post">
			<input class="shareValidate"  type="submit" name="valider" value="Oui"/>
			<input class="shareValidate"  type="submit" name="refuser" value="Non"/>
		</form>
  </body>
</html>