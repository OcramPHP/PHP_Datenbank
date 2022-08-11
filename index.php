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