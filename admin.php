<?php
    session_start();

	if (isset($_SESSION['isLoggedIn']))
    {
        if (!$_SESSION['isAdmin'])
        {
			header('Location: login.php');
			exit();
        }
	}
    else
	{
		header('Location: login.php');
		exit();
    }


    require_once 'config.php';
	mysqli_report(MYSQLI_REPORT_STRICT);

	try
	{
		$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

		if ($connection->connect_errno != 0)
		{
			throw new Exception(mysqli_connect_errno());
		}

		$userList = $connection -> query("SELECT * FROM users");

        $connection->close();
	}
	catch (Exception $e)
	{
		$_SESSION['exception'] = $e;
	}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CDN | Admin Area</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/admin.css">
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
				echo "<a class=\"inline\" href=\"admin.php\">Admin Portal</a>";
				echo "<a class='inline' href='index.php'>Home</a>";
				echo "<a class='inline' href='upload.php'>Upload a file</a>";
                echo "<a class='inline' href='controllers/logout.php'>Log out</a>";
			?>
        </div>
    </section>
</nav>

<h1>Admin Area</h1>
<main>
    <section id="userManagement">
        <h2><i class="demo-icon icon-user"></i>User management</h2>

        <div id="userList">
            <?php
                while ($row = $userList->fetch_assoc())
                {
                    echo "<form class='user' method='post' action='controllers/removeUser.php'>";

                    if ($row['isAdmin'] == 1)
                    {
						echo "<span class='admin'>". $row['username'] ."</span>";
                    }
                    else
					{
                        echo "<span>". $row['username'] ."</span>";

                    }
                    echo "<input type=\"number\" name=\"uid\" class=\"hiddenInput\" value=\"". $row['id'] ."\">";
                    echo "<div class='gradient__button'>";
                    echo " <button type=\"submit\"><i class=\"demo-icon icon-user-times\"></i> Remove</button>";
                    echo "</div>";
                    echo "</form>";
                }
            ?>
            <div class="createUser">
                <h3>Create user</h3>
                <form method="post" action="controllers/createUser.php">
                    <div class="vert">
                        <div class="gradient__item">
                            <input type="text" name="username" placeholder="Username">
                        </div>
                        <div class="gradient__item">
                            <input type="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="vert">
                        <label for="isAdmin">
                            <input type="checkbox" name="isAdmin" id="isAdmin">
                            Is Admin?
                        </label>
                        <div class="gradient__button">
                            <button type="submit"><i class="demo-icon icon-user-plus"></i> Create</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>



    </section>
    <section id="fileManagement">
        <h2><i class="demo-icon icon-database"></i>File management</h2>
        <div id="fileList">
            <h3>Delete file</h3>
            <form method="post">
                <div class="vert">
                    <div class="gradient__item">
                        <input type="text" name="createUser" placeholder="File name">
                    </div>
                    <div class="gradient__button" style="height: 48px">
                        <button type="submit" style="width: max-content"><i class="demo-icon icon-user-plus"></i> Delete</button>
                    </div>
                </div
            <form>
        </div>
    </section>
</main>
</body>
</html>