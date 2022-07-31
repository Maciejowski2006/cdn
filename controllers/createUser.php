<?php
	session_start();

	if (!isset($_SESSION['isLoggedIn']))
	{
		header('Location: login.php');
		exit();
	}


	require_once './../config.php';
	mysqli_report(MYSQLI_REPORT_STRICT);

	// Link variables
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordHash = password_hash($password, PASSWORD_DEFAULT);

	if (isset($_POST['isAdmin']))
	{
		$isAdmin = true;
	}
	else
	{
		$isAdmin = false;
	}

	try
	{
		$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno != 0)
		{
			throw new Exception(mysqli_connect_errno());
		}

		$connection -> query("INSERT INTO users VALUES (NULL, '$username', '$passwordHash', '$isAdmin')");
	}
	catch (Exception $e)
	{
		$_SESSION['exception'] = $e;
	}

	header('location: ./../admin.php');