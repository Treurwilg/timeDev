

<?php
	include("db.php");
	include("top.php");
	ensure_logged_in();

?>
		<div class="kolom">
			<?php
				$db = new PDO("mysql:dbname=jkooijman;host=localhost","root");
				$rows=$db->query("select * from Fase order by volgnr");
			?>
				<table>
				<caption>Project fasen</caption>
					<tr class="header">
                <td>code</td>
                <td>naam</td>
               </tr>
               <?php
               foreach ($rows as $row) { ?>
               <tr>
               	<td><?= $row["code"] ?></td>
               	<td><?= $row["naam"] ?></td>
               </tr> <?php
               }      
               ?>
            </table>
		</div>
		<div class="kolom">
			<?php
				$rows=$db->query("select * from Type order by startnr");
			?>
				<table>
				<caption>Project types</caption>
					<tr class = "header">
					 <td>code</td>
					 <td>omschrijving</td>
					 <td>startnr</td>
					 <td>eindnr</td>
					</tr>
					<?php
					foreach ($rows as $row) { ?>
						<tr>
							<td><?= $row["code"] ?></td>
							<td><?= $row["omschrijving"] ?></td>
							<td><?= $row["startnr"] ?></td>
							<td><?= $row["eindnr"] ?></td>
						</tr>
						<?php
					}
					?>
				</table>
		</div>
		<div class='balk'>
   	<?php
				$rows=$db->query("select nr, naam, type, opdrachtgever, geplandeStart, geplandEind
				                  from Project 
				                  order by nr");
			?>	
			<table>
			<caption>Projecten</caption>
					<tr class = "header">
					 <td>nr</td>
					 <td>naam</td>
					 <td>type</td>
					 <td>opdrachtgever</td>
					 <td>geplandeStart</td>
					 <td>geplandEind</td>
					</tr>
					<?php
					foreach ($rows as $row) { ?>
						<tr>
							<td><?= $row["nr"] ?></td>
							<td><?= $row["naam"] ?></td>
							<td><?= $row["type"] ?></td>
							<td><?= $row["opdrachtgever"] ?></td>
							<td><?= date("d-m-Y",strtotime($row["geplandeStart"])) ?></td>
							<td><?= date("d-m-Y",strtotime($row["geplandEind"])) ?></td>
						</tr>
						<?php
					}
					?>
				</table>
		</div>
		<div class=balk>
   	<?php
				$rows=$db->query("select nr, datum, project, fase, tijd, opmerking
				                  from Tijdregel 
				                  order by nr");
			?>
			<table>	
			<caption>Tijdregels</caption>	
				<tr class = "header">
					<td>nr</td>
					<td>datum</td>
					<td>project</td>
					<td>fase</td>
					<td>tijd</td>
					<td>opmerking</td>
			</tr>
			<?php
				foreach ($rows as $row) { ?>
					<tr>
						<td><?= $row["nr"] ?></td>
						<td><?= date("d-m-Y",strtotime($row['datum'])) ?></td>
						<td><?= $row["project"] ?></td>
						<td><?= $row["fase"] ?></td>
						<td><?= $row["tijd"] ?></td>
						<td><?= $row["opmerking"] ?></td>
					</tr>
				<?php
				}
				?>
			</table>
		</div>
<?php
	include("bottom.php");
?>