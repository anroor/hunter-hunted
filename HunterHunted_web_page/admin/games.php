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
<meta name="title" content="HunterHunted Games Administrator" />
<meta name="description" content="Users Administrator of HunterHunted's Page" />
<meta name="Author" content="JoseG, AndresO, EduardoC, AndresJ" />
<meta http-equiv="content-language" content="es" />
<meta name="Robots" content="none" />
<link rel="icon" type="image/png" href="../img/HunterHunted_Min_Logo.png" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="adminStyle.css" rel="stylesheet" type="text/css" media="all" >
<title>HunterHunted Games Administrator</title>
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
            <form method="post" enctype="application/x-www-form-urlencoded" name="users_list" id="users_list">
                <input type="submit" name="tournament_add" id="tournament_add" value="Agregar Torneo" />
                <input type="submit" name="match_add" id="match_add" value="Agregar Partido" />
                <input type="submit" name="games_delete" id="games_delete" value="Eliminar" />
                <p>
                    <input type="submit" name="tournaments_view" class="views" value="Torneos" />
                    /
                    <input type="submit" name="matchs_view" class="views" value="Partidas" />
                </p>
                <?php
                if (isset($_POST['tournament_add'])){
                    header("Location: games_tournament_add.php"); 
                }
                ?>
                <?php
                if (isset($_POST['match_add'])){
                    header("Location: games_match_add.php"); 
                }
                ?>   
                        
                <?php
                if (isset($_POST['tournaments_view'])){
                    $connection = mysql_connect($db_host,$db_user,$db_password);
                    mysql_select_db($db_schema,$connection);

                    $query = "SELECT id, title_tournament, initial_time, finish_time, count_players, count_matchs, date_created, id_user_winner_tournament FROM tournaments ORDER BY date_created";
                    $result = mysql_query($query,$connection);
                    $num_rows = mysql_num_rows($result);
                    
                    if($num_rows > 0){
                        ?>
                        <table border="0" align="center" cellpadding="5" cellspacing="0" id="users_list">
                            <thead>
                                <tr>
                                    <th width="16" scope="col">&nbsp;</th>
                                    <th width="16" scope="col">&nbsp;</th>
                                    <th scope="col">Nombre del Torneo</th>
                                    <th scope="col">Inicio torneo</th>
                                    <th scope="col">Fin torneo</th>
                                    <th scope="col">Cantidad jugadores</th>
                                    <th scope="col">Cantidad partidos</th>
                                    <th scope="col">id ganador del torneo</th>
                                    <th scope="col">Fecha de creacion</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            while( $row = mysql_fetch_array($result) ){
                            ?>
                                <tr class="item_list">
                                        <td width="16"><input type="checkbox" name="match<?php echo $row['id']; ?>" id="match<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" /></td>
                                        <td width="16">
                                                <a href="tournaments_edit.php?id=<?php echo $row['id']; ?>"><img src="../img/icon_edit.gif" width="16" height="16" /></a>
                                        </td>
                                        <td><?php echo $row['title_tournament']; ?></td>
                                        <td><?php echo $row['initial_time']; ?></td>
                                        <td><?php echo $row['finish_time']; ?></td>
                                        <td><?php echo $row['count_players']; ?></td>
                                        <td><?php echo $row['count_matchs']; ?></td>
                                        <td><?php echo $row['id_user_winner_tournament']; ?></td>
                                        <td><?php echo $row['date_created']; ?></td>
                                        <td width="16">
                                                <a href="games_match_add.php?id=<?php echo $row['id']; ?>"><img src="../img/icon_add.png" width="16" height="16" /></a>
                                        </td>
                                        <td width="16">
                                            <input type="image" src="../img/icon_find.png" name="tournaments_matchs_view" class="views" value="<?php echo $row['id']; ?>"
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
                                    <th scope="col">Nombre del Torneo</th>
                                    <th scope="col">Inicio torneo</th>
                                    <th scope="col">Fin torneo</th>
                                    <th scope="col">Cantidad jugadores</th>
                                    <th scope="col">Cantidad partidos</th>
                                    <th scope="col">id ganador del torneo</th>
                                    <th scope="col">Fecha de creacion</th>
                                </tr>
                            </tfoot>
                        </table>	
                        <?php
                    }else{
                        ?>   
                        <p class="warning">No hay ningun juego creado (<a href="games_match_add.php">Agregar Torneo</a>).</p>
                        <?php
                    }
                    $_SESSION['table']='tournaments';
                }
                    
                ?>
                        
                <?php
                if (isset($_POST['matchs_view']) || isset($_POST['tournaments_matchs_view'])){
                    $connection = mysql_connect($db_host,$db_user,$db_password);
                    mysql_select_db($db_schema,$connection);
                    $query = "SELECT id, match_name, tournament_match, count_players, time, id_user_winner_match, tournament_id, date_created FROM matchs";
                    if (isset($_POST['tournaments_matchs_view'])){
                        $query .= " WHERE tournament_id={$_POST['tournaments_matchs_view']}";
                    }
                    $query .= " ORDER BY date_Created";
                    $result = mysql_query($query,$connection);
                    $num_rows = mysql_num_rows($result);

                    if($num_rows > 0){
                        ?>
                        <table border="0" align="center" cellpadding="5" cellspacing="0" id="users_list">
                            <thead>
                                <tr>
                                    <th width="16" scope="col">&nbsp;</th>
                                    <th width="16" scope="col">&nbsp;</th>
                                    <th scope="col">Nombre del juego</th>
                                    <th scope="col">Cantidad jugadores</th>
                                    <th scope="col">Tiempo</th>
                                    <th scope="col">Tipo de juego</th>
                                    <th scope="col">Ganador</th>
                                    <th scope="col">Fecha de creacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while( $row = mysql_fetch_array($result) ){
                                        ?>
                                        <tr class="item_list">
                                                <td width="16"><input type="checkbox" name="match<?php echo $row['id']; ?>" id="match<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" /></td>
                                                <td width="16">
                                                        <a href="games_edit.php?id=<?php echo $row['id']; ?>"><img src="../img/icon_edit.gif" width="16" height="16" /></a>
                                                </td>
                                                <td><?php echo $row['match_name']; ?></td>
                                                <td><?php echo $row['count_players']; ?></td>
                                                <td><?php echo $row['time']; ?></td>
                                                <td><?php if ($row['tournament_match'] == 1){ 
                                                    echo 'Torneo';
                                                }else{
                                                    echo 'Amistoso';
                                                }
                                                    ?>
                                                </td>
                                                <td><?php echo $row['id_user_winner_match']; ?></td>
                                                <td><?php echo $row['date_created']; ?></td>
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
                        <p class="warning">No hay ningun juego creado 
                            <?php
                                if (isset($_POST['tournaments_matchs_view'])){
                                    $id = "?id={$_POST['tournaments_matchs_view']}";
                                }else{
                                    $id = "";
                                }
                            ?>
                            (<a href="games_match_add.php<?php echo $id; ?>">Agregar juego</a>).</p>
                                    
                        <?php
                    }
                    $_SESSION['table']='matchs';
                }
                ?>
                        <?php
                if( isset($_POST['games_delete']) ){

                    $condition = "";

                    foreach($_POST as $key => $value){
                        if($key != 'games_delete') $condition.= "id=$value OR ";			
                    }

                    $condition.= "id=-1";

                    $connection = mysql_connect($db_host,$db_user,$db_password);
                    mysql_select_db($db_schema,$connection);
                    global $table;
                    $query = "DELETE FROM {$_SESSION['table']} WHERE $condition";
                    $result = mysql_query($query,$connection);

                    if($result){
                ?>					
                        <p class="done">El(Los) juegos(s) ha(n) sido eliminado(s)</p>					
                <?php				
                    }else{
                ?>
                        <p class="error">Ha ocurrido un error <?php echo mysql_error($connection); ?></p>
                <?php
                    }
                    mysql_close($connection);
                }
                ?>
                        
            </form>
        </div>
        <div id="footer">
            <p>Curso: Software Bajo La Web y Programación Móvil. Uninorte 2013. Derechos reservados</p>
        </div>
    </div>
</body>
</html>