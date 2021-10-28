<?php
session_start();
$bdd = new PDO('mysql:host=192.168.128.13;dbname=in18b1118', 'in18b1118', '9601');
if(isset($_GET['v'],$_GET['id'],$_SESSION['id']) AND !empty($_SESSION['id']) AND !empty($_GET['v']) AND !empty($_GET['id'])) {
   $getid = (int) htmlspecialchars($_GET['id']);
   $getVoteValue = (int) htmlspecialchars($_GET['v']);
   $sessionid = (int) htmlspecialchars(($_SESSION['id']);
   $check = $bdd->prepare('SELECT id_lieu FROM bc_lieu WHERE id_lieu = ?');
   $check->execute(array($getid));
   if($check->rowCount() == 1) {
    switch($getVoteValue){
			case 1:
				 addOrRemoveVote($getid,$sessionid,$getVoteValue,$bdd);
				break;
			case 2:
				addOrRemoveVote($getid,$sessionid,$getVoteValue,$bdd);
			
				break;
			case 3:
				addOrRemoveVote($getid,$sessionid,$getVoteValue,$bdd);
				
				break;
			case 4:
				addOrRemoveVote($getid,$sessionid,$getVoteValue,$bdd);
				
				break;
			case 5:
				addOrRemoveVote($getid,$sessionid,$getVoteValue,$bdd);
				
				break;
		}
		
   }
} else {
   exit('Erreur fatale. <a href=" http://192.168.128.13/~e180810/EVAL_V4/">Revenir à l\'accueil</a>');
}
?>
<?php
function addOrRemoveVote($getid,$sessionid,$getVoteValue,$bdd){
	$check_vote = $bdd->prepare('SELECT id_vote FROM bc_vote_lieu WHERE id_lieu = ? AND id_membre = ?');
  $check_vote->execute(array($getid,$sessionid));
  $deleteVote = $bdd->prepare('DELETE FROM bc_vote_lieu WHERE id_lieu = ? AND id_membre = ?');
  $deleteVote->execute(array($getid,$sessionid));
  if($check_vote->rowCount() == 1) {
		$deleteVote = $bdd->prepare('DELETE FROM bc_vote_lieu WHERE id_lieu = ? AND id_membre = ?');
    $deleteVote->execute(array($getid,$sessionid));
 } else {
    $insertVote = $bdd->prepare('INSERT INTO bc_vote_lieu (vote, id_membre,id_lieu) VALUES (?, ?,?)');
    $insertVote->execute(array($getVoteValue, $sessionid,$getid));
  }
	header('Location: http://192.168.128.13/~e180810/EVAL_V4/pageLieuDetail.php?id='.$getid);
}

?>



