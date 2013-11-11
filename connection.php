<div class="container">
 <h3>Connect/Disconnect</h3>
 <a href="index.php?module=history" role="button" data-toggle="modal" class="btn" style="margin-right:10px"><i class="icon-align-justify"></i></a>
       <div class="pull-right">
            <form class="form-search" method="get" action="index.php">
                  <input type="hidden" name="module" value="connection">
                  <input type="text" name="installed" class="input-medium search-query span5" value="<?php if(isset($_GET['installed'])){echo $_GET['installed'];}?>">
                  <input type="submit" class="btn" name="searchInstalled" value="Search">
            </form>
      </div>
 <table class="table table-bordered table-striped">
            	<thead>
            		<tr>  
<!--                         <th class="span1">I #</th> -->
            			<th class="span3">Meter No</th>
            			<th class="span2">Lastname</th>
            			<th class="span2">Firstname</th>
            			<th class="span2">Middle</th>
            			<th class="span3">Address</th>
                        <th class="span2">Contact</th>
            			<th class="span3">Date</th>
            			<th class="span1">Action</th>
            		</tr>
            	</thead>
            	<tbody>
            	<?php
                        $search="";
                        if(isset($_GET["installed"])){
                              $search = "and c.lastname like '%".$_GET["installed"]."%'";
                        }
            		$listClient = mysql_query("select c.id as id,
                                                          c.meter_num as meter_num,
                                                          c.lastname as lastname,
                                                          c.firstname as firstname,
                                                          c.middlename as middlename,
                                                          c.address as address,
                                                          c.contact as contact,
                                                          c.status as status,
                                                          c.connected as connected,
                                                          i.dateInstalled as date,
                                                          i.installationId as installationId
                                                   from client c,installation i 
                                                   where c.meter_num=i.meter_id and c.status='INSTALLED' ".$search." ");
            		$numrows = mysql_num_rows($listClient);
            		if($numrows!=0){
            		while($row=mysql_fetch_assoc($listClient)){
            	?>
            		<tr>
                       <!--  <td><?php //echo $row["installationId"];?></td> -->
            			<td><?php echo $row["meter_num"];?></td>
            			<td><?php echo $row["lastname"];?></td>
            			<td><?php echo $row["firstname"];?></td>
            			<td><?php echo $row["middlename"];?></td>
            			<td><?php echo $row["address"];?></td>
                        <td><?php echo $row["contact"];?></td>
            			<td><?php echo $row["date"];?></td>
            			<?php
            				$statusIcon="";
            				$statusTitle="";
            				$statusId="";
            				if($row["connected"]=='CONNECTED'){
            					$statusIcon="icon-random";
            					$statusTitle="Disconnect";
            					$statusId="disconnect";
            					$statusBot="danger";
            				}
            				else{
            					$statusIcon="icon-retweet";
            					$statusTitle="Connect";
            					$statusId="connect";       					
            					$statusBot="primary";       					
            				}
            			?>
            			<td><a href="#" rel="tooltip" title="<?php echo $statusTitle;?>" class="btn btn-<?php echo $statusBot;?> id_<?php echo $row["meter_num"];?> <?php echo $statusId;?>" style="width:15px"><i class="<?php echo $statusIcon;?>"></i></a></td>

            		</tr>
                <?php }}else {
                  ?>
                        <tr><td colspan="100%"><i>No records.</i></td></tr>
                  <?php
                        }
            	?>
            	</tbody>
            </table>
</div>