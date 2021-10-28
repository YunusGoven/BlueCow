<?php
session_start();
	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');

	$article = $bdd->query('SELECT * FROM bc_lieu WHERE valider = 1 ');			
	
	if(isset($_POST['submitTrier'])){
		setcookie("trier",$_POST['trier'],time()+900);
	}
	if(isset($_COOKIE['trier'])){
		if($_COOKIE['trier']==='P'){
			$article = $bdd->query('SELECT * FROM bc_lieu WHERE valider = 1');	
		}else if($_COOKIE['trier']==='C'){
			$article = $bdd->query('SELECT * FROM bc_lieu WHERE valider = 1 ORDER BY nbConsultation DESC');	
		}else if($_COOKIE['trier']==='D'){
			$article = $bdd->query('SELECT * FROM bc_lieu WHERE valider = 1 ORDER BY dateLieu ASC');
		}
	}
	
	if(isset($_POST['submitTrier'])){
		if($_POST['trier'] === 'P'){
			$article = $bdd->query('SELECT * FROM bc_lieu WHERE valider = 1');	
		}else if($_POST['trier'] === 'C'){
			$article = $bdd->query('SELECT * FROM bc_lieu WHERE valider = 1 ORDER BY nbConsultation DESC');	
		}else if($_POST['trier'] === 'D'){
			$article = $bdd->query('SELECT * FROM bc_lieu WHERE valider = 1 ORDER BY dateLieu ASC');
		}
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<title>Blue Cow - Evénement et lieu</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
		<?php
			$titre = 'header';
			include("inc/header.inc.php");
		?>
		<h1>Lieu</h1>
		<main>
			<div>
				<section class="propose">
					<?php
						if(isset($_SESSION['id'])){
					?>
					<div>
						<a class="nouveau" href="pageProposerLieu.php">Proposer un nouveau lieu</a>
					</div>
					<?php
						}
						if(isset($_SESSION['id'])){
							if( $_SESSION['admin'] == 1){
					?>
					<div>
						<a class="nouveau" href="ajoutLieu.php">Ajouter un lieu</a>
					</div>
					<div>
						<a class="nouveau" href="validerPhoto.php?id=<?php echo 2?>">Validation des photos</a>
					</div>
					<?php 
							}
						}
					?>
				</section>
			</div>
			<form method="post" enctype="application/x-www-form-urlencoded">
				<label for="trier">Trier par : </label>
				<select id="trier" name="trier">
					<option   value="P">Pas de tri</option>
					<option value="C">Nombre de consultations</option>
					<option  value="D">Date antéchronologique</option>
				</select>
				<input type="submit" name="submitTrier" value="Trier" />
			</form>
		 <?php
			 while($a = $article->fetch()) { 
					$vote = $bdd->prepare('SELECT AVG(vote) as moyenne FROM bc_vote_lieu WHERE id_lieu = ?');
					$vote->execute(array($a['id_lieu']));
					$reqVote = $vote->fetch();
		 ?>
			<section class="evenement">
				<a href="pageLieuDetail.php?id=<?= $a['id_lieu'] ?>"><img class="imgPageEve" src="img/<?= $a['img'] ?>.jpg" alt="image" ></a>
				<ul>
					<li>
						<a href="pageLieuDetail.php?id=<?= $a['id_lieu'] ?>"><?= utf8_encode($a['titre']) ?></a>
					</li>
					<li>Sport : <?= utf8_encode($a['sport']) ?></li>
					<li>Date :  <?= utf8_encode($a['dateLieu']) ?></li>
					<li>Nouveau !! </li>
					<li>Lieu : <?= utf8_encode($a['lieu']) ?></li>
					<li>Consultations : <?= utf8_encode($a['nbConsultation']) ?></li>
					<li>Avis : <?= utf8_encode($reqVote['moyenne']) ?></li>
				</ul>
			</section>
      <?php 
				}
			?>
		</main>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>
	</body>
</html>