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
<meta name="title" content="HunterHunted Edit Tournaments Match" />
<meta name="description" content="Edit Tournaments of HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="none" />
<link rel="icon" type="image/png" href="../img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminStyle.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Edit Tournaments</title>
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
                <li><a href="users.php" target="_self">Usuarios</a></li>
                <li><a href="games.php" target="_self" id="current">Juegos</a></li>
            </ul>
	</div>
  <div id="content">
    <h2>Editar Torneo</h2>
<?php
	if( isset( $_POST['edit'] ) ){
		$id = $_GET['id'];
                $title_tournament= $_POST['title_tournament'];
		$count_players = $_POST['count_players'];
                $user_winner_tournament = $_POST['user_winner_tournament'];
    
		$connection = mysql_connect($db_host,$db_user,$db_password);
                mysql_select_db($db_schema,$connection);

                if ($_POST['user_winner_tournament'] != ''){
                    $query = "SELECT id FROM users WHERE user_name='$user_winner_tournament'";
                    $result = mysql_query($query, $connection);
                    $row =  mysql_fetch_array($result);
                    $id_user_winner_tournament = $row['id'];
                }else{
                    $id_user_winner_tournament = "NULL";
                }
                
		$query = "UPDATE tournaments SET title_tournament='$title_tournament', count_players='$count_players', id_user_winner_tournament='$id_user_winner_tournament' WHERE id=$id";
		$result = mysql_query($query,$connection);

		if($result){
?>					
                    <p class="done">El Torneo ha sido editado</p>					
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

                $query = "SELECT title_tournament, count_players, id_user_winner_tournament FROM tournaments WHERE id=$id";
                $result = mysql_query($query,$connection);
                $row = mysql_fetch_array($result);

                $title_tournament= $row['title_tournament'];
		$count_players = $row['count_players'];
                $id_user_winner_tournament=$row['id_user_winner_tournament'];
                
                $query = "SELECT user_name FROM users WHERE id=$id_user_winner_tournament";
                $result = mysql_query($query, $connection);
                $row =  mysql_fetch_array($result);
                $user_winner_tournament = $row['user_name'];
                
                mysql_close($connection);
              }
            ?> 
        <form action="" method="post" enctype="application/x-www-form-urlencoded" name="users_edit" id="users_add">
          <p>
            <label for="title_tournament">Nombre del partido:</label>
            <br />
            <input name="title_tournament" type="text" id="title_tournament" size="80" value="<?php echo $title_tournament; ?>" />
          </p>
          <p>
            <label for="count_players">Numero de jugadores</label>
            <br />
            <input name="count_players" type="number" id="count_players" size="80" value="<?php echo $count_players; ?>" />
          </p>
          <p>
            <label for="user_winner_tournament">Nombre de usuario ganador</label>
            <br />
            <input name="user_winner_tournament" type="text" id="user_winner_tournament" size="80" value="<?php echo $user_winner_tournament; ?>"/>
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