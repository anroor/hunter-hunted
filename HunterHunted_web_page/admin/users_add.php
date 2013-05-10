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
<meta name="title" content="HunterHunted Add Users" />
<meta name="description" content="Add Users of HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="none" />
<link rel="icon" type="image/png" href="../img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminStyle.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Add Users</title>
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
            <h2>Agregar Usuario</h2>
            <form method="post" enctype="application/x-www-form-urlencoded" name="users_add" id="users_add" >
                <p>
                    <label for="full_name">Nombre Completo</label>
                    <br />
                    <input name="full_name" id="full_name" type="text" />
                </p>
                <p>
                    <label for="email">Correo Eletronico</label>
                    <br />
                    <input name="email" id="email" type="text" />
                </p>
                <p>
                    <label for="user_name">Nombre de Usuario</label>
                    <br />
                    <input name="user_name" id="user_name" type="text" />
                </p>
                <p>
                    <label for="password">Contraseña</label>
                    <br />
                    <input name="password" id="password" type="password" />
                </p>
                <p>
                    <label for="country">Pais</label>
                    <br />
                    <input name="country" id="country" type="text" />
                </p>
                <p>
                    <label for="city">Ciudad</label>
                    <br />
                    <input name="city" id="city" type="text" />
                </p>
                <p><input type="submit" name="btn_add" id="btn_add" value="Agregar" /></p>
                
                <?php
                    if (isset($_POST['btn_add'])){
                        
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
                 ?>
                            <p class="done">El usuario ha sido agregado</p>
                <?php
                        }else{
                ?>
                            <p class="error">Ha ocurrido un error <?php echo mysql_error($connection); ?></p>
                <?php
                        }
                    }
                ?>
                
            </form>
        </div>
    </div>
</body>
</html>