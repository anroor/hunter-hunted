<?php
session_start();
require_once("includes/configuration.php");
?>

<?php
if( !isset( $_SESSION['hh-logged'] ) ){
	header("Location: login.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="title" content="HunterHunted User Profile Page" />
<meta name="description" content="Index HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="index, follow" />
<meta name="keywords" content="user profile, profile, perfil de usuario, perfil, hunterhunted" />
<link rel="icon" type="image/png" href="img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="basic.css" rel="stylesheet" type="text/css" media="all" >
<link href='http://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
<title>HunterHunted User Profile Page</title>
</head>
    
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">HunterHunted</a></h1>
            <div id="register">
                <h2>Registro</h2>
                <ul>
                    <li><a href="#">Ver mi perfil</a></li>
                    <li><a href="login.php">Cerrar Sesión</a></li>
                </ul>
            </div>
            <div id="nav">
                <h2>Sections</h2>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="history.php">Historia del juego</a></li>
                    <li><a href="rules.php">Reglas</a></li>
                    <li><a href="tournaments.php">Torneos</a></li>
                    <li><a href="statistics.php">Estadísticas</a></li>
                </ul>
            </div>
        </div>
        <div id="center" class="separating">
            <h2>Center</h2>
            <?php
                    $connection = mysql_connect($db_host,$db_user,$db_password);
                    mysql_select_db($db_schema,$connection);

                    $query = "SELECT user_name, full_name, email, city, country FROM users WHERE id={$_SESSION['hh-id']}";               
                    $result = mysql_query($query,$connection);                 
                    $num_rows = mysql_num_rows($result);

                    
                    if($num_rows > 0){
                        $row = mysql_fetch_array($result);
                    
            ?>
            <p>Bienvenido, <?php echo $row['user_name']; ?>.</p>
            <p><a href="edit_profile.php">Modificar perfil</a></p>
            <div>
            <h3>Información de Perfil</h3>
            <table border="1" cellspacing="0" cellpadding="0" class="table">
                <tr>
                  <th scope="col">Nombre Completo</th>
                  <th scope="col">Correo Electrónico</th>
                  <th scope="col">Ciudad</th>
                  <th scope="col">País</th>
                </tr>
                <tr>
                  <td scope="col"><?php echo $row['full_name']; ?></td>
                  <td scope="col"><?php echo $row['email']; ?></td>
                  <td scope="col"><?php echo $row['city']; ?></td>
                  <td scope="col"><?php echo $row['country']; ?></td>
                </tr>
            </table>
             </div>
             <?php
                    }else{
             ?>
            <p class="error">No hay información del usuario que mostrar</p>
             <?php
                    }
              ?>
            
            <div>
            <?php
                    $query = "SELECT hunter_score, hunted_score, punctuation FROM score WHERE id_user={$_SESSION['hh-id']}";
                    $result = mysql_query($query,$connection);
                    $num_rows = mysql_num_rows($result);
                    if($num_rows > 0){
                        $row = mysql_fetch_array($result);
             ?>
            
             <h3>Puntajes</h3>
             <table border="1" cellspacing="0" cellpadding="0" class="table">
                <tr>
                  <th scope="col">Puntos Cazador</th>
                  <th scope="col">Puntos Presa</th>
                  <th scope="col">Puntuacion total</th>
                </tr>
                <tr>
                  <td scope="col"><?php echo $row['hunter_score']; ?></td>
                  <td scope="col"><?php echo $row['hunted_score']; ?></td>
                  <td scope="col"><?php echo $row['punctuation']; ?></td>
                </tr>
             </table>
             <?php
                    }else{
             ?>
            <p class="error">No hay información de los puntajes para mostrar</p>            
            <?php
                    }
                    mysql_close($connection);
             ?>
            </div>
        </div>
        <div id="footer">
            <h2>Footer</h2>
            <p>Curso: Software Bajo La Web y Programación Móvil. Uninorte  2013. Derechos reservados</p>
        </div>
    </div>
</body>
</html>