<?php

// 	Mit diesem Abschnitt soll eine Verbindung zur Datenbank aufgebaut und
// 	im Falle eines Fehlers eine entsprechende Meldung ausgegeben werden

	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', 'tunix');
	define('DB_NAME', 'php');

	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);			// Verbindung zu MySQL aufbauen

if($link === false){															// Verbindung pr�fen
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

if (!mysqli_set_charset($link, "utf8mb4")) {									// Zeichensatz zu utf8mb4 wechseln
	printf("Error loading character set utf8mb4: %s\n", mysqli_error($link));
	exit();
}

?>

<!doctype html>
<html lang="de">
<head> 
	<meta charset="utf-8">
	<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<title>PHP Wiki</title>
</head>	
<body>
	<header>
		<div class="center">
			<h1>PHP WIKI</h1>
			<ul>
				<li><a class="insert-link" href="insert.php">Datensatz hinzuf�gen</a></li><br>
				<li>
				<form style="padding:0;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">		<!-- '<form>'-Tag mit Suchleiste & Button -->
					<input class='input' type="text" name="search" placeholder="PHP Dinge ..."><br><br>									<!-- '<input>'-Tag die eigentliche Suchleiste -->
					<button type="submit" name="submit-search">Suchen</button>												<!-- '<button>'-Tag startet Suche -->
				</form>
				</li>
			</ul>
		</div>
	</header>
	<main class="php">

	<?php
		$sql = "SELECT * FROM phpwiki;";										// Es wird alles aus der Tabelle 'phpwiki' in $sql gespeichert
		$ergebnis = mysqli_query($link, $sql);									// Hier wird die eigentliche Abfrage in der Datenbank ausgef�hrt
		//$spaltennamen = array('namo', 'beschreibung','beispiel','Art');
		$queryResults = mysqli_num_rows($ergebnis);								// In $queryResults wird die Anzahl an Werten aus $ergebnis gespeichert

		if (!isset($_POST['submit-search'])) {									// Eine Abfrage ob der 'Suchen'-Button geklickt wurde
			echo "<div class='command-container'><br>";
			while ($row = mysqli_fetch_assoc($ergebnis)) {						// Solange weitere Ergebnisse vorliegen werden alle Spalten der Tabelle ausgegeben
				echo "<div class='Klasse'>
						<p class='Art'>".$row['Art']."</p>
						<h3>".$row['namo']."</h3>
						<p>".$row['beschreibung']."</p>
						<p class='bspl'>".$row['beispiel']."</p>
					  </div>";
			}
			echo "</div>";
		} else {
			$search = mysqli_real_escape_string($link, $_POST['search']);						// Die Nutzereingabe wird untersucht und Zeichen die interpretiert werden w�rden, werden mit Escapezeichen versehen werden
			$sql = "SELECT * FROM phpwiki WHERE namo LIKE '%$search%' or beschreibung LIKE 
				   '%$search%' or beispiel LIKE '%$search%' or Art LIKE '%$search%'";			// mit LIKE und %-Zeichen vor und nach dem Suchbegriff, wird alles was diese Zeichenfolge enth�lt, egal ob gro� oder klein geschrieben, ausgegeben
			$result = mysqli_query($link, $sql);
			$queryResult = mysqli_num_rows($result);
			echo "<div class='result-text'>";
			echo "<div class='kind-result-text'>";
			if ($queryResult == 1) {									// Abfrage ob genau ein Ergebnis vorliegt ...
				echo "Es gibt " .$queryResult." Ergebnis!";				// ... um 'Ergebnis' mit der Anzahl im singular ...
			} else {
				echo "Es gibt " .$queryResult." Ergebnisse!";			// ... oder plural auszugeben
			}
		echo "</div>";
			echo "</div>";
			if ($queryResults > 0) {									// Abfrage ob Ergebnisse vorliegen und anschlie�ende ausgabe dieser
				echo "<div class='command-container'>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<div class='Klasse'>
					<p class='Art'>".$row['Art']."</p>
					<h3>".$row['namo']."</h3>
					<p>".$row['beschreibung']."</p>
					<p class='bspl'>".$row['beispiel']."</p>
				  </div>";
				}
				echo "</div>";
			}
		}
	?>
	</main>
</body>
</html>
