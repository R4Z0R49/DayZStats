<?php
include ('config.php');

// Stats
$stats_totalAlive = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1";
$stats_totalplayers = "SELECT COUNT(*) FROM Player_DATA";
$stats_deaths = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 0";
$stats_alivebandits = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1 AND Humanity < -2000";
$stats_aliveheros = "SELECT COUNT(*) FROM Character_DATA WHERE Alive = 1 AND Humanity > 5000";
$stats_totalVehicles = array("SELECT COUNT(*) FROM Object_DATA WHERE Instance = ? AND CharacterID = '0'", $iid);
$stats_Played24h = "SELECT COUNT(*) FROM (SELECT COUNT(*) FROM Character_DATA WHERE LastLogin > NOW() - INTERVAL 1 DAY GROUP BY PlayerUID) uniqueplayers";
$stats_totalkills = "SELECT * FROM Character_DATA";

if($_GET['board'] != NULL){
	$rs = $db->GetAll("SELECT * FROM dayzstats_boards WHERE id = ?", array($_GET['board']));
	$board_pids = array();
	foreach($rs as $boardrow){
		$board_pids = $boardrow['pids'];
	}
}

// Leaderboard
$leaderboard_query = "
SELECT
	pd.playerName,
	pd.playerUID,
    cd.CharacterID,
	cd.Generation,
	cd.KillsZ,
	cd.KillsB,
	cd.KillsH,
	cd.HeadshotsZ,
	cd.Humanity,
	cd.distanceFoot,
	cd.duration
FROM
	Character_DATA cd 
LEFT JOIN
	Player_DATA pd
ON
	pd.playerUID = cd.PlayerUID
WHERE
	InstanceID = " . $iid . "
AND 
	Alive like 1
";

// Search
$search_query_player = "
SELECT
	pd.playerName,
	pd.playerUID,
	cd.playerUID,
	cd.CharacterID
FROM
	Character_DATA cd
JOIN
	Player_DATA pd
ON
	cd.PlayerUID = pd.playerUID
WHERE
	cd.Alive = 1
AND
    pd.playerName LIKE ?
";

//Info	
$info1 = "
SELECT
    pd.playerName,
    pd.playerUID,
    pd.playerSex,
    cd.*
FROM
    Character_DATA cd
JOIN
    Player_DATA pd
ON
    cd.playerUID = pd.playerUID
WHERE
    cd.CharacterID = ?
";

//Register & Login
$register = "
INSERT INTO 
	dayzstats (`pid`, `login`, `password`, `salt`)
VALUES
	(?, ?, ?, ?)
";

$login_query = "
SELECT 
	*
FROM
	dayzstats
WHERE
	login = ?
";

//Challenge
$challenge_query = "
INSERT INTO
	dayzstats_boards (`owner_userid`, `name`, `pids`)
VALUES
	(?, ?, ?)
";

$challenge_leaderboard_query = "
SELECT
	pd.playerName,
	pd.playerUID,
    cd.CharacterID,
	cd.Generation,
	cd.KillsZ,
	cd.KillsB,
	cd.KillsH,
	cd.HeadshotsZ,
	cd.Humanity,
	cd.distanceFoot,
	cd.duration
FROM
	Character_DATA cd 
LEFT JOIN
	Player_DATA pd
ON
	pd.playerUID = cd.PlayerUID
LEFT JOIN
	dayzstats_boards db
ON
	db.id = ?
WHERE
	InstanceID = " . $iid . "
AND 
	Alive like 1
AND
	pd.playerUID IN($board_pids)
";

?>
