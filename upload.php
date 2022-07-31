<?php
    session_start();

	require_once 'config.php';
	mysqli_report(MYSQLI_REPORT_STRICT);

	$isAdmin = false;

	if (isset($_SESSION['isLoggedIn']))
	{
		if ($_SESSION['isAdmin'])
		{
			$isAdmin = true;
		}
	}
    else
	{
		header('Location: login.php');
		exit();
    }

    if (isset($_POST['name']))
	{
        $unixTime = time();
        $timeZone = new \DateTimeZone("Europe/Warsaw");
        $time = new \DateTime();
        $time -> setTimestamp($unixTime) -> setTimezone($timeZone);
        $formattedTime = $time->format("Y-m-d");

		$targetDirectory = "files/";
        $file = $_FILES['file']['name'];
		$targetFile = $targetDirectory . basename($file);
		$uploadOk = 1;

        // Link variables
        $name = $_POST['name'];
        $description = $_POST['description'];
        $tags = $_POST['tags'];
        $uploadDate = date("Y-m-d");
        $downloads = 0;
        $slug = rawurlencode($file);



		if ($uploadOk == 0)
		{
			echo "not today";
		}
		else
		{
			if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile))
			{
				echo "The file ". htmlspecialchars( basename( $_FILES['file']['name'] ) ). "Has been uploaded";

				try
				{
					$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

					if ($connection->connect_errno != 0)
					{
						throw new Exception(mysqli_connect_errno());
					}

					$result = $connection->query("INSERT INTO files VALUES (NULL, '$name', '$description', '$tags', $downloads, '$slug')");

					$connection->close();
				}
				catch (Exception $e)
				{
					$_SESSION['exception'] = $e;
				}
			}
			else
			{
				echo "There was an error uploading your file.";
			}
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
	<link rel="stylesheet" href="css/upload.css">
	<link rel="stylesheet" href="assets/fontello/css/fontello.css">
	<script src="js/fileUpload.js" defer></script>
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
                echo "<a class='inline' href='controllers/logout.php'>Log out</a>";
			?>
        </div>
    </section>
</nav>

<h1>Upload file</h1>
<form class="upload" style="margin-bottom: 16px" method="post" enctype="multipart/form-data">
    <section class="upload__file">
        <span class="upload__text">Drag file here to upload</span>
        <span class="upload__filename" filename>No file selected</span>
        <input type="file" name="file">
    </section>
    <section class="upload_fileMeta">
        <div class="gradient">
            <input type="text" name="name" id="name" placeholder="File name">
        </div>
        <div class="gradient description">
            <textarea name="description" id="description" placeholder="File description" ></textarea>
        </div>
        <div class="gradient">
            <input type="text" name="tags" id="tags" placeholder="Tags (separated by space)">
        </div>
        <div class="gradient gradient__button">
            <button type="submit">Upload</button>
        </div>
    </section>

</form>
</body>
</html>