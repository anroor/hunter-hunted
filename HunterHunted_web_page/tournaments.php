<?php
session_start();
require_once("includes/configuration.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="title" content="HunterHunted Tournaments Page" />
<meta name="description" content="Index HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="index, follow" />
<meta name="keywords" content="tournaments, torneos, hunterhunted" />
<link rel="icon" type="image/png" href="img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="basic.css" rel="stylesheet" type="text/css" media="all" >
<link href='http://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
<title>HunterHunted Tournaments Page</title>
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
                    <li><a href="register.php">Registrarse</a></li>
                  <?php } ?>
                </ul>
            </div>
            <div id="nav">
                <h2>Sections</h2>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="history.php">Historia del juego</a></li>
                    <li><a href="rules.php">Reglas</a></li>
                    <li class="current"><a class="current" href="#">Torneos</a></li>
                    <li><a href="statistics.php">Estadísticas</a></li>
                </ul>
            </div>
        </div>
        <div id="center" class="separating">
            <h2>Center</h2>
            <div>
            <h3>Torneos</h3>
             <?php
                $connection = mysql_connect($db_host,$db_user,$db_password);
                mysql_select_db($db_schema,$connection);

                $query = "SELECT id, title_tournament, finish_time, id_user_winner_tournament, date_created FROM tournaments ORDER BY date_created DESC";
                $result = mysql_query($query,$connection);
                $num_rows = mysql_num_rows($result);

                if($num_rows > 0){
            ?>
            <table border="1" align="center" cellpadding="5" cellspacing="0" class="table">
              <tr>
                <th width="16" scope="col"><p>&nbsp;</p></th>
                <th scope="col"><p>Nombre</p></th>
                <th scope="col"><p>Fecha de cierre</p></th>
                <th scope="col"><p>Ganador del torneo</p></th>
              </tr>
            <?php
                    $i=0;
                    while( $row = mysql_fetch_array($result) ){
                        if ($row['id_user_winner_tournament']!= '' && $row['id_user_winner_tournament']!= null && $row['id_user_winner_tournament']!= 0){
                            $queryid = "SELECT user_name FROM users WHERE id={$row['id_user_winner_tournament']}";
                            $resultid = mysql_query($queryid,$connection);
                            $rowid = mysql_fetch_array($resultid);
                            $user_name= $rowid['user_name'];
                        }else{
                            $user_name='Por determinar';
                        }
                        $i++;
             ?>          
              <tr>
                <td width="16"><p><?php echo $i; ?></p></td>
                <td><p><?php echo $row['title_tournament']; ?></p></td>
                <td><p><?php echo $row['finish_time']; ?></p></td>
                <td><p><?php echo $user_name; ?></p></td>
              </tr>
            <?php
                    }
            ?>
            </table>
            <?php
                }else{
            ?>
            <p class="warning">No hay torneos que mostrar</p>
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