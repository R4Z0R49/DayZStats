<div class="stats-box">	
	<div class="stats-box-inner">
		<table border="0" cellpadding="4" cellspacing="0">
			<td width="26"><img src="images/icons/statspage/totalplayers1.png" width="36" height="36" /></td>
				<td width="184"><strong>Total Players:</strong></td>
				<td align="right"><strong><?php echo $num_totalplayers;?></strong></td>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/totalplayerin24h.png" width="36" height="36" /></td>
				<td><strong>Players in Last 24h:</strong></td>
				<td align="right"><strong><?php echo $num_Played24h;?></strong></td>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/alivecharacters1.png" width="36" height="36" /></td>
				<td><strong>Alive Characters:</strong></td>
				<td align="right"><strong><?php echo $totalAlive;?></strong></td>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/playerdeaths1.png" width="36" height="36" /></td>
				<td><strong>Player Deaths:</strong></td>
				<td align="right"><strong><?php echo $num_deaths;?></strong></td>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/infectedkilled1.png" width="36" height="36" /></td>
				<td><strong>Zombies Killed:</strong></td>
				<td align="right"><strong><?php echo $KillsZ;?></strong></td>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/infectedheadshots1.png" width="36" height="36" /></td>
				<td><strong>Zombies Headshots:</strong></td>
				<td align="right"><strong><?php echo $HeadshotsZ;?></strong></td>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/murders.png" width="36" height="36" /></td>
				<td><strong>Murders:</strong></td>
				<td align="right"><strong><?php echo $KillsH;?></strong></td>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/heroesalive1.png" width="36" height="36" /></td>
				<td><strong>Heros Alive:</strong></td>
				<td align="right"><strong><?php echo $num_aliveheros;?></strong></td>
			</tr>
			<tr>
			<tr>
				<td><img src="images/icons/statspage/banditsalive1.png" width="36" height="36" /></td>
				<td><strong>Bandits Alive:</strong></td>
				<td align="right"><strong><?php echo $num_alivebandits;?></strong></td>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/banditskilled1.png" width="36" height="36" /></td>
				<td><strong>Bandits Killed:</strong></td>
				<td align="right"><strong><?php echo $KillsB;?></strong></td>
			</tr>
			</tr>
			<tr>
				<td><img src="images/icons/statspage/vehicles.png" width="36" height="36" /></td>
				<td><strong>Vehicles:</strong></td>
				<td align="right"><strong><?php echo $num_totalVehicles;?></strong></td>
			</tr>
		</table>
	</div>
</div>

</br>

<div class="stats-box">
	<div class="stats-box-inner">
		<div class="stats-search">
			<?php require_once('playersearch.php'); ?>	
		</div>
	</div>
</div>
