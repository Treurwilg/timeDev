

<?php
	include("db.php");
	include("top.php");
	ensure_logged_in();

?>
<form action="http://localhost/Tijdschrijf/sitePrograms/processTijd.php" method="POST">
	<div>
		Projectnummer:
		<input type="number" name="projectnr" min="1" max="999" maxlength="3" size="3" />
		<div>
		  	<label>Vandaag<input type="radio" name="vandaag" value="ja" checked="checked" /></label>
		  	<label>Andere dag<input type="radio" name="vandaag" value="nee" /></label>
			Dag: 
			<input type="number" name="dag" min="1" max="31" maxlength="2" size="2" /> 
			Maand:
			<input type="number" name="maand" min="1" max="12" maxlength="2" size="2" />  
			Jaar: 20
			<input type="number" name="jaar" value="14" min="14" max="14" maxlength ="2" size="2" /> 'dd-mm-jj'
		</div>
		<div>
      	Fase:
      	<label>INI<input type="radio" name="code" value="INI" /></label>
      	<label>DEF<input type="radio" name="code" value="DEF" /></label> 
      	<label>ONT<input type="radio" name="code" value="ONT" /></label> 
      	<label>VRB<input type="radio" name="code" value="VRB" /></label> 
      	<label>REA<input type="radio" name="code" value="REA" checked="checked" /></label> 
      	<label>IMP<input type="radio" name="code" value="IMP" /></label> 
      	<label>NAZ<input type="radio" name="code" value="NAZ" /></label> 		
		</div>
		Gewerkte tijd in uren en tienden van uren:
		<input type="number" name="uren" value="0" min="0" max="24" size="2" maxlength="2" />, 
		<input type="number" name="tienden" value="0" min="0" max="9" size="1" maxlength="1" />
		<BR/>
		Opmerking:
		<input type="text" name="opmerking" maxlength="255" size="26" /> 
		<input type="submit" value="Voeg toe aan database" />
		<input type="reset" value="Reset invoerformulier" />
	</div>
</form>
<?php
	include("bottom.php");
?>