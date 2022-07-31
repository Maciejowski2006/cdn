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

    require_once "config.php";
    try
    {
        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        if ($connection -> connect_errno != 0)
		{
            throw new Exception(mysqli_connect_errno());
        }

        $files = $connection -> query("SELECT * FROM files");
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
    <title>Maciejowski's CDN</title>

    <link rel="stylesheet" href="assets/fontello/css/fontello.css">

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/searchV2.js" defer></script>
    <script src="js/account.js" defer></script>
    <script src="js/fileManagement.js" defer></script>
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
    <h1>Maciejowski's CDN</h1>
    <main>
        <div class="gradient__item" style="margin-bottom: 16px">
            <label for="search">
                <input type="search" name="search" placeholder="Search for files..." search/>
            </label>
        </div>
        <section>
            <?php
                while ($row = $files->fetch_assoc())
				{
					echo "
                    <div class=\"item\" data-tags=\"". $row['tags'] ."\">
                        <h3 class=\"item__title\">". $row['name'] ."</h3>
                        <span class=\"item__description\">". $row['description'] ."</span>
                        <div class=\"item__tags\"></div>
                        <div class=\"item__stats\">
                            <div class=\"item__stats-stat\"><i class=\"demo-icon icon-download\"></i>". $row['downloads'] ."</div>
                            <div class=\"gradient__button gradient__button-multiple\">
                                <button onclick='CopyURL(\"". $row['slug'] ."\")'>Copy link</button>
                                <button onclick='OpenURL(\"". $row['slug'] ."\")'>Download</button>
                            </div>
                        </div>
                    </div>
                ";
                }
            ?>
            <div class="item" data-tags="game scp northwood-studios">
                <h3 class="item__title">SCP: Secret Laboratory</h3>
                <span class="item__description">SCP: Secret laboratory is a multiplayer horror game based around SCP universum.</span>
                <div class="item__tags"></div>
                <div class="item__stats">
                    <div class="item__stats-stat"><i class="demo-icon icon-download"></i>1 402</div>
                    <div class="item__stats-stat"><i class="demo-icon icon-clock"></i>16.07.2022</div>
                    <div class="gradient__button gradient__button-multiple">
                        <button>Copy link</button>
                        <button>Download</button>
                    </div>
                </div>
            </div>
            <div class="item" data-tags="game backrooms">
                <h3 class="item__title">Parallel dimension</h3>
                <span class="item__description">Parallel dimension is survival horror game based around Backrooms universum. The player's objective is escape the dangers of Backrooms levels. Team up with your friends or go alone. You choose.</span>
                <div class="item__tags"></div>
                <div class="item__stats">
                    <div class="item__stats-downloads"><i class="demo-icon icon-download"></i>1 402</div>
                    <div class="item__stats-publishDate"><i class="demo-icon icon-clock"></i>16.07.2022</div>
                    <div class="gradient__button gradient__button-multiple">
                        <button>Copy link</button>
                        <button>Download</button>
                    </div>
                </div>
            </div>
            <div class="item" data-tags="js javascript library">
                <h3 class="item__title">jQuery latest</h3>
                <span class="item__description">jQuery is JavaScript library designed to help you create you JS application.</span>
                <div class="item__tags"></div>
                <div class="item__stats">
                    <div class="item__stats-downloads"><i class="demo-icon icon-download"></i>1 402</div>
                    <div class="item__stats-publishDate"><i class="demo-icon icon-clock"></i>16.07.2022</div>
                    <div class="gradient__button gradient__button-multiple">
                        <button>Copy link</button>
                        <button>Download</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
