<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
		$idSport = htmlspecialchars($_GET['id']);

?>
<?php

if(isset($_POST['submitTrier'])){
		setcookie("trier",$_POST['trier'],time()+900);
	}
	if(isset($_COOKIE['trier'])){
		if($_COOKIE['trier'] === 'P'){
			$articlelieu = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_sport = ? AND valider = 1' );
			$articlelieu->execute(array($idSport));
		}else if($_COOKIE['trier'] === 'C'){
			$articlelieu = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_sport = ? AND valider = 1 ORDER BY nbConsultation DESC');	
			$articlelieu->execute(array($idSport));
		}else if($_COOKIE['trier'] ==='D'){
			$articlelieu = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_sport = ? AND valider = 1 ORDER BY dateLieu ASC');	
			$articlelieu->execute(array($idSport));
		}
	}

?>
<?php
	
	$articlelieu = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_sport = ? AND valider = 1' );
	$articlelieu->execute(array($idSport));
	
	if(isset($_POST['submitTrier'])){
		if($_POST['trier'] === 'P'){
			$articlelieu = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_sport = ? AND valider = 1' );
			$articlelieu->execute(array($idSport));
		}else if($_POST['trier'] === 'C'){
			$articlelieu = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_sport = ? AND valider = 1 ORDER BY nbConsultation DESC');	
			$articlelieu->execute(array($idSport));
		}else if($_POST['trier'] ==='D'){
			$articlelieu = $bdd->prepare('SELECT * FROM bc_lieu WHERE id_sport = ? AND valider = 1 ORDER BY dateLieu ASC');	
			$articlelieu->execute(array($idSport));
		}
	}
?>	
<?php

if(isset($_POST['submitTrier'])){
		setcookie("trier",$_POST['trier'],time()+900);
	}
	if(isset($_COOKIE['trier'])){
		if($_COOKIE['trier'] ==='P'){
			$articleevent = $bdd->prepare('SELECT * FROM bc_event WHERE id_sport = ? AND  valider = 1' );
			$articleevent->execute(array($idSport));
		}else if($_COOKIE['trier'] ==='C'){
			$articleevent = $bdd->prepare('SELECT * FROM bc_event WHERE id_sport = ? AND  valider = 1 ORDER BY nbConsult DESC' );
			$articleevent->execute(array($idSport));
		}else if($_COOKIE['trier'] ==='D'){
			$articleevent = $bdd->prepare('SELECT * FROM bc_event WHERE id_sport = ? AND  valider = 1 ORDER BY dateEvent' );
			$articleevent->execute(array($idSport));
		}
	}

?>
<?php
	$articleevent = $bdd->prepare('SELECT * FROM bc_event WHERE id_sport = ? AND  valider = 1' );
	$articleevent->execute(array($idSport));
	
	if(isset($_POST['submitTrier'])){
		if($_POST['trier'] ==='P'){
			$articleevent = $bdd->prepare('SELECT * FROM bc_event WHERE id_sport = ? AND  valider = 1' );
			$articleevent->execute(array($idSport));
		}else if($_POST['trier'] ==='C'){
			$articleevent = $bdd->prepare('SELECT * FROM bc_event WHERE id_sport = ? AND  valider = 1 ORDER BY nbConsult DESC' );
			$articleevent->execute(array($idSport));
		}else if($_POST['trier'] ==='D'){
			$articleevent = $bdd->prepare('SELECT * FROM bc_event WHERE id_sport = ? AND  valider = 1 ORDER BY dateEvent' );
			$articleevent->execute(array($idSport));
		}
	}
	
?>
<?php
	if(isset($_POST['valider'])){			
		$get_id = htmlspecialchars($_GET['id']);
		$del = $bdd->prepare('DELETE FROM bc_sport WHERE id_sport = ?');
		$del->execute(array($get_id));
	}
?>
<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="utf-8"/>
    <title>Blue Cow - Evénement et lieu</title>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body>
		<?php
			$titre = 'header';
			include("inc/header.inc.php");
		?>
    <h1>Sport</h1>
		<main>
			<form method="post" enctype="application/x-www-form-urlencoded">
				<?php
					if(isset($_SESSION['id'])){
						if($_SESSION['admin'] == 1){
				?>
				<input class="shareValidate"  type="submit" name="valider" value="Supprimer"/>
				<?php
						}
					}
				?>
				<label for="trier">Trier par : </label>
				<select id="trier" name="trier">
					<option selected  value="P">Pas de tri</option>
					<option value="C">Nombre de consultations</option>
					<option  value="D">Date antéchronologique</option>
				</select>
				<input type="submit" name="submitTrier" value="Trier" />
			</form>
			<?php
				if($articleevent->rowCount()>= 1){
					while($a = $articleevent->fetch()) { 
						$voteA = $bdd->prepare('SELECT AVG(vote) as moyenne FROM bc_vote_event WHERE id_event = ?');
						$voteA->execute(array($a['id_event']));
						$reqVoteA = $voteA->fetch();
			?>
			<section class="evenement">
				<a href="pageEvenement.php?id=<?= $a['id_event'] ?>"><img class="imgPageEve" src="img/<?= $a['img'] ?>.png" alt="image" ></a>
				<ul>
					<li>
						<a href="pageEvenement.php?id=<?= $a['id_event'] ?>"><?= utf8_encode($a['titre']) ?></a>
					</li>
						<li>Sport : <?= utf8_encode($a['sport']) ?></li>
					<li>Date :  <?= utf8_encode($a['dateEvent']) ?></li>
					<li>Nouveau !! </li>
					<li>Lieu : <?= utf8_encode($a['lieu']) ?></li>
					<li>Consultations : <?= utf8_encode($a['nbConsult']) ?></li>
					<li><?= utf8_encode($a['typeSport']) ?> </li>
					<li>Avis : <?= utf8_encode($reqVoteA['moyenne']) ?></li>
				</ul>
			</section>
			<?php 
				}
				}else{
				 $erreur = "Pas d'évenement";
				 echo $erreur;
				}
			?>
			<?php
				if($articlelieu->rowCount() >=1){
					while($b = $articlelieu->fetch()) { 
						$vote = $bdd->prepare('SELECT AVG(vote) as moyenne FROM bc_vote_lieu WHERE id_lieu = ?');
						$vote->execute(array($b['id_lieu']));
						$reqVote = $vote->fetch();
			?> 
			<section class="evenement">
				<a href="pageLieuDetail.php?id=<?= $b['id_lieu'] ?>"><img class="imgPageEve" src="img/<?= $b['img'] ?>.jpg" alt="image" ></a>
				<ul>
					<li>
						<a href="pageLieuDetail.php?id=<?= $b['id_lieu'] ?>"><?= utf8_encode($b['titre']) ?></a>
					</li>
					<li>Sport : <?= utf8_encode($b['sport']) ?></li>
					<li>Date :  <?= utf8_encode($b['dateLieu']) ?></li>
					<li>Nouveau !! </li>
					<li>Lieu : <?= utf8_encode($b['lieu']) ?></li>
					<li>Consultations : <?= utf8_encode($b['nbConsultation']) ?></li>
					<li>Avis : <?= utf8_encode($reqVote['moyenne']) ?></li>
				</ul>
			</section>
      <?php 
					}
				}else{
				 $erreur = "Pas de lieu";
					 echo $erreur;
				}
			?>
    </main>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>  
  </body>
</html>