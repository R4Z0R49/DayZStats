<?php
	$userid = $_SESSION['user_id'];
	if(isset($_POST['board_create'])){
		if($_POST['board_name'] == NULL){
			$message->add('danger', 'No name specified!');
		} elseif($_POST['board_pids'] == NULL){
			$message->add('danger', 'No PlayerIDs specified!');
		} elseif(strpos($_POST['board_pids'], ", ") !== FALSE) { 
			$message->add('danger', 'Do not use spaces inbetween your playerIDs!');
		} else {
			$pids = explode(",",$_POST['board_pids']);
			$pids = "'" . implode("','", $pids) . "'";
			$message->add('success', 'Leaderboard successfully created. You can edit it in the "Modify Board" tab!');
			$db->execute($challenge_query, array($userid, $_POST['board_name'], $pids));
		}
	}

	if(isset($_POST['board_modify'])){
		if($_POST['board_removepid'] != 'Remove PlayerID'){
			$modify_rpid = $_GET['board_removepid'];
			$rs_rpid = $db->GetAll("SELECT * FROM dayzstats_boards WHERE id = ?", $_GET['modify']);
			foreach($rs_rpid as $rpidr){
				$pids = explode( ',', $rpidr['pids'] );
				$c = count($pids)-1;
				if("'".$_POST['board_removepid']."'" == $pids[0] && $c == 0){
					$pids = str_replace("'".$_POST['board_removepid']."'", "", $rpidr['pids']);
				} elseif("'".$_POST['board_removepid']."'" == $pids[0]){
					$pids = str_replace("'".$_POST['board_removepid']."',", "", $rpidr['pids']);
				} elseif("'".$_POST['board_removepid']."'" == $pids[$c]){
					$pids = str_replace(",'".$_POST['board_removepid']."'", "", $rpidr['pids']);
				} else{
					$pids = str_replace("'".$_POST['board_removepid']."',", "", $rpidr['pids']);
				}
				$db->execute("UPDATE dayzstats_boards SET pids = ? WHERE id = ?", array($pids, $_GET['modify']));
				$message->add('success', 'Player successfully removed!');
			}
		}
		if($_POST['board_addpid'] != NULL){
			$rs = $db->GetAll("SELECT pids FROM dayzstats_boards WHERE id = ?", $_GET['modify']);
			foreach($rs as $pidsr){
				$pids = $pidsr['pids'];
			}
			$pids = $pids . ",'" . $_POST['board_addpid'] . "'";
			$db->execute("UPDATE dayzstats_boards SET pids = ? WHERE id = ?", array($pids, $_GET['modify']));
			$message->add('success', 'Player successfully added!');
		}
	}
	if(isset($_POST['board_delete'])){
		$db->execute("DELETE FROM dayzstats_boards WHERE id = ?", $_GET['modify']);
		$message->add('success', 'Leaderboard successfully deleted!');
	}
	if(isset($_GET['modify']) && $_GET['modify'] != NULL && !isset($_POST['board_delete'])){
		$rs_isowner = $db->GetAll("SELECT * FROM dayzstats_boards WHERE owner_userid = ? AND id = ?", array($userid, $_GET['modify']));
		if (sizeof($rs_isowner) != 0) {
			$isowner = true;
		} else {
			$isowner = false;
			$message->add('danger', 'I\'m sorry Dave, but I cannot let you do that! (I see you think we haven\'t blocked this...)');
		}
	}

	// Sortby
	if(isset($_REQUEST['sortby'])) {
		$sortby = $_REQUEST['sortby'];
	} else {
		$sortby = 'KillsZ';
	}

	// Sorttype
	if(isset($_REQUEST['sorttype'])) {
		$sorttype = $_REQUEST['sorttype'];
	} else {
		$sorttype = 'DESC';
	}
?>

<?php if(!isset($_SESSION['user_id']) && !isset($_GET['board'])){ ?>
	<div class="alert alert-info">
		You need to login to use this feature!
	</div>
<?php } elseif(isset($_SESSION['user_id']) && !isset($_GET['board'])) { ?>
	<div class="alert alert-info">
		On this page you can create/modify and delete leaderboards where you can compete with your friends and share links to various leaderboards.
	</div>
	<?php $message->display(); ?>
	<ul class="nav nav-tabs custom-nav-tabs">
  		<li <?php echo isset($_GET['create']) ? 'class="active"' : ''; ?>><a href="index.php?challenge&create">Create Board</a></li>
  		<li <?php echo isset($_GET['modify']) ? 'class="active"' : ''; ?>><a href="index.php?challenge&modify">Modify Boards</a></li>
  		<li <?php echo isset($_GET['links']) ? 'class="active"' : ''; ?>><a href="index.php?challenge&links">Board Links</a></li>
	</ul>

	<?php if(isset($_GET['create'])){ ?>
		<br>
		<form method="POST">
			<div class="row">
				<div class="col-lg-3">
					<input class="form-control"type="text" placeholder="Leaderboard name" name="board_name">
					<input class="form-control" style="margin-top: 5px;" type="text" placeholder="PlayerIDs(Seperated by commas)" name="board_pids">
					<input class="btn btn-primary" style="margin-top: 5px;" type="submit" value="Create" name="board_create">
				</div>
			</div>
		</form>
		<br>
		You can find the <b>PlayerIDs</b> by searching for their playername on the stats page.
	<?php } ?>

	<?php if(isset($_GET['modify'])){?>
		<br>
		<form method="POST">
			<div class="row">
				<div class="col-lg-3">
					<select name="board_modifyname" class="form-control" onChange='window.location="index.php?challenge&modify=" + this.value;'>
						<option>Choose a leaderboard</option>
						<?php
							$modify_rs = $db->GetAll("SELECT * FROM dayzstats_boards WHERE owner_userid = ?", $userid);
							foreach($modify_rs as $modifyrow){
								echo "
									<option value='{$modifyrow['id']}'>{$modifyrow['id']} - {$modifyrow['name']}</option>
								";
							}
						?>
					</select>
				</div>
			</div>

			<?php 
			if($_GET['modify'] != '' && $isowner != false) {?>
			<div class="row">
				<div class="col-lg-3">
					<input type="text" class="form-control" style="margin-top: 5px" name="board_addpid" placeholder="Add PlayerID(One at a time)">
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3">
					<!-- <input type="text" class="form-control" style="margin-top: 5px" name="board_removepid" placeholder="Remove PlayerID"> -->
					<select name="board_removepid" style="margin-top: 5px" class="form-control">
						<option>Remove PlayerID</option>
						<?php
							$modify_delete_rs = $db->GetAll("SELECT pids FROM dayzstats_boards WHERE id = ?", $_GET['modify']);
							foreach($modify_delete_rs as $modifyrowd){
								$m_pids = $modifyrowd['pids'];
								$m_pids = str_replace("'", "", $m_pids);
								$m_pids = explode(',',$m_pids);
								foreach($m_pids as $m_pid){
									echo "
										<option value='$m_pid'>$m_pid</option>
									";
								}
							}
						?>
					</select>	
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3">
					<input class="btn btn-primary" style="margin-top: 5px" type="submit" value="Submit" name="board_modify">
					<input class="btn btn-danger" style="margin-top: 5px" data-toggle="modal" href="#DeleteModal" type="submit" value="Delete">
					<div class="modal fade" id="DeleteModal">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h4 class="modal-title">Are you sure?</h4>
					      </div>
					      <div class="modal-body">
					        <p>Are you sure you want to delete this?</p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary" data-dismiss="modal">No!</button>
					        <input type="submit" name="board_delete" class="btn btn-danger" value="Yes!">
					      </div>
					    </div>
					  </div>
					</div>
				</div>
			</div>
			<?php } ?>
		</form>
	<?php } ?>

	<?php if(isset($_GET['links'])){ ?>
	<br>
		<table class="table">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Members</th>
			</thead>
			<tbody>
			<?php
				$rs = $db->GetAll("SELECT * FROM dayzstats_boards WHERE owner_userid = ?", $userid);
				foreach ($rs as $row){
					$members = str_replace("'", "", $row['pids']);
					echo "
						<tr>
							<td>{$row['id']}</td>
							<td><a href='index.php?challenge&board={$row['id']}'>{$row['name']}</td>
							<td>{$members}</td>
						</tr>
					";
				} 
			?>
			</tbody>
		</table>
	<?php } ?>

<?php } elseif(isset($_GET['board'])) { 

$rs_name = $db->GetAll("SELECT name FROM dayzstats_boards WHERE id = ?", array($_GET['board']));
foreach($rs_name as $namerow){
	$board_name = $namerow['name'];
}
$rs_owner_name = $db->GetAll("SELECT login FROM dayzstats WHERE id = ?", $userid);
foreach($rs_owner_name as $onamerow){
	$owner_name = $onamerow['login']; 
}
?>
		<h3 class="custom-h3"><?php echo $board_name . " - " . $owner_name . "'es Leaderboard"; ?></h3>
		<div class="leaderboard-box">	
			<table class="table">
				<thead>
					<th class="custom-th"># Rank</th>
					<th class="custom-th"><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img><br>Name</th>
					<th class="custom-th"><img src="images/icons/statspage/infectedkilled1.png" width="25px" height="25px" class="table-img"></img><br> Zombie Kills</th>
					<th class="custom-th"><img src="images/icons/statspage/murders.png" width="25px" height="25px" class="table-img"></img><br> Human Kills</th>
					<th class="custom-th"><img src="images/icons/statspage/banditskilled1.png" width="25px" height="25px" class="table-img"></img><br> Bandit Kills</th>
					<th class="custom-th"><img src="images/icons/statspage/infectedheadshots1.png" width="25px" height="25px" class="table-img"></img><br> Headshots</th>
					<th class="custom-th"><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img><br> Humanity</th>
					<th class="custom-th"><img src="images/icons/statspage/playerdeaths1.png" width="25px" height="25px" class="table-img"></img><br> Deaths</th>
					<th class="custom-th"><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img><br> Traveled</th>
					<th class="custom-th"><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img><br> Duration</th>
					<th class="custom-th"><img src="images/icons/statspage/totalplayers1.png" width="25px" height="25px" class="table-img"></img><br> Points</th>
					</thead>
				<tbody>
					<?php
				        $result = $db->GetAll($challenge_leaderboard_query . "ORDER BY $sortby $sorttype", array($_GET['board']));
				        $rank = 1;
						
				        if (sizeof($result) != 0) {
		                    foreach($result as $rowl) {					
								$deaths = $rowl['Generation'] - 1;
				            	$points = $rowl['KillsZ']+$rowl['KillsB']-$rowl['KillsH']-($rowl['Generation']-($deaths) - 1);
								echo "<tr>
									  <td>{$rank}</td>
									  <td><a href=\"info.php?view=info&show=1&CharacterID={$rowl['CharacterID']}\">{$rowl['playerName']}</a></td>
									  <td>{$rowl['KillsZ']}</td>
									  <td>{$rowl['KillsH']}</td>
									  <td>{$rowl['KillsB']}</td>
									  <td>{$rowl['HeadshotsZ']}</td>
									  <td>{$rowl['Humanity']}</td>
									  <td>{$deaths}</td>
									  <td>{$rowl['distanceFoot']}m</td>
									  <td>".survivalTimeToString($rowl['duration'])."</td>
									  <td>{$points}</td>
									  </tr>";
				                $rank++;
							}
				        }
				    ?>
				</tbody>
			</table>
			<select class="form-control pull-right" style="width:200px; margin-top: 20px; margin-bottom: 20px;" name="sortby" onChange='window.location="index.php?challenge&board=<?php echo $_GET['board']; ?><?php if(isset($_GET['sorttype'])) { echo '&sorttype=' . $_GET['sorttype']; } ?><?php if(isset($_GET['limit'])) { echo '&limit=' . $_GET['limit']; } ?>&sortby=" + this.value;'>
				<option>Sort by:</option>
				<option value="KillsZ">Zombie Kills</option>
				<option value="KillsH">Human Kills</option>
				<option value="KillsB">Bandit Kills</option>
				<option value="HeadshotsZ">Headshots</option>
				<option value="Humanity">Humanity</option>
				<option value="Generation">Deaths</option>
			</select>
			<select class="form-control pull-right" style="width:150px; margin-top: 20px; margin-bottom: 20px;" name="sorttype" onChange='window.location="index.php?challenge&board=<?php echo $_GET['board']; ?><?php if(isset($_GET['sortby'])) { echo '&sortby=' . $_GET['sortby']; } ?><?php if(isset($_GET['limit'])) { echo '&limit=' . $_GET['limit']; } ?>&sorttype=" + this.value;'>
				<option>Sort type:</option>
				<option value="DESC">Descending</option>
				<option value="ASC">Ascending</option>
			</select>
		</div>
	<?php } ?>
