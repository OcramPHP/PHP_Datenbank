<!doctype html>
<html lang="de">
<head> 
	<meta charset="utf-8">
	<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="stylesheet.css">
	<title>PHPwiki</title>
</head>	
<body>
	<header>
		<div class="center">
			<h1>PHP WIKI</h1>
			<ul>
			<li><a class="insert-link" href="index.php">Zur Suche wechseln</a></li><br>
				<li>
					<form method ='GET' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
						<table>
							<tr>
								<label for='namo'>Name</label><br>
								<input class='input' id='namo' type='text' name='namo' required>
								<br>
							</tr>
							<br>
							<tr>
								<label for='beschreibung'>Beschreibung</label><br>
								<input class='input' id='beschreibung' type='text' name='beschreibung' required>
								<br>
							</tr>
							<br>
							<tr>
								<label for='beispiel'>Beispiel</label><br>
								<input class='input' id='beispiel' type='text' name='beispiel' required>
								<br>
							</tr>
							<br>
							<tr>
								<label for='art'>Art</label><br>
								<select class='input' type='text' name="art" id="art">
											<option value="Variable"> Variable</option>
											<option value="Funktion"> Funktion</option>
											<option value="Kontrollstruktur">Kontrollstruktur</option>
								</select>
								<br><br>
							</tr>
							<br>
							<tr>
								<button class="insert-button" type="submit">Speichern</button>
							</tr>
							<br><br>
							<tr>
								<?php

								if(empty($_GET['namo'])||empty($_GET['beschreibung'])||empty($_GET['beispiel'])||empty($_GET['art']))
									{
									echo "Bitte geben Sie ein vollständiges Set an Werten ein";
								}else{
									if(mysqli_stmt_execute($stmt)){
										echo "Speichern hat geklappt.";
										mysqli_stmt_close($stmt);
									}else{
										echo "Speichern hat nicht geklappt.";
									}
								}
							
								if(!empty($_GET['namo'])||!empty($_GET['beschreibung'])||!empty($_GET['beispiel'])||!empty($_GET['art']))
								{
									$namo= test_input($_GET['namo']);
									echo $namo;
									$beschreibung = test_input($_GET['beschreibung']);
									echo $beschreibung;
									$beispiel= test_input($_GET['beispiel']);
									echo $beispiel;
									$art = test_input($_GET['art']);
									echo $art;
								}
								?>
							</tr>
						</table>
					</form>
				</li>
			</ul>
		</div>
	</header>

		<?php
			// Database credentials. Assuming you are running MySQL
			// server with default setting (user 'root' with password 'CTC-Lohr')
			// mit dieser Datei soll eine Verbindung zur Datenbank aufgebaut werden
			define('DB_SERVER', 'localhost');
			define('DB_USERNAME', 'root');
			define('DB_PASSWORD', 'tunix');
			define('DB_NAME', 'php');
			
			// Attempt to connect to MySQL database 
			$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
			
			// Check connection
			if($link === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
			
			// change character set to utf8mb4 
			if (!mysqli_set_charset($link, "utf8mb4")) {
				printf("Error loading character set utf8mb4: %s\n", mysqli_error($link));
				exit();
			}
