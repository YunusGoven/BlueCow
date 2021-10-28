<?php
session_start();
	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
	
	$articlederniers = $bdd->query('SELECT * FROM bc_event WHERE valider = 1 AND dateEvent >= 2019-01-01 LIMIT 0,3');		
	
	$articleliege = $bdd->query('SELECT * FROM bc_event WHERE valider = 1 AND id_event = 1'	);	
	
	$articlepopulaire = $bdd->query('SELECT * FROM bc_event WHERE valider = 1 ORDER BY nbConsult DESC LIMIT 0,2');			
?>
<?php
if(isset($_COOKIE['accepter'])) {
   $afficherCookie = false;
} else {
   $afficherCookie = true;
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<title>Blue Cow - Accueil</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
		<?php
			$titre = 'header';
			include("inc/header.inc.php");
		?>
		<h1>Acceuil</h1>
		<main>
			<?php 
				if(isset($_SESSION['id'])){
			?>
				<h2 class="acceuilmessage">Bienvenue <?php  echo ucfirst($_SESSION['prenom']);    ?> ! N'hésite pas à partager notre site</h2>
			<?php
				}			
			?>
			<?php
				if(empty($_SESSION['id'])){
			?>
			<section class="bienvenue">
				<h2> Bienvenue sur le site officiel de BlueCow</h2>
				<h2> Afin de pouvoir consulter l'intégralité de notre site </h2>
				<h2> Vous devriez vous connecter ou si ce n'est pas le cas vous inscrire </h2>
				<h2> Et bénéficier de plusieurs avantages tels que : voir les commentaires, voir la fiche complète d'un évènement.</h2>
			</section>
			<section class="identification">
				<h2> Pour se connecter : </h2>
				<a href="connexion.php">Cliquez ici</a>
				<h2> Pour s'inscire : </h2>
				<a href="pageInscription.php">Cliquez ici</a>
			</section>
			<?php
				}
			?>
			<section>
				<h3>Derniers événements</h3>
				<?php
					while($a = $articlederniers->fetch()) {
						$voteA = $bdd->prepare('SELECT AVG(vote) as moyenne FROM bc_vote_event WHERE id_event = ?');
						$voteA->execute(array($a['id_event']));
						$reqVoteA = $voteA->fetch();						
				?>
				<section class="evenement">
					<a href="pageEvenement.php?id=<?= $a['id_event'] ?>"><img class="imgPageEve" src="img/<?= $a['img'] ?>.jpg" alt="image" ></a>
					<ul>
						<li>
							<a href="pageEvenement.php?id=<?= $a['id_event'] ?>"><?= utf8_encode($a[	'titre']) ?></a>
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
				?>
			</section>
			<section>
			<h3> Evénement à Liège </h3>
			<?php
					while($b = $articleliege->fetch()) { 
						$voteB = $bdd->prepare('SELECT AVG(vote) as moyenne FROM bc_vote_event WHERE id_event = ?');
						$voteB->execute(array($b['id_event']));
						$reqVoteB = $voteB->fetch();
				?>
				<section class="evenement">
					<a href="pageEvenement.php?id=<?= $b['id_event'] ?>"><img class="imgPageEve" src="img/<?= $b['img'] ?>.jpg" alt="image" ></a>
					<ul>
						<li>
							<a href="pageEvenement.php?id=<?= $b['id_event'] ?>"><?= utf8_encode($b['titre']) ?></a>
						</li>
						<li>Sport : <?= utf8_encode($b['sport']) ?></li>
						<li>Date :  <?= utf8_encode($b['dateEvent']) ?></li>
						<li>Nouveau !! </li>
						<li>Lieu : <?= utf8_encode($b['lieu']) ?></li>
						<li>Consultations : <?= utf8_encode($b['nbConsult']) ?></li>
						<li><?= utf8_encode($b['typeSport']) ?> </li>
						<li>Avis : <?= utf8_encode($reqVoteB['moyenne']) ?></li>
					</ul>
				</section>
				<?php 
				}
				?>
			</section>
			
			<section>
				<h3>Les plus populaires : </h3>
				<?php
						while($c = $articlepopulaire->fetch()) { 
							$voteC = $bdd->prepare('SELECT AVG(vote) as moyenne FROM bc_vote_event WHERE id_event = ?');
							$voteC->execute(array($c['id_event']));
							$reqVoteC = $voteC->fetch();
				?>
				<section class="evenement">
					<a href="pageEvenement.php?id=<?= $c['id_event'] ?>"><img class="imgPageEve" src="img/<?= $c['img'] ?>.jpg" alt="image" ></a>
					<ul>
						<li>
							<a href="pageEvenement.php?id=<?= $c['id_event'] ?>"><?= utf8_encode($c['titre']) ?></a>
						</li>
						<li>Sport : <?= utf8_encode($c['sport']) ?></li>
						<li>Date :  <?= utf8_encode($c['dateEvent']) ?></li>
						<li>Nouveau !! </li>
						<li>Lieu : <?= utf8_encode($c['lieu']) ?></li>
						<li>Consultations : <?= utf8_encode($c['nbConsult']) ?></li>
						<li><?= utf8_encode($c['typeSport']) ?> </li>
						<li>Avis : <?= utf8_encode($reqVoteC['moyenne']) ?></li>
					</ul>
				</section>
				
				<?php 
						}
					
				?>
			</section>
		</main>
		<?php if($afficherCookie) { ?>
		<div class="cookie-alert">
			En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de cookies.<br /><a href="cookieAccept.php">OK</a>
		</div>
		<?php } ?>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>
	</body>
</html>

