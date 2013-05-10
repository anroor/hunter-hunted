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
<meta name="title" content="HunterHunted Add Tournament" />
<meta name="description" content="Add Tournament of HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="none" />
<link rel="icon" type="image/png" href="../img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminStyle.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Add Tournaments</title>
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
            <h2>Agregar Torneo</h2>
            <form method="post" enctype="application/x-www-form-urlencoded" name="tournament_add" id="tournament_add" >
                <p>
                    <label for="title_tournament">Nombre Del Torneo</label>
                    <br />
                    <input name="title_tournament" id="title_tournament" type="text" />
                </p>
                <p>
                    <label for="count_players">Numero de jugadores</label>
                    <br />
                    <input name="count_players" id="count_players" type="number" min="3" value="3"/>
                </p>          
                <p>
                    <label for="user_winner_tournament">Nombre de usuario ganador</label>
                    <br />
                    <input name="user_winner_tournament" id="user_winner_tournament" type="text" />
                </p>
                <p><input type="submit" name="btn_add" id="btn_add" value="Agregar" /></p>
                
                <?php
                    if (isset($_POST['btn_add'])){
                        
                        if($_POST['title_tournament'] != ''){
                            $title_tournamentV = ", title_tournament";
                            $title_tournament = ", '" . $_POST['title_tournament']  . "'";  
                        }else{
                            $title_tournamentV = "";
                            $title_tournament  = "";  
                        }    
                        $count_players = $_POST['count_players'];
                        $created = date("Y-m-d H:i:s");
                        
                         $connection = mysql_connect($db_host,$db_user,$db_password);
                         mysql_select_db($db_schema,$connection);

                         if ($_POST['user_winner_tournament'] != ''){
                             $query = "SELECT id FROM users WHERE user_name='{$_POST['user_winner_tournament']}'";
                             $result = mysql_query($query, $connection);
                             $row =  mysql_fetch_array($result);
                             $id_user_winner_tournament = $row['id'];
                         }else{
                             $id_user_winner_tournament = "NULL";
                         }
                                                 
                        $query = "INSERT INTO tournaments (id, initial_time, finish_time, count_players, count_matchs, id_user_winner_tournament, date_created  $title_tournamentV)
                                 VALUES(NULL, NULL,  NULL, $count_players, NULL, $id_user_winner_tournament, '$created' $title_tournament);";
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