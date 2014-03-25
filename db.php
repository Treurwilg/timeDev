<?php
function ensure_logged_in() {
	if (!isset($_SESSION["name"])) {
		redirect("user.php", "Je moet ingelogd zijn om die pagina te gebruiken.");
	}	
}

# Redirects current page to the given URL and optionally sets flash message.
function redirect($url, $flash_message = NULL){
	if($flash_message){
		$_SESSION["flash"] = $flash_message;
	}
	header("Location: $url");
	die;
}
?>