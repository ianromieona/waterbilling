 <div class="container">
      <form method="post" action="controller.php">
            <fieldset>
                  <legend><input type="submit" name="add" class="btn btn-primary" value="ADD">&nbsp;</legend>
                  <br>
                  <div class="table">
                        <div class="row">
                              <div class="span2 offse1">Meter ID:</div>
                              <div class="span5"><select name="meter" required="required">
                                    <?php
                                          $id         =     mysql_query("select Distinct meter_num
                                           from client where status='NOT INSTALLED'");
                                          $nums       =     mysql_num_rows($id); 
                                          if($nums!=0){
                                                echo "<option>Select</option>";
                                                while($rows=mysql_fetch_assoc($id)){
                                    ?>
                                                <option><?php echo $rows["meter_num"];?></option>
                                    <?php
                                                }
                                          }
                                    ?>
                              </select>
                              </div>
                              <div class="span2 offse1">Address:</div>
                              <div class="span3"><input readonly type="text" required="required" name="address"> </div>
                        </div>
                        <div class="row">
                              <div class="span2 offse1">Firstname:</div>
                              <div class="span5"><input readonly type="text" required="required" name="fname"> </div>
                              <div class="span2 offse1">Contact:</div>
                              <div class="span3"><input readonly type="text" required="required" name="contact"> </div>
                        </div>
                        <div class="row">
                              <div class="span2 offse1">Middlename:</div>
                              <div class="span5"><input readonly type="text" required="required" name="mname"> </div>
                              <div class="span2 offse1">Date:</div>
                              <div class="span3"><input type="text" class="datepicker" name="date" required> </div>
                        </div>
                        <div class="row">
                              <div class="span2 offse1">Lastname:</div>
                              <div class="span5"><input type="text" readonly required="required" name="lname"> </div>
                              <div class="span2 offse1">Installation ID:</div>
                              <?php
                                    $lastIndex  =     mysql_query("select installationId from installation order by installationId desc limit 1");
                                    $getId      =     mysql_fetch_assoc($lastIndex); 
                              ?>
                              <div class="span3"><input type="text" required="required" name="installation" style="text-align:center" class="uneditable-input" value="<?php echo $getId["installationId"]+1;?>" readonly></div>
                        </div>
                  </div>      
            </fieldset>
      </form>
      <div class="pull-right">
            <form class="form-search" method="get" action="index.php">
                  <input type="hidden" name="module" value="installation">
                  <input type="text" name="installed" class="input-medium search-query span5" value="<?php if(isset($_GET['installed'])){echo $_GET['installed'];}?>">
                  <input type="submit" class="btn" name="searchInstalled" value="Search">
            </form>
      </div>
      <form action="controller.php" method="post">
            <input type="submit" name="deleteInstall" class="btn btn-danger" value="DELETE">
            <table class="table table-bordered table-striped">
            	<thead>
            		<tr>  
                              <th class="span1"></th>
                             <!--  <th class="span1">I #</th> -->
            			<th class="span1">Meter</th>
            			<th class="span2">Lastname</th>
            			<th class="span2">Firstname</th>
            			<th class="span3">Middle</th>
            			<th class="span3">Address</th>
                              <th class="span2">Contact</th>
            			<th class="span3">Date</th>
            			<th class="span1">Status</th>
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
                                                          i.dateInstalled as date,
                                                          i.installationId as installationId
                                                   from client c,installation i 
                                                   where c.meter_num=i.meter_id and c.status='INSTALLED' ".$search." ");
            		$numrows = mysql_num_rows($listClient);
            		if($numrows!=0){
            		while($row=mysql_fetch_assoc($listClient)){
            	?>
            		<tr>
                              <td><input type="checkbox" name="deleteClient[]" value="<?php echo $row['meter_num'];?>"></td>
                     <!--          <td><?php //echo $row["installationId"];?></td>
 -->            			<td><?php echo $row["meter_num"];?></td>
            			<td><?php echo $row["lastname"];?></td>
            			<td><?php echo $row["firstname"];?></td>
            			<td><?php echo $row["middlename"];?></td>
            			<td><?php echo $row["address"];?></td>
                              <td><?php echo $row["contact"];?></td>
            			<td><?php echo $row["date"];?></td>
            			<td><center><label class="label label-info" style="width:100px;cursor: default;"><?php echo $row["status"];?></label></center></td>
            		</tr>
                <?php }}else {
                  ?>
                        <tr><td colspan="100%"><i>No records.</i></td></tr>
                  <?php
                        }
            	?>
            	</tbody>
            </table>
      </form>
</div>
