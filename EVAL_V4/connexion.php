<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
		
	if(isset($_POST['buttonSubmit'])) {
		$mailconnect = htmlspecialchars($_POST['nomUtilisateur']);
		$mdpconnect = htmlspecialchars(sha1($_POST['password']));
		if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM bc_membre WHERE nomUtilisateur = ? AND password = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
        $userinfo = $requser->fetch();
        $_SESSION['id'] = $userinfo['id_membre'];
        $_SESSION['nomUtilisateur'] = $userinfo['nomUtilisateur'];
				$_SESSION['prenom'] = $userinfo['prenom'];
        $_SESSION['admin'] = $userinfo['admin'];
				$_SESSION['gestionnaire'] = $userinfo['gestionnaire'];
				$_SESSION['nom'] = $userinfo['nom'];
				$_SESSION['image'] = $userinfo['image'];
				$_SESSION['mail'] = $userinfo['mail'];
				$_SESSION['last_login_timestamp'] = time();  
        header("Location: index.php");
      } else {
        $erreur = "Mauvais nom d'utilisateur ou mot de passe !";
      }
		} else {
      $erreur = "Tous les champs doivent être complétés !";
		}
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>Blue Cow - Connexion</title>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
			<?php
				$titre = 'header';
				include("inc/header.inc.php");
			?>
		<h1>Connexion</h1>
		<section class="connexion">
			<form method="post" enctype="application/x-www-form-urlencoded">
				<fieldset>
					<div>
						<label for="nomUtilisateur">Nom d'utilisateur : </label><input id="nomUtilisateur" name="nomUtilisateur" type="text"  placeholder="Nom d'utilisateur">
					</div>
					<div>
						<label for="password">Mot de passe : </label><input id="password" name="password" type="password" placeholder="Mot de passe">
					</div>
					<div>
							Mot de passe oublié ?
							<a href="pageNouveauMotDePasse.php">CLIQUER ICI</a>
					</div>
					<div>
						<input type="submit" name="buttonSubmit" value="SE CONNECTER">
					</div>
				</fieldset>
				<div>
					Vous n'avez pas encore de compte ?
					<a href="pageInscription.php">CLIQUER ICI</a>
				</div>
			</form>
			<?php
				if(isset($erreur))
					echo $erreur;
			?>
		</section>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>
	</body>
</html>

