<h1>Recherche</h1>
<section class="search">
  <form method="post" enctype="application/x-www-form-urlencoded">
    <img src="img/loupe.png" alt="loupeRecherche" width="80">
		<div>
			<label for="recherche"></label><input id="recherche" name="recherche" type="text" required placeholder="Recherche (mot-clés)">
		</div>
		<div>
			<label for="periode">Période de l'événement : </label><input id="periode" name="periode" type="text">
		</div>
		<div>
			<label for="situation">Situation de l'événement : </label><input id="situation" name="situation" type="text">
    </div>
		<div>
			<label for="sport">Sport : </label><input id="sport" name="sport" type="text">
    </div>
		<p>Evénement organisé :
		<div>
			<label class="radio"><input id="equipe"  name="organisation" type="checkbox" value="organisation">par équipe</label>
		</div>
		<div>
			<label class="radio"><input id="individuellemnt"  name="organisation" type="checkbox" value="organisation">individuellement</label><p>
		</div>
		<div>
			<label for="vote">Vote (compris entre 0 et 5): </label><input id="vote" name="vote" type="number">
		</div>
		<div>
			<label for="nbComment">Nombre de commentaires : </label><input id="nbComment" name="nbComment" type="number">
		</div>
		<div>
			<label for="nbConsult">Nombre de consultations : </label><input id="nbConsult" name="nbConsult" type="number">
    </div>
		<div>
			<input type="submit" name="buttonSubmit" value="RECHERCHER">
		</div>
  </form>
</section>       