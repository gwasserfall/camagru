<?php

class RenderView
{
	public static function loadUserIfFound()
	{
		$user = null;
		if (isset($_SESSION["logged_in_uid"]))
			$user = (new UserModel())->getUserByEmail($_SESSION["logged_in_uid"]);
		return $user;
	}

	public static function file($viewFile, $data = [])
	{
		if (!strstr($viewFile, ".php"))
			$viewFile = $viewFile . ".php";

		$user = self::loadUserIfFound();

		if (file_exists(VIEWS . $viewFile))
			include_once VIEWS . $viewFile;
		else
			include_once VIEWS . "404.php";
		die();
	}

	public static function json($data, $status_code, $message="")
	{
		header('Content-Type: application/json');
		$response = [
            "success" => ($status_code < 299) ? true : false,
			"data"    => $data,
			"message" => $message
		];
		$user = self::loadUserIfFound();
		http_response_code($status_code);
		echo json_encode($response);
		die();
	}

	public static function snippet($snippetFile, $data = NULL)
	{
		if (!strstr($snippetFile, ".php"))
			$snippetFile = $snippetFile . ".php";
		
		$user = self::loadUserIfFound();
		if (file_exists(SNIPS . $snippetFile))
			include_once SNIPS . $snippetFile;
		else
			include_once SNIPS . "404.php";
		die();
	}

	public static function redirect($path)
	{
		header("Location: $path");
		die();
	}
}