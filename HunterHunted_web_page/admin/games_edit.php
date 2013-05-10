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
<meta name="title" content="HunterHunted Edit Games Match" />
<meta name="description" content="Edit Games Match of HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="none" />
<link rel="icon" type="image/png" href="../img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminStyle.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Edit Games Match</title>
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
    <h2>Editar juego</h2>
<?php
	if( isset( $_POST['edit'] ) ){
		$id = $_GET['id'];
                $match_name= $_POST['match_name'];
		$count_players = $_POST['count_players'];
                $time = $_POST['time'];
                $user_winner_match = $_POST['user_winner_match'];
    
		$connection = mysql_connect($db_host,$db_user,$db_password);
                mysql_select_db($db_schema,$connection);

                if ($_POST['user_winner_match'] != ''){
                    $query = "SELECT id FROM users WHERE user_name='$user_winner_match'";
                    $result = mysql_query($query, $connection);
                    $row =  mysql_fetch_array($result);
                    $id_user_winner_match = $row['id'];
                }else{
                    $id_user_winner_match = "NULL";
                }
                
		$query = "UPDATE matchs SET match_name='$match_name', count_players='$count_players', time='$time', id_user_winner_match='$id_user_winner_match' WHERE id=$id";
		$result = mysql_query($query,$connection);

		if($result){
?>					
                    <p class="done">El juego ha sido editado</p>					
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

                $query = "SELECT match_name, count_players, time, id_user_winner_match FROM matchs WHERE id=$id";
                $result = mysql_query($query,$connection);
                $row = mysql_fetch_array($result);

                $match_name= $row['match_name'];
		$count_players = $row['count_players'];
                $time = $row['time'];
                $id_user_winner_match=$row['id_user_winner_match'];
                
                $query = "SELECT user_name FROM users WHERE id=$id_user_winner_match";
                $result = mysql_query($query, $connection);
                $row =  mysql_fetch_array($result);
                $user_winner_match = $row['user_name'];
                
                mysql_close($connection);
              }
            ?> 
        <form action="" method="post" enctype="application/x-www-form-urlencoded" name="users_edit" id="users_add">
          <p>
            <label for="match_name">Nombre del partido:</label>
            <br />
            <input name="match_name" type="text" id="match_name" size="80" value="<?php echo $match_name; ?>" />
          </p>
          <p>
            <label for="count_players">Numero de jugadores</label>
            <br />
            <input name="count_players" type="number" id="count_players" size="80" value="<?php echo $count_players; ?>" />
          </p>
          <p>
                <label for="time">Limite de tiempo</label>
                <br />
                <select name="time" id="time" >
                    <option value="00:03:00">3 Minutos</option>
                    <option value="00:05:00">5 Minutos</option>
                    <option value="00:10:00">10 Minutos</option>
                    <option value="00:20:00">20 Minutos</option>
                </select>
          </p>
          <p>
            <label for="user_winner_match">Nombre de usuario ganador</label>
            <br />
            <input name="user_winner_match" type="text" id="user_winner_match" size="80" value="<?php echo $user_winner_match; ?>"/>
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