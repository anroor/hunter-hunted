<?php
session_start();
require_once("includes/configuration.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="title" content="HunterHunted Register Page" />
<meta name="description" content="Register HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="index, follow" />
<meta name="keywords" content="index, inicio, hunterhunted" />
<link rel="icon" type="image/png" href="img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="basic.css" rel="stylesheet" type="text/css" media="all" >
<link href='http://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
<title>HunterHunted Register Page</title>
</head>

<body>
<div id="wrapper">
        <div id="header">
            <h1><a href="index.php">HunterHunted</a></h1>
            <div id="register">
                <h2>Registro</h2>
                <ul>
                  <?php  if( isset( $_SESSION['hh-logged'] ) ){ ?>
                    <li><a href="profile.php">Ver mi perfil</a></li>
                    <li><a href="login.php">Cerrar Sesión</a></li>
                  <?php }else{ ?>
                  <li><form method="post" name="login_mini" target="_self" id="login">
                        <p>
                          <label for="user_name">Usuario:</label>
                          <input name="user_name" class="type_text_mini" type="text" />
                        </p>
                        <p>
                          <label for="password">Contraseña:</label>
                          <input name="password" class="type_text_mini" type="password"  maxlength="10"/>
                        </p>
                        <p><input type="submit" name="btn_login" class="btn_login_mini" value="Iniciar" /></p>
                         <?php
                        if( isset( $_POST['btn_login'] ) ){

                          $user_name = $_POST['user_name'];
                          $password = $_POST['password'];

                          $connection = mysql_connect($db_host,$db_user,$db_password);
                          mysql_select_db($db_schema,$connection);

                          $query = "SELECT id, full_name FROM users WHERE user_name='$user_name' and password='$password'";
                          $result = mysql_query($query,$connection);

                          $num_rows = mysql_num_rows($result);

                          if($num_rows > 0){

                            $row = mysql_fetch_array($result);

                            $_SESSION['hh-logged'] = true;
                            $_SESSION['hh-id'] = $row['id'];
                            $_SESSION['hh-full_name'] = $row['full_name'];

                            $query= "UPDATE users SET status = '1' WHERE id = '$row[id]'" ;
                            mysql_query($query,$connection);

                            mysql_close($connection);
                            header("Location: profile.php");

                          }else{ 
                              mysql_close($connection);
                            header("Location: login.php");
                            }
                            
                        }
                        ?>
                  </form></li>
                    <li><a href="#">Registrarse</a></li>
                  <?php } ?>
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
        <div id="center">
            <h2>Center</h2>
            <form id="user_register" method="post" name="user" enctype="application/x-www-form-urlencoded">
                <p>
                    <label for="full_name">Nombres:</label>
                    <br />
                    <input maxlength="40" name="full_name" type="text" />
                </p>
                <p>
                    <label for="user_name">Nombre de usuario:</label>
                    <br />
                    <input maxlength="20" name="user_name" type="text" />
                </p>
                <p>
                    <label for="password">Contraseña</label>
                    <br />
                    <input maxlength="10" name="password" type="password" />
                </p>
                <p>
                    <label for="email">Correo electrónico</label>
                    <br />
                    <input maxlength="45" name="email" type="email"/>
                </p>
                <p>
                    <label for="country">País</label>
                    <br />
                    <input maxlength="20" name="country" type="text" />
                </p>
                <p>
                    <label for="city">Ciudad</label>
                    <br />
                    <input maxlength="20" name="city" type="text" />
                </p>
                <p><input id="btn_add" name="add" type="submit" /></p>
                 <?php
                    if (isset($_POST['add'])){
                        
                        $user_name = $_POST['user_name'];
                        $password = $_POST['password'];
                        $full_name = $_POST['full_name'];
                        $email = $_POST['email'];
                        $country = $_POST['country'];
                        $city = $_POST['city'];
                        
                         $connection = mysql_connect($db_host,$db_user,$db_password);
                         mysql_select_db($db_schema,$connection);

                        $query = "INSERT INTO users(id,user_name,password,full_name,status,email,city,country)
                                 VALUES(NULL, '$user_name', '$password',  '$full_name', '0', '$email', '$city', '$country');";
                        $result = mysql_query($query,$connection);
                        
                        if ($result){
                            $query = "SELECT id FROM users WHERE user_name='$user_name'";
                            $result = mysql_query($query,$connection);
                            $row = mysql_fetch_array($result);
                            
                            $query = "INSERT INTO score(id, id_user, hunter_score, hunted_score, punctuation)
                                 VALUES(NULL, '{$row['id']}', 0, 0, 0)";
                            $result = mysql_query($query,$connection);
                            if ($result){
                                header("Location: profile.php");
                            }else{
                                ?>
                            <p class="error">Ha ocurrido un error <?php echo mysql_error($connection); ?></p>
                                <?php
                            }
                        }else{
                ?>
                            <p class="error">Ha ocurrido un error <?php echo mysql_error($connection); ?></p>
                <?php
                        }
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