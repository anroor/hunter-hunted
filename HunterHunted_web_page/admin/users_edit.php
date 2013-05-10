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
<meta name="title" content="HunterHunted Edit Users" />
<meta name="description" content="Edit Users of HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="none" />
<link rel="icon" type="image/png" href="../img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminStyle.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Edit Users</title>
</head>
    
<body>
<div id="wrapper">
  <p>Bienvenido, <strong><?php echo $_SESSION['hh-full_name']; ?></strong>, (<a href="login.php" target="_self">Salir</a>)</p>
	<div id="header">
            <h1><a href="index.php" target="_self"><img src="../img/HunterHunted_Logo.png" /></a></h1>
	</div>
	<div id="navcontainer">
            <ul>
                <li><a href="index.php" target="_self">Inicio</a></li>
                <li><a href="users.php" target="_self" id="current">Usuarios</a></li>
                <li><a href="games.php" target="_self">Juegos</a></li>
            </ul>
	</div>
  <div id="content">
    <h2>Editar Usuario</h2>
<?php
	if( isset( $_POST['edit'] ) ){
		$id = $_GET['id'];
                $user_name= $_POST['user_name'];
		$full_name = $_POST['full_name'];
                $email = $_POST['email'];
                $city = $_POST['city'];
                $country = $_POST['country'];
    
                if($_POST['password'] != ''){
                  $password = ", password='" . md5($_POST['password']) . "'";  
                }else{
                  $password = "";  
                }    

		$connection = mysql_connect($db_host,$db_user,$db_password);
                mysql_select_db($db_schema,$connection);

		$query = "UPDATE users SET user_name='$user_name', full_name='$full_name', email='$email', city='$city', country='$country' $password WHERE id=$id";
		$result = mysql_query($query,$connection);

		if($result){
?>					
                    <p class="done">El usuario ha sido editado</p>					
 <?php				
                }else{
?>
                     <p class="error">Upss ha ocurrido un error <?php echo mysql_error($connection); ?></p>
 <?php
                 }		
                  mysql_close($connection);
       }
 ?>    
                     
            <?php
              if( isset( $_GET['id'] ) ){
                $id = $_GET['id'];

                $connection = mysql_connect($db_host,$db_user,$db_password);
                mysql_select_db($db_schema,$connection);

                $query = "SELECT user_name, full_name, email, city, country FROM users WHERE id=$id";
                $result = mysql_query($query,$connection);

                $row = mysql_fetch_array($result);

                $user_name= $row['user_name'];
		$full_name = $row['full_name'];
                $email = $row['email'];
                $city = $row['city'];
                $country = $row['country'];
                mysql_close($connection);
              }
            ?> 
        <form action="" method="post" enctype="application/x-www-form-urlencoded" name="users_edit" id="users_add">
          <p>
            <label for="user_name">Nombre de usuario:</label>
            <br />
            <input name="user_name" type="text" id="user_name" size="80" value="<?php echo $user_name; ?>" />
          </p>
          <p>
            <label for="full_name">Nombre Completo:</label>
            <br />
            <input name="full_name" type="text" id="full_name" size="80" value="<?php echo $full_name; ?>" />
          </p>
          <p>
            <label for="email">Correo electrónico:</label>
            <br />
            <input name="email" type="text" id="email" size="80" value="<?php echo $email; ?>" />
          </p>
          <p>
            <label for="password">Contraseña:</label>
            <br />
            <input name="password" type="password" id="password" size="80" />
          </p>
          <p>
            <label for="city">Ciudad:</label>
            <br />
            <input name="city" type="text" id="city" size="80" value="<?php echo $city; ?>"/>
          </p>
          <p>
            <label for="country">Pais:</label>
            <br />
            <input name="country" type="text" id="country" size="80" value="<?php echo $country; ?>"/>
          </p>
          <p>
            <label for="edit">&nbsp;</label>
            <input type="submit" name="edit" id="edit" value="Guardar"/>
          </p>
        </form>
  </div>
</div>
</body>
</html>