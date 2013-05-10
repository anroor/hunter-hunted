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
<meta name="title" content="HunterHunted Users Administrator" />
<meta name="description" content="Users Administrator of HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="none" />
<link rel="icon" type="image/png" href="../img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminStyle.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Users Administrator</title>
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
            <form method="post" enctype="application/x-www-form-urlencoded" name="users_list" id="users_list">
                <input type="submit" name="users_add" id="users_add" value="Agregar Usuario" />
                <input type="submit" name="users_activate" id="users_activate" value="Activar" />
                <input type="submit" name="users_deactivate" id="users_deactivate" value="Desactivar" />
                <input type="submit" name="users_delete" id="users_delete" value="Eliminar" />
                <?php
                if (isset($_POST['users_add'])){
                    header("Location: users_add.php"); 
                }
                ?>
                <?php
                if( isset($_POST['users_delete']) ){

                    $condition = "";

                    foreach($_POST as $key => $value){
                        if($key != 'users_delete') $condition.= "id=$value OR ";			
                    }

                    $condition.= "id=-1";

                    $connection = mysql_connect($db_host,$db_user,$db_password);
                    mysql_select_db($db_schema,$connection);

                    $query = "DELETE FROM users WHERE $condition";
                    $result = mysql_query($query,$connection);

                    if($result){
                ?>					
                        <p class="done">El(Los) usuario(s) ha(n) sido eliminado(s)</p>					
                <?php				
                    }else{
                ?>
                        <p class="error">Ha ocurrido un error <?php echo mysql_error($connection); ?></p>
                <?php
                    }
                    mysql_close($connection);
                }
                ?>
                        
                <?php
                $connection = mysql_connect($db_host,$db_user,$db_password);
                mysql_select_db($db_schema,$connection);

                $query = "SELECT id, status, user_name, full_name, email, city, country FROM users ORDER BY id";
                $result = mysql_query($query,$connection);

                $num_rows = mysql_num_rows($result);

                if($num_rows > 0){
                    ?>           
                    <table border="0" align="center" cellpadding="5" cellspacing="0" id="users_list">
                        <thead>
                            <tr>
                                <th width="16" scope="col">&nbsp;</th>
                                <th width="16" scope="col">&nbsp;</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Pais</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while( $row = mysql_fetch_array($result) ){
                                    ?>
                                    <tr class="item_list">
                                            <td width="16"><input type="checkbox" name="users<?php echo $row['id']; ?>" id="users<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" /></td>
                                            <td width="16">
                                                    <a href="users_edit.php?id=<?php echo $row['id']; ?>"><img src="../img/icon_edit.gif" width="16" height="16" /></a>
                                            </td>
                                            <td><?php echo $row['user_name']; ?></td>
                                            <td><?php echo $row['full_name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['city']; ?></td>
                                            <td><?php echo $row['country']; ?></td>
                                            <td><?php if ($row['status'] == 1){ ?>
                                                <img src="../img/status_on.png" />
                                            <?php }else{ ?>
                                                <img src="../img/status_off.png" />
                                            <?php } ?>
                                            </td>
                                    </tr>
                                    <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th width="16" scope="col">&nbsp;</th>
                                <th width="16" scope="col">&nbsp;</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Pais</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </tfoot>
                    </table>	
                    <?php
                }else{
                    ?>   
                    <p class="warning">No hay ningun usuario creado (<a href="users_add.php">Agregar usuario</a>).</p>
                    <?php
                }
                mysql_close($connection);
                ?>
            </form>
        </div>
        <div id="footer">
            <p>Curso: Software Bajo La Web y Programación Móvil. Uninorte 2013. Derechos reservados</p>
        </div>
    </div>
</body>
</html>