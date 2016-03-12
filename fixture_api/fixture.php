<?php
    
    $ids = array(394,398,399,405,424);
    $league_id = 424;
    $match_days = array("394" => 34 , "398" => 38, "399" => 38,"405" => 10 , "424" => 6);
    
    $conn = mysql_connect("my-db-instance.csskrjecvpsd.us-west-2.rds.amazonaws.com","football","sandhida123") or die("could not connect to database");
    mysql_select_db("football_fixture") or die("could not select db");
    
    $sql = "SELECT `id`,`api_id` FROM `teams` WHERE `league_id` = $league_id";
	$result = mysql_query($sql);
	$orig_mapping = array();
	while($row = mysql_fetch_assoc($result)){
		$orig_mapping[$row['api_id']] = $row['id'];
	}
	
	for($i = 1; $i <= $match_days[$league_id]; $i++ ){
		echo $i."\n";
		$uri = "http://api.football-data.org/v1/soccerseasons/$league_id/fixtures?matchday=$i";
		$reqPrefs['http']['method'] = 'GET';
		$reqPrefs['http']['header'] = 'X-Auth-Token: 016964b6762c410897807ec69e7bf0a3';
		$stream_context = stream_context_create($reqPrefs);
		$response = file_get_contents($uri, false, $stream_context);
		$fixtures = json_decode($response,true);
		//echo print_r($fixtures,true);
		
		$sql_array = array();
		$sql = "INSERT INTO `football_fixture`.`fixtures` (`id`,`l_id`,`home_id`,`away_id`,`match_date`,`goals_home_team`,`goals_away_team`,`status`) VALUES";
		foreach($fixtures['fixtures'] as $row){
			$a = explode("/",$row['_links']['homeTeam']['href']);
			$b = explode("/",$row['_links']['awayTeam']['href']);
			$home_id = $a[count($a)-1];
			$away_id = $b[count($b)-1];
			$date = date_create($row['date']);
			$match_date = date_format($date, 'Y-m-d H:i:s');
			$sql_array[] = "(NULL,$league_id,$orig_mapping[$home_id],$orig_mapping[$away_id],'".$match_date."','".$row['result']['goalsHomeTeam']."','".$row['result']['goalsAwayTeam']."','".$row['status']."')";
		}
		$sql .= implode(",",$sql_array);
		$sql .= "ON DUPLICATE KEY UPDATE `goals_home_team` = VALUES(`goals_home_team`) ,`goals_away_team` = VALUES(`goals_away_team`) , `status` = VALUES(`status`)";
		echo $sql;
		mysql_query($sql) or die(mysql_error());
	}
	mysql_close();
?>
