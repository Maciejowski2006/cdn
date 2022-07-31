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
	$uid = $_POST['uid'];

	try {
		$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno != 0) {
			throw new Exception(mysqli_connect_errno());
		}

		$connection->query("	DELETE FROM users WHERE id = $uid");
	} catch (Exception $e) {
		$_SESSION['exception'] = $e;
	}

	header('location: ./../admin.php');