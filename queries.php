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
	cd.Humanity
FROM
	Character_DATA cd 
LEFT JOIN
	Player_DATA pd
ON
	pd.playerUID = cd.PlayerUID
WHERE
	InstanceID = " . $iid . "
";

$leaderboard_query_dead = "
SELECT 
	cd.distanceFoot,
	cd.duration
FROM 
	Character_DEAD cd
WHERE
	InstanceID = " . $iid ." 
AND 
	playerUID = ?
";

// Search
$search_query_player = "
SELECT
	pd.playerName,
	pd.playerUID,
	cd.*
FROM
	Player_DATA pd
JOIN
	Character_DATA cd
ON
	cd.PlayerUID = pd.playerUID
WHERE
	cd.Alive = 1
AND
    pd.playerName LIKE ?
";

//Info	
$info1 = array("
SELECT 
	Player_DATA.playerName as name,
	Player_DATA.playerUID as uid,
	Character_DATA.playerUID as unique_id,
	Character_DATA.Worldspace as worldspace,
	Character_DATA.Inventory as inventory,
	Character_DATA.Backpack as backpack,
	Character_DATA.Model as model,
	Character_DATA.Alive,
	Character_DATA.Medical as medical,
	Character_DATA.distanceFoot as DistanceFoot,
	Character_DATA.duration as survival_time,
	Character_DATA.last_updated as last_updated,
	Character_DATA.KillsZ as zombie_kills,
	Character_DATA.KillsZ as total_zombie_kills,
	Character_DATA.HeadshotsZ as headshots,
	Character_DATA.HeadshotsZ as total_headshots,
	Character_DATA.KillsH as survivor_kills,
	Character_DATA.KillsH as total_survivor_kills,
	Character_DATA.KillsB as bandit_kills,
	Character_DATA.KillsB as total_bandit_kills,
	Character_DATA.Generation as survival_attempts,
	Character_DATA.duration as survival_time,
	Character_DATA.distanceFoot as distance,
	Character_DATA.Humanity as humanity
FROM
	Player_DATA, 
	Character_DATA 
WHERE
	Character_DATA.playerUID = Player_DATA.playerUID
AND
	Character_DATA.Alive = '1' and Player_DATA.PlayerUID like ?", array($_GET["id"])); 

?>
