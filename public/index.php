<?php

// Start the session if it hasn't been started for each session
session_start();

// Use the autoloader to load any required PHP classes within the app/ directory
require_once "../app/autoloader.php";

// Load any configuration needed throughout the application
require_once "../app/Config/Config.php";

// Route the request based on the request uri eg. "http://localhost:8000/controller/method/argument"
Router::route($_SERVER['REQUEST_URI']);

?>