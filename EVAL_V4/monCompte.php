<?php
session_start();

	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
?>
<?php
if(isset($_POST['Changer'])){
	if(isset($_FILES['miniature']) AND !empty($_FILES['miniature'])){
		$point = strpos($_FILES['miniature']['name'],'.');
		$nomImage = substr($_FILES['miniature']['name'], 0 , $point);
		$nomImage .= $_SESSION['id'];
		$nomImage = strtolower($nomImage);
		$nomImage = str_replace(' ','',$nomImage);
		$ins = $bdd->prepare('UPDATE bc_membre SET image = ? WHERE id_membre = ?');
		$ins->execute(array($nomImage,$_SESSION['id']));
		$chemin = 'img/'.$nomImage.'.jpg';
		move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
		$message = "Votre photo a éte modifié";
		$_SESSION['image'] = $nomImage;
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<title>Blue Cow - Mon compte</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
			<?php
				$titre = 'header';
				include("inc/header.inc.php");
			?>
		
		<h1>Mon Compte</h1>
		<div class="cont">
		<div>
			<section class="propose">
				<a class="nouveau" href="deconnexion.php">Se déconnecter</a>
				<?php
					if($_SESSION['admin'] == 1 AND $_SESSION['gestionnaire'] == 1){
				?>
				<a class="nouveau" href="validerPhoto.php?id=1&id=2">Validation des photos</a>
				<?php
					}
				?>
				<?php
					if($_SESSION['gestionnaire'] == 1){
				?>
				<a class="nouveau" href="ajoutEvenement.php">Ajouter un événement</a>
				<?php
					}
				?>
				<?php
					if($_SESSION['admin'] == 1){
				?>
				<a class="nouveau" href="ajoutLieu.php">Ajouter un lieu</a>
				<a class="nouveau" href="ajoutSport.php">Ajouter un sport</a>
				<a class="nouveau" href="pageSetMembre.php">Nommer de nouveau gestionnaire et/ou administrateur</a>
				<?php
					}
				?>
			</section>
		</div>
		<section class="left">
			<fieldset class="notif">
				<legend>
					Notifications
				</legend>
				<label for="courriel">Recevoir les notifications par : </label>
				<label class="radio"><input id="courriel"  name="courriel" type="checkbox" value="courriel">courriel</label>
				<label class="radio"><input id="site" name="site" type="checkbox" value="site">le site web</label>
			</fieldset>
		</section>
		<section class="right">
			<fieldset class="notif">
				<legend>
					Mon Profil
				</legend>
				<div>
					Nom : <?php echo $_SESSION['nom']; ?>
				</div>
				<div>
					Prénom : <?php echo $_SESSION['prenom']; ?>
				</div>
				<div>
					Adresse mail : <?php echo $_SESSION['mail']; ?>
				</div>
				<div>
					Nom d'utilisateur : <?php echo $_SESSION['nomUtilisateur']; ?>
				</div>
				<div>
					<img src="img/<?=$_SESSION['image']?>.jpg" alt="photoDeProfil" width="40">
				</div>
				<?php
					if($_SESSION['id'] ==  $_SESSION['id'])
					{
				?>
				<?php		
					if(isset($_SESSION['id']))
					{
						$userreq = $bdd->prepare('SELECT * FROM bc_membre WHERE id_membre = ?');
						$userreq->execute(array($_SESSION['id']));
						$user = $userreq->fetch();
						if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND (($_POST['newnom']) != $user['nom'] ))
						{
							$newnom = htmlspecialchars($_POST['newnom']);
							$insertnom = $bdd->prepare("UPDATE bc_membre SET nom = ? WHERE id_membre = ?");
							$insertnom->execute(array($newnom,$_SESSION['id']));
							header('Location: monCompte.php');
						}
						if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND (($_POST['newprenom']) != $user['prenom'] ))
						{
							$newprenom = htmlspecialchars($_POST['newprenom']);
							$insertprenom = $bdd->prepare("UPDATE bc_membre SET prenom = ? WHERE id_membre = ?");
							$insertprenom->execute(array($newprenom,$_SESSION['id']));
							header('Location: monCompte.php');
						}
						if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND (($_POST['newmail']) != $user['mail']) )
						{
							$newmail = $_POST['newmail'];
							if(filter_var($newmail, FILTER_VALIDATE_EMAIL))
							{
								$reqmail = $bdd->prepare("SELECT * FROM bc_membre WHERE mail = ?");
								$reqmail->execute(array($newmail));
								$mailexist = $reqmail->rowCount();
								if($mailexist == 0)
								{
									$newmail = htmlspecialchars($_POST['newmail']);
									$insertmail = $bdd->prepare("UPDATE bc_membre SET mail = ? WHERE id_membre = ?");
									$insertmail->execute(array($newmail,$_SESSION['id']));
									header('Location: monCompte.php');
								}else{
									$message = "Adresse mail existe déjà !";
								}
							}
						}
						if(isset($_POST['newpassword2']) AND !empty($_POST['newpassword2']) AND ((isset($_POST['newpassword3']) AND !empty($_POST['newpassword3'] ))))
						{
							$password2 = sha1($_POST['newpassword2']);
							$password3 = sha1($_POST['newpassword3']);
							if($password2 == $password3)
							{
								$insertmdp = $bdd->prepare("UPDATE bc_membrebc_membre SET password = ? WHERE id_membre = ?");
								$insertmdp->execute(array($password2,$_SESSION['id']));
								header('Location: monCompte.php');
							}
							else
							{
								$message = "Mots de passe ne correspondent pas !";
							}
						}
						
					}
				?>
				<form method="post" enctype="multipart/form-data">
					<label for="avatar">Insérer une photo de profil: </label>
					<input id="avatar" type="file" name="miniature" accept="image/*, .jpg">
					<input type="submit" name="Changer"/>
					<div>
						<p>
							Modifier votre nom :
						</p>
						<label for="nom">Nouveau nom : </label>
						<input id="nom" name="newnom" placeholder="Nouveau nom" type="text"  />
					</div>
					<div>
						<p>
							Modifier votre prénom :
						</p>
						<label for="prenom">Nouveau prenom : </label>
						<input id="prenom" name="newprenom" placeholder="Nouveau prénom" type="text"/>
					</div>
					<div>
						<p>
							Modifier votre adresse mail :
						</p>
						<label for="nom">Nouvelle adresse mail : </label>
						<input id="mail" name="newmail" placeholder="Nouvelle adresse mail" type="email"/>
					</div>
					<div>
						<p>
							Modifier le mot de passe :
						</p>
					</div>
					<div>
						<label for="password2">Nouveau mot de passe : </label>
						<input id="password2" name="newpassword2"  placeholder="Nouveau Mot De Passe" type="password"/>
					</div>
					<div>
						<label for="password3">Nouveau mot de passe : </label>
						<input id="password3" name="newpassword3"  placeholder="Nouveau Mot De Passe" type="password"/>
					</div>
					<input type="submit" name="Valider"/>
				</form>
				<?php
					if(isset($message)){ echo $message;}
				?>
				<?php
					}
				?>
			</fieldset>
		</section>
		</div>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>
	</body>
</html>

