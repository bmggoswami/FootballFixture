<?php
	$ids = array(394,398,399);
	$league_id = 399;
    $uri = "http://api.football-data.org/v1/soccerseasons/$league_id/leagueTable";
    $reqPrefs['http']['method'] = 'GET';
    $reqPrefs['http']['header'] = 'X-Auth-Token: 016964b6762c410897807ec69e7bf0a3';
    $stream_context = stream_context_create($reqPrefs);
    $response = file_get_contents($uri, false, $stream_context);
    $fixtures = json_decode($response,true);
    
    $conn = mysql_connect("my-db-instance.csskrjecvpsd.us-west-2.rds.amazonaws.com","football","sandhida123") or die("could not connect to database");
    mysql_select_db("football_fixture") or die("could not select db");
    
    $sql = "SELECT `id`,`api_id` FROM `teams` WHERE `league_id` = $league_id";
	$result = mysql_query($sql);
	$orig_mapping = array();
	while($row = mysql_fetch_assoc($result)){
		$orig_mapping[$row['api_id']] = $row['id'];
	}
	$sql = "INSERT INTO `football_fixture`.`league_table` (`id`,`l_id`,`t_id`,`played`,`wins`,`draws`,`losses`,`goal_for`,`goal_against`,`goal_diff`,`points`) VALUES";
	$sql_array = array();
	foreach($fixtures['standing'] as $row){
		echo print_r($row,true);
		$a = explode("/",$row['_links']['team']['href']);
		$team_id = $orig_mapping[$a[count($a)-1]];
		$sql_array[] = "(NULL,$league_id,$team_id,'".$row['playedGames']."','".$row['wins']."','".$row['draws']."','".$row['losses']."','".$row['goals']."','".$row['goalsAgainst']."','".$row['goalDifference']."','".$row['points']."')";
	}
	$sql .= implode(",",$sql_array);
	$sql .= "ON DUPLICATE KEY UPDATE `played` = VALUES(`played`), `wins` = VALUES(`wins`), `draws` = VALUES(`draws`),`losses`=VALUES(`losses`),`goal_for` = VALUES(`goal_for`),`goal_against`=VALUES(`goal_against`),`goal_diff` = VALUES(`goal_diff`),`points` = VALUES(`points`)";
	mysql_query($sql) or die(mysql_error());
	mysql_close($conn);
	echo $sql;
?>
