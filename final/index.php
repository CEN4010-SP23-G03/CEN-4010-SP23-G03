<?php
if(isset($_SESSION["user_id"]))
{
	header('Location: overview.php');
	exit;
}
else
{
    header('location: login.php')
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Overview - An overview of your discoveries!</title>
    </head>
    <body>
        <h1>Loading...</h1>
    </body>
</html>