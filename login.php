<?php
    session_start();

	$isAdmin = false;

	if (isset($_SESSION['isLoggedIn']))
	{
		if ($_SESSION['isAdmin'])
		{
			$isAdmin = true;
		}
	}

    require_once 'config.php';
	mysqli_report(MYSQLI_REPORT_STRICT);

    if (isset($_POST['username']))
	{
		// Link variables
		$username = $_POST['username'];
		$password = $_POST['password'];

		$username = htmlentities($username, ENT_QUOTES, "UTF-8");

		try
		{
			$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

			if ($connection->connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errno());
			}

			$result = $connection->query(sprintf("SELECT * FROM users WHERE username='%s'",
				mysqli_real_escape_string($connection, $username)));

			$userCount = $result->num_rows;

            if ($userCount > 0)
			{
                $isLoggedIn = true;

				$row = $result->fetch_assoc();

				if (password_verify($password, $row['password']))
				{
					$_SESSION['isLoggedIn'] = true;

                    // Set vars

                    $_SESSION['username'] = $username;
                    $_SESSION['isAdmin'] = $row['isAdmin'];

                    header('Location: upload.php');
				}

				$result->free_result();
            }

			$connection->close();
		}
		catch (Exception $e)
		{
			$_SESSION['exception'] = $e;
		}
    }
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Maciejowski's CDN</title>

	<link rel="stylesheet" href="css/global.css">
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="assets/fontello/css/fontello.css">
    <script src="js/account.js" defer></script>
</head>
<body onload="main()">
<nav>
    <div class="gradient__item">
        <button onclick="showAccountManagement()">
            <i class="demo-icon icon-user"></i>
        </button>
    </div>
    <section class="section">
        <div class="gradient__item">
            <button onclick="hideAccountManagement()">
                <i class="demo-icon icon-cancel"></i>
            </button>
        </div>
        <div class="management">
			<?php
				if ($isAdmin) echo "<a class=\"inline\" href=\"admin.php\">Admin Portal</a>";

				echo "<a class='inline' href='index.php'>Home</a>";
				echo "<a class='inline' href='upload.php'>Upload a file</a>";

				if (isset($_SESSION['isLoggedIn']))
				{
					echo "<a class='inline' href='controllers/logout.php'>Log out</a>";
				}
				else
				{
					echo "<a class='inline' href='login.php'>Log in</a>";
				}
			?>
        </div>
    </section>
</nav>

<h1>Log in to your account</h1>
<form method="post">
    <div class="gradient__item">
        <input type="text" name="username" placeholder="Username"/>
    </div>
    <div class="gradient__item">
        <input type="password" name="password" placeholder="Password"/>
    </div>
    <div class="gradient__button">
        <button type="submit">Log in</button>
    </div>
    <?php
        if (isset($isLoggedIn))
		{
            echo "Login successful!";
        }
    ?>
</form>
</body>
</html>