<div class="container well">
	<h5>View Monthly reports</h5>
	<input type="text" name="dateFrom" placeholder="Date from.." class="datepicker">
	<input type="text" name="dateTo" placeholder="Date to.." class="datepicker"><br>
	<input type="button" name="showMonth" value="View" class="btn btn-primary"><hr>
	<h5>Customer Service Record  </h5>
	<select name="customer" required="required">
	        <?php
	              $id         =     mysql_query("select c.id as id,
                                                 c.meter_num as meter,
                                                 c.lastname as lastname,
                                                 c.firstname as firstname,
                                                 c.middlename as middlename,
                                                 b.consumption as consumption,
                                                 b.bill_Id as bId,
                                                 b.billAmt as amt,
                                                 b.dueDate as due,
                                                 b.status as status
                                          from client c,billing b 
                                          where c.meter_num=b.client_id order by bill_Id ASC");
	              $nums       =     mysql_num_rows($id); 
	              if($nums!=0){
	                    echo "<option>Select</option>";
	                    while($rows=mysql_fetch_assoc($id)){
	        ?>
	                    <option><?php echo $rows["meter"];?>-<?php echo $rows["lastname"];?>  <?php echo $rows["firstname"];?>, <?php echo $rows["middlename"];?> </option>
	        <?php
	                    }
	              }
	        ?>
	  </select><br>
	<input type="button" name="showStatement" value="View" class="btn btn-primary">
	<hr>
	<h5>Due Date Report</h5>
	<input type="button" value="View" id="due-reports" class="btn btn-primary">
	<hr>
	<h5>Daily Report</h5>
	<input type="button" value="View" id="daily-reports" class="btn btn-primary">
	<hr>
	<h5>Customer Not Installed</h5>
	<input type="button" value="View" id="reports-installation-not" class="btn btn-primary">
	<hr>
	<h5>Customer Installed</h5>
	<input type="button" value="View" id="reports-installation-ok" class="btn btn-primary">
</div>