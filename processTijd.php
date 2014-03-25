<?php
	/* Verwijdert elementen van input-array waarvan de sleutelwaarde niet voorkomt in 
	de array $allowed. Functie getest m.b.v. testFilterArray.php*/                                      
	function filterArray($input, $allowed) {                                      
		foreach(array_keys($input) as $key){
			if(!in_array($key, $allowed)){
				unset($input[$key]);
			}
		}
		return $input;
	}
	
	/* Vervangt van de input-string de karakters die niet voorkomen in de regex 
	door een spatie. Functie getest m.b.v. testPreg_replace.php */
	function make_valid($input) {                           
		return preg_replace('/[^A-Za-z0-9.,\(\)\s-]/',' ',$input); 
	}

	/* Functie gaat uit van bestaande database-$connection. Terugkeerwaarde is TRUE als
		$value voorkomt in kolom $column van tabel $table. Anders FALSE.
	*/ 
	function exists_value_in_table($connection, $value, $table, $column) {
		$values = array();
		$rows = $connection->query("select ".$column." from ".$table);
		foreach($rows as $row) {
			$values[] = $row[0];
		}
		if(!in_array($value, $values)) {
			return FALSE;
		} else { 
		 	return TRUE;
		}
	}
	
	$test = FALSE; # Softwarebeheer
	
	#controleer de $_POST-array op verboden sleutelwaarden en zet de sleutels en de waarden in nieuwe array $data
	$data = array();
	$allowed = array('projectnr','vandaag', 'dag','maand','jaar','code','uren','tienden','opmerking');
	$data = filterArray($_POST,$allowed);
	
	# extraheer de formdata uit de data-array
	$projectnr = (int)$data["projectnr"]; 	if($test) {echo "projectnr".$projectnr."<br/>";}
	$vandaag = $data["vandaag"];          	if($test) {echo "vandaag".$vandaag."<br/>";}
	$fase = $data["code"];						if($test) {echo "fase".$fase."<br/>";}
	$tienden = (int)$data["tienden"];		if($test) {echo "tienden".$tienden."<br/>";}
	$uren   = (int)$data["uren"];				if($test) {echo "uren".$uren."<br/>";}
	$dag = (int)$data["dag"];					if($test) {echo "dag".$dag."<br/>";}
	$maand = (int)$data["maand"];				if($test) {echo "maand".$maand."<br/>";}
	$jaar = (int)$data["jaar"];				if($test) {echo "jaar".$jaar."<br/>";}
	$opmerking = $data["opmerking"];			if($test) {echo "opmerking".$opmerking."<br/>";}
	
	# creeer PHP data object en de boolean $doorgaan als controleparameter voor het invoeren in de database
	try {
		$conn = new PDO("mysql:dbname=jkooijman;host=localhost", "root");
		$doorgaan = TRUE; # houdt bij of de formdata in de database kunnen worden ingevoerd
	} catch(PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		$doorgaan = FALSE;
    	die();
	}
	
	# check de formdata nummer en fase tegen de in de database toegestane waarden
	$doorgaan = exists_value_in_table($conn, $projectnr, "Project", "nr"); 	if($test){echo "doorgaan1: ".$doorgaan;}
	$doorgaan = exists_value_in_table($conn, $fase, "Fase", "code");			if($test){echo "doorgaan2: ".$doorgaan;}

	# nog checken tegen regex voor hooguit 2 digits voor de komma en 1 erna
	if(preg_match("/^[0-9]$/",$uren) || preg_match("/^1[0-9]$/",$uren) || preg_match("/^2[0-4]$/",$uren) )
		{
			echo "uren correct ingevoerd";
		} else {
			$doorgaan = FALSE;
			echo "aantal uren niet juist ingevoerd of buiten de toegestane range";
		}
	if(!preg_match("/^[0-9]$/",strval($tienden)))
		{$doorgaan = FALSE; 
		echo "aantal tienden niet juist ingevoerd of buiten de toegestane range";}
	if ($vandaag == 'nee'){
		if(!preg_match("/^[1-9]|1[0-9]|2[0-9]|3[0-1]$/",strval($dag))) {$doorgaan = FALSE; echo "dag fout";}
		if(!preg_match("/^[1-9]|1[0-2]$/",strval($maand))) {$doorgaan = FALSE; echo "maand fout";}
	}
	
	# check $uren tegen de range van tijd die per dag kan worden ingevoerd
	if($tienden < 0 || $tienden > 9) { $doorgaan = FALSE; echo "aantal tienden niet juist ingevoerd";}
	if($uren < 0 || $uren > 24) {$doorgaan = FALSE;echo "uren niet in goede range";}
	$tijd = $uren + $tienden/10;
	echo "tijd is uren plus minuten ".$tijd;
	if($tijd > 24) {$doorgaan = FALSE;echo "tijd moet kleiner zijn dan 24"; }
	echo "Tijd is ".strval($tijd);
	
	# check of datum van vandaag of van een andere dag moet worden ingevuld
	if ($vandaag == 'nee' && checkdate($maand, $dag, $jaar)) { # check ook de datumvaliditeit
		$datum = strval(2000 + $jaar).'-'.strval($maand).'-'.strval($dag);
	} elseif($vandaag == 'ja') {
		$datum = date("Y-m-d H:i:s");
	} else { 
		$doorgaan = FALSE;
		echo "Er is iets ernstig fout gegaan met de overdracht van de ingevoerde datumgegevens";
	}
	
	# check $opmerking op lengte
	if(strlen($opmerking) > 255) {$doorgaan = FALSE;}
	# check $opmerking op ongewenste symbolen: vervang ze door spaties
	$opmerking = make_valid($opmerking);
	echo $opmerking;
	
	if($doorgaan) { # insert de data in tabel Tijdregel van database jkooijman
		$sql = "insert into Tijdregel(project, datum, fase, tijd, opmerking) values (:projectnr, :datum, :fase, :tijd, :opmerking)";
		$q = $conn->prepare($sql);
		if($q->execute(array(':projectnr'=>$projectnr,
								':datum'=>$datum,
	                  	':fase'=>$fase,
	                  	':tijd'=>$tijd,
	                  	':opmerking'=>$opmerking))) {
	   echo 'De data voldoen aan de eisen en zijn ingevoerd in de database!';
	   } else {
		echo 'De data voldoen aan de eisen maar invoeren in de database is niet gelukt!';
		}                 		
	}
	$conn = null; # Afsluiting van de verbinding met de database
	header("Location: formTijd.php");
?>
