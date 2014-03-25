<?php
# De ingevoerde login-gegevens komen hier terecht.
# Bij succesvolle login wordt de gebruikersnaam opgeslagen in een sessievariabele.
include 'PasswordHash.php';
include("db.php");
if(isset($_POST["user"]) && isset($_POST["password"])) {
	$password = $_POST['password'];
	$user = $_POST['user'];
}
$hasher = new PasswordHash(8, false);
$hash = $hasher->HashPassword($password);
if (strlen($hash) >= 20) {
try {
		$conn = new PDO("mysql:dbname=jkooijman;host=localhost", "root");
	 } catch(PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
    	die();
	 }
	 	$sql = "select aanduiding, controle from Tijdschrijver where aanduiding = :aanduiding";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':aanduiding'=>$user));
		$rows = $stmt->fetchAll();
		if($rows){
			$row = $rows[0]; // Hier is de keus gemaakt voor unieke gebruikersnamen!
			$check = $hasher->CheckPassword($password, $row['controle']);
			if($check)
			{
				session_start();
				$_SESSION["name"] = $user;
				redirect("index.php", "Login succesvol! Welkom terug.");
			}  else {
				redirect("user.php", "Incorrecte combinatie van gebruikersnaam en wachtwoord");
			}
		} 
   } else { 
	?>
	<p>Er is iets verkeerd met gebruikersnaam of wachtwoord"</p> 
	<?php
}
$conn = null;
?>