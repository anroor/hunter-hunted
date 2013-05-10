<?php
session_start();
require_once("../includes/configuration.php");
?>
<?php
if( !isset( $_SESSION['hh-logged'] ) ){
	header("Location: login.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="title" content="HunterHunted Administrator" />
<meta name="description" content="Index Administrator HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="none" />
<link rel="icon" type="image/png" href="../img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminStyle.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Administrator</title>
</head>

<body>
    <div id="wrapper">
	<p>Bienvenido, <strong><?php echo $_SESSION['hh-full_name']; ?></strong>, (<a href="login.php" target="_self">Salir</a>)</p>
	<div id="header">
            <h1><a href="index.php" target="_self"><img src="../img/HunterHunted_Logo.png" /></a></h1>
	</div>
	<div id="navcontainer">
            <ul>
                <li><a href="index.php" target="_self" id="current">Inicio</a></li>
                <li><a href="users.php" target="_self">Usuarios</a></li>
                <li><a href="games.php" target="_self">Juegos</a></li>
            </ul>
	</div>
	<div id="content">
		<p>&nbsp;</p>
	</div>
    </div>
</body>
</html>