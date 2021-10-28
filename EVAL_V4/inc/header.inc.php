<nav class="navi">
	<ul>
		<li><img src="img/logoBlueCow.png" alt="vache" width="100" >BlueCow &copy;</li>
		<li><a href=" index.php">Accueil</a></li>
		<li><a href="pageEvenementLieu.php">Evénement</a></li>	
		<li><a href="pageLieu.php">Lieu</a></li>
		<li><a href="pageSport.php">Sport</a></li>
		<li><a href="pageRecherche.php">Recherche</a></li>
		<li><a href="pageContact.php">Contact</a></li>
		<?php
			if(isset($_SESSION['id'])){
		?>
		<li><a href="formulaireSuivi.php">Suivi</a><li>
		<li><a href="monCompte.php"><?= $_SESSION['nomUtilisateur'] ?></a></li>
		<?php
			}else{
		?>
		<li><a href="pageInscription.php">S'inscrire</a></li>
		<li><a href="connexion.php">Connexion</a></li>
		<?php
			}
		?>
	</ul>
</nav>