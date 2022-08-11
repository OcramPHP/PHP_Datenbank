<?php
	// mit dieser Datei soll eine Verbindung zur Datenbank aufgebaut werden
	//define('DB_SERVER', 'localhost');
	//define('DB_USERNAME', 'root');
	//define('DB_PASSWORD', 'tunix');
	//define('DB_NAME', 'php');

	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'web54_thomas');
	define('DB_PASSWORD', 'CTC_Thomas2022!');
	define('DB_NAME', 'web54_thomas_test');
	
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
?>
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
			<li><a class="insert-link" href="index.php">Zur Suche ...</a></li><br>
			<li>
				<form method ='GET' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<table>
						<tr>
							<label for='namo'>Name</label><br>
							<input class='input' id='namo' type='text' name='namo' required>
						</tr>
						<br><br>
						<tr>
							<label for='beschreibung'>Beschreibung</label><br>
							<input class='input' id='beschreibung' type='text' name='beschreibung' required>
						</tr>
						<br><br>
						<tr>
							<label for='beispiel'>Beispiel</label><br>
							<textarea id="beispiel" name="beispiel" rows="4" cols="40"></textarea>
						</tr>
						<br><br>
						<tr>
							<label for='Art'>Art</label><br>
							<select class='input' type='text' name="Art" id="Art">
										<option class ="drpdwn-txt" value="Variable">Variable</option>
										<option class ="drpdwn-txt" value="Funktion">Funktion</option>
										<option class ="drpdwn-txt" value="Kontrollstruktur">Kontrollstruktur</option>
							</select>
						</tr>
						<br><br>
						<tr>
							<button class="insert-button" type="submit">Speichern</button>
						</tr>
						<br><br>
						<tr>
							<div class="hinweis">
								<?php									
									$namo = $beschreibung = $beispiel = $Art = "";

									$sql = "INSERT INTO phpwiki(namo,beschreibung,beispiel,Art) VALUES(?,?,?,?) ON DUPLICATE KEY UPDATE 
									namo=VALUES(namo), 
									beschreibung=VALUES(beschreibung),
									beispiel=VALUES(beispiel), 
									Art=VALUES(Art);";

									$stmt=mysqli_prepare($link, $sql);
									mysqli_stmt_bind_param($stmt, 'ssss', $namo, $beschreibung, $beispiel, $Art);

									function test_input($data)	
									{
											$data = trim($data);
											$data = stripslashes($data);
											$data = htmlspecialchars($data);
											
											return $data;
									}

									if(!empty($_GET['namo'])||!empty($_GET['beschreibung'])||!empty($_GET['beispiel'])||!empty($_GET['Art']))
									{
									$namo= test_input($_GET['namo']);
									echo "<br>" . $namo . " ";
									$beschreibung = test_input($_GET['beschreibung']);
									echo $beschreibung ." ";
									$beispiel= test_input($_GET['beispiel']);
									echo $beispiel ." ";
									$Art = test_input($_GET['Art']);
									echo $Art ."<br>";
									}

									if(empty($_GET['namo'])||empty($_GET['beschreibung'])||empty($_GET['beispiel'])||empty($_GET['Art']))
									{
										echo "<br>Bitte geben Sie ein vollständiges Set an Werten ein";
									}else{
										if(mysqli_stmt_execute($stmt)){
											echo "Speichern hat geklappt.";
											mysqli_stmt_close($stmt);
										}else{
											echo "Speichern hat nicht geklappt.";
										}
									}
								?>
							</div>
						</tr>
						<br>
					</table>
				</form>
			</li>
		</ul>
	</div>
	</header>
</body>
</html>
