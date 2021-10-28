<?php
session_start();
	$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
		
	if(isset($_GET['id']) AND !empty($_GET['id'])) {
		$get_id = htmlspecialchars($_GET['id']);
		$article = $bdd->prepare('SELECT * FROM bc_event WHERE id_event = ?');
		$article->execute(array($get_id));
		if($article->rowCount() == 1) {
			$article = $article->fetch();
			$title = utf8_encode($article['titre']);
			$nbConsult = utf8_encode($article['nbConsult']);	
			$img = utf8_encode($article['img']);
			$description = utf8_encode($article['description']);
			$dateEvent = utf8_encode($article['dateEvent']);
			$sport = utf8_encode($article['sport']);
			$lieu = utf8_encode($article['lieu']);
			$typeSport = utf8_encode($article['typeSport']);
		} else {
			header('Location: pageEvenementLieu.php');
		}
	} else {
		header('Location: pageEvenementLieu.php');
	}
?>
<?php
$reqVote = $bdd->prepare("SELECT AVG(vote) as somme FROM bc_vote_event WHERE id_event = ?");
$reqVote->execute(array($get_id));
if($reqVote->rowCount() == 1){
	$reqVote = $reqVote->fetch();
	$vote = utf8_encode($reqVote['somme']);	
}else{
	$vote = 0;
}
?>
<?php
	
	if(isset($_POST['commenter'])) {
		if(isset($_POST['comment']) AND !empty($_POST['comment'])) {
			$commentaire = htmlspecialchars($_POST['comment']);
			$ins = $bdd->prepare('INSERT INTO bc_commentaire (pseudo, commentaire, id_article, dateCommentaire) VALUES (?,?,?, NOW())');
			$ins->execute(array($_SESSION['nomUtilisateur'],$commentaire,$get_id));
		}
	}
?>
<?php
	$commentaires = $bdd->prepare('SELECT * FROM bc_commentaire WHERE id_article = ? ORDER BY dateCommentaire DESC');
  $commentaires->execute(array($get_id));
	$photo = $bdd->prepare('SELECT * FROM bc_image_propose WHERE id_article = ? AND valider = 1');
  $photo->execute(array($get_id));
?>
<?php

//if(isset($_SESSION['id'])){  
  //if((time() - $_SESSION['last_login_timestamp']) > 900){
		$updateView=$bdd->prepare("UPDATE bc_event SET nbConsult = nbConsult + 1 WHERE id_event = ?");
		$updateView->execute(array($get_id));
//	}
//}

?>
<?php
	if(isset($_POST['partage'])) {
		if(!empty($_POST['recevoir'])) {
			$to = htmlspecialchars($_POST['recevoir']);
			$subject = "Ceci pourrait t'interesser";
			if(isset($_SESSION['id'])){
				$header = 'From: ' . $_SESSION['mail']."\r\n";
			}else{
				$header = 'From: ' . htmlspecialchars($_POST['envoyer'])."\r\n";
			}
      $header .= 'Mime-Version: 1.0'."\r\n";
			$header .= 'Content-type: text/html; charset=utf-8'."\r\n";
			$header .= "\r\n";
      $message=''. 'http://192.168.128.13/~e180810/EVAL_V4/pageEvenement.php?id='. $get_id . ' <br> ' . $title . ' <br> ' . $description . ' <br> ' . $lieu . ' <br>  ' .'<img id="imageEve" src="img/'. $img .'.jpg" alt="representation de l\'événement" >'.'';
      mail($to, $subject, $message, $header);
      $msg="Votre message a bien été envoyé !";
		} else {
      $msg="Tous les champs doivent être complétés !";
		}
	}
?>
<?php
	if(isset($_POST['photoSend'])){
		if(isset($_FILES['miniature'])){
			$point = strpos($_FILES['miniature']['name'],'.');
			$nomImage = substr($_FILES['miniature']['name'], 0 , $point);
			$nomImage = strtolower($nomImage).'ev'.$get_id;
			$nomImage = str_replace(' ','',$nomImage);
			$insertImage = $bdd->prepare('INSERT INTO bc_image_propose(image,id_article,valider) VALUES (?,?,0)');
			$insertImage->execute(array($nomImage,$get_id));
			$chemin = 'img/'.$nomImage.'.jpg';
			move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);	
			$message = "La photo a été soumise";
		}else{
			$message = "Erreur lors de la soumision";
		}
	}
?>
<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta charset="utf-8"/>		
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
    <title>Blue Cow - Consultation</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  </head>

  <body>
		<?php
			$titre = 'header';
			include("inc/header.inc.php");
		?>
    <h1>Evénement</h1>
    <section class="consult">
			<button class="follow" name="button">Suivre</button>
			<?php
				if(isset($_SESSION['id'])){
					if($_SESSION['gestionnaire'] == 1 ){		
			?>
			<a href="supprimer.php?id_event=<?=$get_id ?>" onclick="window.open(this.href, 'nom de ta fenêtre', 'height=400, width=400, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);">Supprimer</a>
			<a href="modifier.php?id_event=<?=$get_id ?>" onclick="window.open(this.href, 'nom de ta fenêtre', 'height=400, width=400, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no'); return(false);">Modifier</a>
			<?php 
					}
				}
			?>
      <h2><?= $title ?> </h2>
      <img id="imageEve" src="img/<?= $img ?>.jpg" alt="representation de l'événement" >
      <h4>Description : </h4>
      <p><?= $description ?></p>
      <span>Date :  <?= $dateEvent ?></span>
      <span>Sport : <?= $sport ?></span>
      <span>Lieu : <?= $lieu ?></span>
			<span><?= $typeSport ?></span>
    </section>
    <section class="consult">
      <fieldset>
        <legend>Avis</legend>
				<?php 
					if(isset($_SESSION['id'])){
				?>
				<div class="vote">
          <a href="vote.php?v=1&id=<?= $get_id ?>">☆</a>
          <a href="vote.php?v=2&id=<?= $get_id ?>">☆</a>
          <a href="vote.php?v=3&id=<?= $get_id ?>">☆</a>
          <a href="vote.php?v=4&id=<?= $get_id ?>">☆</a>
          <a href="vote.php?v=5&id=<?= $get_id ?>">☆</a>
        </div>
				<?php
					}
				?>
        <p>Avis : <?= $vote ?> /5<p>
        <h3>Images proposées par d'autres utilisateurs</h3>
				<?php 
					if(isset($_SESSION['id'])){
				?>
				<div>
					<form method="post" enctype="multipart/form-data">
						<label for="images">Soumettre une image : </label><input type="file" name="miniature" id="images" />
						<input type="submit" name="photoSend"/>
					</form>
					<?php if(isset($message)) echo $message ?>
				</div>
				<?php
					}
				?>
				<?php 
					while($p = $photo->fetch()) { 
				?>
				<img class="sousImage" src="img/<?= $p['image']?>.png" alt="image">
				<img class="sousImage" src="img/<?= $p['image']?>.jpg" alt="image">
				<?php 
					}
				?>
        <h3>Commentaires</h3>
        <?php 
					if(isset($_SESSION['id'])){
				?>
				<div>
					<form method="post" enctype="application/x-www-form-urlencoded">
						<label for="comment"></label><input id="comment" name="comment" type="text" placeholder="Ecrivez votre commentaire ici"><input type="submit" name="commenter" value="Envoyer commentaire">
					</form>
				</div>
				<?php
					}else{
				?>
				<div>
					<form method="post" enctype="application/x-www-form-urlencoded">
						<label for="comment"><img src="img/caree.jpg" alt="avatar" width="35"></label><input id="comment" name="comment" type="text" disabled  value="Authentifiez-vous pour laisser un commentaire">
					</form>
				</div>
				<?php
					}
				?>
				
				<?php 
					while($c = $commentaires->fetch()) { 
				?>
				<div>
					<b><?= utf8_encode($c['pseudo']) ?>:</b><br /> <?= utf8_encode($c['commentaire']) ?> <br /> <?= utf8_encode($c['dateCommentaire']) ?>
					
					<?php
						if(isset($_SESSION['id'])){
							if($_SESSION['gestionnaire'] == 1){
					?>
					
					<form method="post" enctype="application/x-www-form-urlencoded">
						<label></label><input type="submit" name="supp" value="Supprimer">
					</form>
					
					<?php
							}
						}
					?>
					
				</div>
				<?php 
					}
				?>
				
      </fieldset>
    </section>
		
    <section class="partage">
			<?php 
				if(isset($_SESSION['id'])){
			?>
		
			<form method="post" enctype="application/x-www-form-urlencoded">
				<div>Partager par mail :</div><input id="envoyer" name="envoyer" type="email" disabled value="<?=$_SESSION['mail'] ?>"/><br><input id="recevoir" name="recevoir" type="email"  placeholder="Email du receveur"/> <input class="shareValidate"  type="submit" name="partage" value="Partager"/>
			</form>
			<?php 
				}else{
			?>
				<form method="post" enctype="application/x-www-form-urlencoded">
				<div>Partager par mail :</div><input id="envoyer" name="envoyer" type="email" placeholder="Votre email"/><br><input id="recevoir" name="recevoir" type="email"  placeholder="Email du receveur"/> <input class="shareValidate"  type="submit" name="partage" value="Partager"/>
			</form>
			<?php
				}
			?>
			<?php if(isset($msg)){echo $msg;}?>
      <label for="consult">Nombre de consultation :</label><input id="consult" name="consult" type="text" disabled value="<?= $nbConsult ?>"/>
    </section>
		<?php
			$titre = 'footer';
			include("inc/footer.inc.php");
		?>  
  </body>
</html>