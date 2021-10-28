<?php
session_start();
	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
		$article = $bdd->query('SELECT * FROM bc_membre WHERE admin = 0 OR gestionnaire =0');			
?>
<?php

				if(isset($_POST['gestionnaire'])){
					$id = htmlspecialchars($_POST['ident']);
					$insertgestio = $bdd->prepare("UPDATE bc_membre SET gestionnaire = 1 WHERE id_membre = ?");
					$insertgestio->execute(array($id));
					$statut = "Identifiant ".$id." a été nommé gestionnaire";
					header('Location: pageSetMembre.php');
				}
			?>
			<?php
				if(isset($_POST['admin'])){
					$id = htmlspecialchars($_POST['ident']);
					$insertadmin = $bdd->prepare("UPDATE bc_membre SET admin = 1 WHERE id_membre = ?");
					$insertadmin->execute(array($id));
					$statut = "Identifiant ".$id." a été nommé administrateur";
					header('Location: pageSetMembre.php');
				}
			?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>Blue Cow -Membre</title>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
		<?php
			$titre = 'header';
			include("inc/header.inc.php");
		?>
		<h1>Membre</h1>
		<main>	
			<?php
				while($a = $article->fetch()) { 
			?>
			<section class="search">
				<fieldset>
          <legend>Données du membre :</legend>
						<div>
							<div>
									<div>
										Identifiant : <?= utf8_encode($a['id_membre']) ?>
									</div>
										Nom : <?= utf8_encode($a['nom']) ?> | Prénom : <?= utf8_encode($a['prenom']) ?> | Mail : <?= utf8_encode($a['mail']) ?>
								</div>
						
							</div>
							</fieldset>
						</section>
			<br><br>
      <?php 
			}
			?>
			<div>
				<form method="post">
						<div>
							<label for="ident">Veuillez confirmer l'identifiant</label><input id="ident" name="ident" type="text" placeholder="Identifiant" />
							<input class="shareValidate"  type="submit" name="gestionnaire" value="Nommer gestionnaire"/>
							<input class="shareValidate"  type="submit" name="admin" value="Nommer administrateur"/>
						</div>
				</form>
			</div>
			<?php 
			if(isset($statut)){echo $statut;}
			
			?>
		</main>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>
	</body>
</html>

