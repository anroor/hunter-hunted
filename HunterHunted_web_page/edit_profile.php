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
<meta name="title" content="HunterHunted Profile" />
<meta name="description" content="Index HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="index, follow" />
<meta name="keywords" content="edit profile, hunterhunted, edit users, users, profile" />
<link rel="icon" type="image/png" href="img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
<link href="basic.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Profile</title>
</head>


<body>
<div id="wrapper">
        <div id="header">
            <h1><a href="index.php">HunterHunted</a></h1>
            <div id="register">
                <h2>Registro</h2>
                <ul>
                    <li><a href="profile.php">Ver mi perfil</a></li>
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
            <h3>Modificar Perfil</h3>
             <?php
                $connection = mysql_connect($db_host,$db_user,$db_password);
                mysql_select_db($db_schema,$connection);

                $query = "SELECT user_name, full_name, email, city, country FROM users WHERE id={$_SESSION['hh-id']}";
                $result = mysql_query($query,$connection);

                $row = mysql_fetch_array($result);

                $user_name= $row['user_name'];
		$full_name = $row['full_name'];
                $email = $row['email'];
                $city = $row['city'];
                $country = $row['country'];
                mysql_close($connection);
            ?> 
            <form id="form_edit_users" name="users" enctype="multipart/form-data" method="post">
                <p>
                    <label for="full_name">Nombres:</label>
                    <input maxlength="40" name="full_name" type="text" value="<?php echo $full_name; ?>"/>
                </p>
                <p>
                    <label for="user_name">Nombre de usuario:</label>
                    <input maxlength="20" name="user_name" type="text" value="<?php echo $user_name; ?>"/>
                </p>
                <p>
                    <label for="password">Contraseña</label>
                    <input maxlength="10" name="password" type="password" />
                </p>
                <p>
                    <label for="email">Correo electrónico</label>
                    <input maxlength="45" name="email" type="email" value="<?php echo $email; ?>"/>
                </p>
                <p>
                    <label for="country">País</label>
                    <input maxlength="20" name="country" type="text" value="<?php echo $country; ?>"/>
                </p>
                <p>
                    <label for="city">Ciudad</label>
                    <input maxlength="20" name="city" type="text" value="<?php echo $city; ?>"/>
                </p>
                <p><input id="btn_edit" name="edit" type="submit" /></p>
                <?php
                    if( isset( $_POST['edit'] ) ){
                            $id = $_SESSION['hh-id'];
                            $user_name= $_POST['user_name'];
                            $full_name = $_POST['full_name'];
                            $email = $_POST['email'];
                            $city = $_POST['city'];
                            $country = $_POST['country'];

                            if($_POST['password'] != ''){
                              $password = ", password='" . $_POST['password'] . "'";  
                            }else{
                              $password = "";  
                            }    

                            $connection = mysql_connect($db_host,$db_user,$db_password);
                            mysql_select_db($db_schema,$connection);

                            $query = "UPDATE users SET user_name='$user_name', full_name='$full_name', email='$email', city='$city', country='$country' $password WHERE id=$id";
                            $result = mysql_query($query,$connection);

                            if($result){
            ?>					
                <p class="done">El usuario ha sido editado <a href="profile.php">Ir al perfil</a></p>					
             <?php				
                            }else{
            ?>
                <p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
             <?php
                             }		
                              mysql_close($connection);
                   }
             ?>    
            </form>
        </div>
        <div id="footer">
            <h2>Footer</h2>
            <p>Curso: Software Bajo La Web y Programación Móvil. Uninorte  2013. Derechos reservados</p>
        </div>
    </div>
</body>
</html>