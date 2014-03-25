<?php
	# Deze pagina levert een form om uit te loggen.
	# Na uitloggen wordt teruggekeerd naar de startpagina.
	include("db.php");
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
    	$params = session_get_cookie_params();
    	setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);
	}
	session_regenerate_id(TRUE);
	session_destroy();
	redirect("index.php", "Logout successful.");
?>