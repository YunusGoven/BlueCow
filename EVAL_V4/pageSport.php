<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
	
		$article = $bdd->query('SELECT * FROM bc_sport WHERE valide = 1');				
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
			<div>
				<section class="propose">
					<?php
						if(isset($_SESSION['id'])){
							if($_SESSION['admin'] == 1){
					?>
					<div>
						<a class="nouveau" href="ajoutSport.php">Ajouter un sport</a>
					</div>
					<?php
							}
						}
					?>
				</section>
			</div>
			<?php
				while($a = $article->fetch()) { 
					$vote = $bdd->prepare('SELECT AVG(v.vote) as moyenne FROM bc_vote_event v INNER JOIN bc_event e ON v.id_event = e.id_event WHERE e.id_sport = ?');
					$vote->execute(array($a['id_sport']));
					$reqVote = $vote->fetch();
					
			?>
			<section class="evenement">
				<a href="pageDetailSport.php?id=<?= $a['id_sport'] ?>"><img class="imgPageEve" src="img/<?= $a['image'] ?>.jpg" alt="image" ></a>
				<a href="pageDetailSport.php?id=<?= $a['id_sport'] ?>"><?= utf8_encode($a['titre']) ?></a>
				<div>Note moyenne : <?= $reqVote['moyenne'] ?></div>
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

