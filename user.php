<?php 
include("top.php");
if(isset($_SESSION["name"])) {
	?>
	<h2>User Status</h2>
	<p>You are logged in as <?= $_SESSION["name"] ?>.</p>
	<form id="logout" action="logout.php" method="POST">
		<input type="submit" value="Log out" />
		<input type="hidden" name="logout" value="true" />
	</form>
<?php } else { ?>
	<h2>Log in</h2>
	<form id="login" action="http://localhost/Tijdschrijf/sitePrograms/login.php" method="POST">
	 <dl>
		<dt>Naam</dt>       <dd><input type="text" name="user" maxlength="26" size="26" /></dd>
		<dt>Wachtwoord</dt> <dd><input type="password" name="password" maxlength="26" size="26" /></dd>
		<dt> </dt>          <dd><input type="submit" value="Registreer"/></dd>
		<dt> </dt>          <dd><input type="reset" value="Reset invoerformulier" /></dd>
	</dl>
	</form>
	<?php } ?>
	<?php
		include("bottom.php"); 
	?>