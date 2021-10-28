<?php
	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');

	if(isset($_POST['buttonSubmit']) AND !empty($_POST['CGU']))
	{
		
		$prenom = htmlspecialchars($_POST['prenom']);
		$nom = htmlspecialchars($_POST['nom']);
		$nomUtilisateur = htmlspecialchars($_POST['nomUtilisateur']);
		$password = sha1(htmlspecialchars($_POST['password']));
		$password2 = sha1(htmlspecialchars($_POST['password2']));
		$mail = htmlspecialchars($_POST['mail']);
		$ddn = htmlspecialchars($_POST['ddn']);
		if(!empty($_POST['info'])){
			$erreur = "Trop d'informations ! Veuillez réessayer";
		}else if(empty($_POST['info']) AND!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['nomUtilisateur']) AND !empty($_POST['password']) AND !empty($_POST['password2']) AND !empty($_POST['mail']) AND !empty($_POST['ddn']))
		{		
			$nomUtilisateurlength = strlen($nomUtilisateur);	
			if($nomUtilisateurlength <= 255)
			{
				$reqpseudo = $bdd->prepare("SELECT * FROM bc_membre WHERE nomUtilisateur = ?");
				$reqpseudo->execute(array($nomUtilisateur));
				$pseudoexist = $reqpseudo->rowCount();
				if($pseudoexist == 0)
				{
					if(filter_var($mail, FILTER_VALIDATE_EMAIL))
					{
						$reqmail = $bdd->prepare("SELECT * FROM bc_membre WHERE mail = ?");
						$reqmail->execute(array($mail));
						$mailexist = $reqmail->rowCount();
						if($mailexist == 0)
						{
							if($password == $password2)
							{
								$insertmembre = $bdd->prepare("INSERT INTO bc_membre(prenom, nom, nomUtilisateur, mail, password, ddn) VALUES (?,?,?,?,?,?)");
								$insertmembre->execute(array($prenom, $nom, $nomUtilisateur, $mail, $password, $ddn));
								$erreur = "Votre compte a bien été crée <a href=\"connexion.php\">Se connecter</a>";
								// header('Location: connexion.php');
							}
							else
							{
								$erreur = "Mots de passes ne correspondent pas";
							}
						}
						else
						{
							$erreur = "Adresse mail existe déjà !";
						}
					}
					else
					{
						$erreur = "Votre adresse mail n'est pas valide !";
					}
				}
				else
				{
					$erreur = "Pseudo existe déjà !";
				}
			}
			else
			{
				$erreur = "Pseudo trop long";
			}
		}
		else
		{
			$erreur = "Tous les champs doivent être complétés !";
		}
	}else{
		$erreur = 'Veuillez accepter les conditions d\'utilisation';
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<title>Blue Cow - Inscription</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
			<?php
				$titre = 'header';
				include("inc/header.inc.php");
			?>
		<h1>Inscription</h1>
		<section class="connexion">
			<form method="post" enctype="application/x-www-form-urlencoded">
				<fieldset class="inscription">
					<legend>
						Données de l'utilisateur :
					</legend>
					<div>
						<label class="info"><span></span><input class="info" type="text" name="info" value=""/></label>
						<label for="prenom">Prénom : </label><input id="prenom" name="prenom" type="text" placeholder="Prénom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" />
						<label for="nom">Nom : </label><input id="nom" name="nom" type="text" placeholder="Nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />
						<label for="nomUtilisateur">Nom d'utilisateur : </label><input id="nomUtilisateur" name="nomUtilisateur" type="text" placeholder="Nom d'utilisateur" value="<?php if(isset($nomUtilisateur)) { echo $nomUtilisateur; } ?>" />
						<label for="password">Mot de passe : </label><input id="password" name="password" type="password" placeholder="Mot de passe" />
						<label for="password2">Confirmez le mot de passe : </label><input id="password2" name="password2" type="password" />
						<label for="mail">Adresse mail : </label><input id="mail" name="mail" type="email"  placeholder="Adresse mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
						<label for="ddn">Date de naissance : </label><input id="ddn" name="ddn" type="date"  value="<?php if(isset($ddn)) { echo $ddn; } ?>" />
					</div>
					<div>
						<label class="radio"><input id="CGU"  name="CGU" type="checkbox" value="CGU">J'ai lu et accepte les Conditions Générales d'Utilisation</label>
					</div>
					<div>
						<label class="radio"><input id="newsletter" name="newsletter" type="checkbox" value="newsletter">Je m'inscris à la Newsletter</label>
					</div>
					<div>
						<input type="submit" name="buttonSubmit" value="S'INSCRIRE"> 
					</div>
				</fieldset>
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