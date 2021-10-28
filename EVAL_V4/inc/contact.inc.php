<?php
	if(!empty($_POST['info'])){
		$msg = "Trop d'informations ! Veuillez réessayer";
	}
	
	if(isset($_POST['buttonSubmit'])) {
		if(!empty($_POST['info'])){
			$msg = "Trop d'informations ! Veuillez réessayer";
			
		}else if(empty($_POST['info']) AND !empty($_POST['nom']) AND !empty($_POST['mail']) AND  !empty($_POST['message'])) {
			$header = 'From: '.htmlspecialchars($_POST['nom']).'' . "\r\n"  .'cc:'.htmlspecialchars($_POST['mail']) . "\r\n" . 'X-Mailer: PHP/' . phpversion();
			$message=''.nl2br(htmlspecialchars($_POST['message'])).'';
			mail("yunuss.gvn@gmail.com","CONTACT-SITEWEB" , $message, $header);
			$msg="Votre message a bien été envoyé !";
		 } else {
			$msg="Tous les champs doivent être complétés !";
		 }
	}
?>
<section class="left">
	<h2>Contacter BlueCow</h2>
	<p>
		BlueCow est une société qui produit des boissons révolutionnaires à base d'oxyde de bi-hydrogène. Nous sommes l'une des plus grandes entreprises qui sponsorise régulièrement des évènements liés aux sports extrêmes. <br><br>Notre page Facebook : BlueCow <br> <br>Notre compte Twitter : BlueCow
	</p>
	<h2>Coordonnées : </h2>
	<fieldset class="coordonne">
		<p>
			Adresse : Rue des Pottier n°135a, 1000 Bruxelles <br><br> Numéro de téléphone : 034515785 <br><br> Adresse mail : bluecowenergie@bluecow.be 
		</p>
	</fieldset>
</section>
<section class="right">
	<form method="post" enctype="application/x-www-form-urlencoded">
		<fieldset class="coordonne">
			<h3>Contactez-nous ! </h3>
				<div>
					<label class="info"><span></span><input class="info" type="text" name="info" value=""/></label>
					<label for="nom">Nom :</label><input id="nom" name="nom" type="text"  placeholder="Votre nom"/>
				</div>
				<div>
					<label for="mail">Adresse mail :</label><input id="mail" name="mail" type="email"  placeholder="Adresse mail"/>
				</div>
				<div>
					<label for="message">Message</label><textarea id="message" name="message" rows="3" cols="20"  placeholder="Votre message"></textarea>
				</div>
				<input type="submit" name="buttonSubmit" value="Envoyer"/>
		</fieldset>
	</form>
	<?php if(isset($msg)){echo $msg;}?>
</section>