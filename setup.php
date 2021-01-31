<?php

function main() {

	echo "\nCamagru initial setup.\nPlease complete the following.\n\n";

	$username = userInput("MySQL username [root] : ", "root");
	$password = userInput("MySQL password [] : ");
	$host =     userInput("MySQL host     [127.0.0.1] : ", "127.0.0.1");

	echo "\n";

	if (!$password) {die("Database password is required.");}
	
	try {
		$conn = new PDO( "mysql:host=$host;charset=utf8", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connection to database successfull, setting values in ./app/Config/Config.php\n\n";
		setConfigFile($username, $password, $host);
	} catch(PDOException $e) {
		die("MySQL Exception: " . $e->getMessage());
	}

	$createDatabase = userYesNo("Create camagru database? [Y/n] : ", true);

	if ($createDatabase) {
		$stmt = $conn->prepare("CREATE DATABASE IF NOT EXISTS camagru; USE camagru;");
    
		if ($stmt->execute())
			echo "\nDatabase camagru created\n\n";
		else
			die("Could not create database. Please check the MySQL server logs");
	}

	if (userYesNo("Create database tables? [Y/n] : ", true)) {
		require_once "./app/Config/DatabaseSchema.php";

		echo "\n";

		foreach ($sql as $table => $query) {
	
			$stmt = $conn->prepare($query);
			
			if ($stmt->execute())
				echo "Created table [$table]\n";
			else
				die("Failed to create table $table\n");	
		}
		echo "\n";
	}


	if (userYesNo("Load stickers? [Y/n] : ", true)) {
		$scanned_directory = array_diff(scandir("./stickers"), array('..', '.'));

		$stmt = $conn->prepare("DELETE FROM stickers");
		if ($stmt->execute()) {
			echo "\nCleaned [stickers] table\n";
		} else {
			die("Error cleaning stickers table");
		}

		

		$counter = 0;

		foreach ($scanned_directory as $file) {
			$counter++;
			$path = "./stickers/" . $file;
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			$path_parts = pathinfo($path);
			
			$name = $path_parts['filename'];
		
			$stmt = $conn->prepare("INSERT INTO stickers (name, image, type) VALUES (:name, :image, :type)");
			$stmt->bindParam(":name", $name);
			$stmt->bindParam(":image", $base64);
			$stmt->bindParam(":type", $type);
			$stmt->execute();
		}
		echo "Added $counter stickers.\n";
	}

	echo "\nSetup complete, to launch webserver use : 'php -s 0.0.0.0:8000 -t public/'\n\n";
}

function userInput($prompt, $default=false) {
	echo $prompt;
	$input = rtrim(fgets(STDIN));
	return $input ? $input : $default;
}

function userYesNo($prompt, $default) {
	$input = "";
	
	if (!is_bool($default)) {
		throw new Exception("Defaults on userYesNo must be of type bool.");
	}

	while (1) {
		$input = userInput($prompt, false);
		if (!$input) {
			return $default;
		}

		if (in_array(strtolower($input), ["y", "n"])) {
			break;
		}	
	}
	return strtolower($input) == "y" ? true : false;
}


function setConfigFile($username, $password, $host) {
	$config = file_get_contents("./app/Config/Config.php");

	$salt = generateRandomString(30);

	$config = preg_replace('/^define\("DATABASE_URI".*/m', "define(\"DATABASE_URI\", \"$host\");", $config);
	$config = preg_replace('/^define\("DATABASE_USER".*/m', "define(\"DATABASE_USER\", \"$username\");", $config);
	$config = preg_replace('/^define\("DATABASE_PASS".*/m', "define(\"DATABASE_PASS\", \"$password\");", $config);
	$config = preg_replace('/^define\("SALT".*/m', "define(\"SALT\", \"$salt\");", $config);

	file_put_contents("./app/Config/Config.php", $config);
}

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 
		ceil($length/strlen($x)) )),1,$length);
}




main();