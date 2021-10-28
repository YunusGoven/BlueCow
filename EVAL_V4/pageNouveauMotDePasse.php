<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
    <title>Blue Cow - Connexion</title>
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
					<legend>Mot de passe oublié</legend>
					<span>Un mail contenant votre nouveau mot de passe vous sera envoyé dans votre boîte mail.</span>
					<div>
						<label for="nomUtilisateur">Nom d'utilisateur : </label><input id="nomUtilisateur" name="nomUtilisateur" type="text" required placeholder="Nom d'utilisateur"> 
					</div>
					<div>
						<label for="mail">Adresse mail : </label><input id="mail" name="mail" type="email" required placeholder="xyz@mail.com">
					</div>
					<input type="submit" name="buttonSubmit" value="Envoyer"> 
				</fieldset>
				<span>Vous n'avez pas encore de compte ?     <a href="pageInscription.php">CLIQUER ICI</a></span>
			</form>
		</section>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>  
  </body>
</html>