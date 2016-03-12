<?php

    $ids = array(394,398,399,405,424);
    $uri = 'http://api.football-data.org/v1/soccerseasons/424/teams';
    $reqPrefs['http']['method'] = 'GET';
    $reqPrefs['http']['header'] = 'X-Auth-Token: 016964b6762c410897807ec69e7bf0a3';
    $stream_context = stream_context_create($reqPrefs);
    $response = file_get_contents($uri, false, $stream_context);
    $fixtures = json_decode($response,true);
    
    $conn = mysql_connect("my-db-instance.csskrjecvpsd.us-west-2.rds.amazonaws.com","football","sandhida123") or die("could not connect to database");
    mysql_select_db("football_fixture") or die("could not select db");
    $sql = "INSERT INTO  `football_fixture`.`teams` (`id` ,`name` ,`short_name` ,`code` ,`logo` ,`league_id` ,`position` ,`api_id`) VALUES ";
    $insert_array = array();
    foreach($fixtures['teams'] as $key => $row){
		$a = explode("/",$row['_links']['self']['href']);
		echo $a[count($a)-1]."\n";
		$insert_array[] = "(NULL,'".mysql_real_escape_string($row['name'])."',
							'".mysql_real_escape_string($row['shortName'])."',
							'".mysql_real_escape_string($row['code'])."',
							'".mysql_real_escape_string($row['crestUrl'])."','424','0','".$a[count($a)-1]."')";
	}
	$sql .= implode(",",$insert_array);
	echo $sql;
	mysql_query($sql) or die(mysql_error());
	mysql_close($conn);
	echo $sql;
?>
