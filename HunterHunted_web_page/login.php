<?php
session_start();
require_once("includes/configuration.php");
?>
<?php
if( isset( $_SESSION['hh-logged'] ) ){
    $connection = mysql_connect($db_host,$db_user,$db_password);
    mysql_select_db($db_schema,$connection);

    $query = "UPDATE users SET status = '0' WHERE id = '{$_SESSION['hh-id']}'" ;
    mysql_query($query,$connection);
     
    session_destroy();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="title" content="HunterHunted Login" />
<meta name="description" content="Login HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="index, follow" />
<meta name="keywords" content="login, inicio de sesion, hunterhunted, user, users" />
<link rel="icon" type="image/png" href="img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="basic.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Login</title>
</head>

<body>
<div id="wrapperL">
    <div id="loggin">
        <form method="post" name="login" target="_self" id="login">
            <p><a href="index.php"><img src="img/HunterHunted_Logo.png" width="400" height="200" /></a></p>
            <p>
              <label for="user_name">Nombre de usuario:</label>
              <br />
              <input name="user_name" id="user_name" type="text" />
            </p>
            <p>
              <label for="password">Contraseña:</label>
              <br />
              <input name="password" id="password" type="password"  maxlength="10"/>
            </p>
            <p><input type="submit" name="btn_login" id="btn_login" value="Iniciar sesion" /></p>
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

                  }else{    mysql_close($connection); ?>
                    <p class="error">No se pudo iniciar sesión. Compruebe que el Nombre de usuario y contraseña  sean los correctos </p>
                <?php
                  }
                }
                ?>
        </form>
        <p>No eres usuario? Registrate haciendo <a href="register.php">click aqui</a></p>
    </div>
</div>
</body>
</html>