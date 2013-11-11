<br><div class="container">
	<div>
	  <form name="frm" method="post" action="controller.php">
			<table class="table table-bordered table-striped">
				<?php
					$e=0;
					$bill = mysql_query("Select * from readingvalue");
					$nums       =     mysql_num_rows($bill); 
					if($nums!=0){
						while($row = mysql_fetch_assoc($bill)){
							echo "<tr>";
							if($row['id']==1){
								echo "<th>Exact amount when reading is less than 10 or equal to ten</th>";
							}
							else if($row['id']==2){
								echo "<th>Additional amount when reading is greater than 10 and less than to 21</th>";
							}
							else if($row['id']==3){
								echo "<th>Additional amount when reading is greater than 20 and less than to 31</th>";
							}
							else if($row['id']==4){
								echo "<th>Additional amount when reading is greater than 30 and less than to 41</th>";
							}
							else if($row['id']==5){
								echo "<th>Additional amount when reading is greater than 40</th>";
							}
							else if($row['id']==6){
								echo "<th>Additional amount when reading is exceeds to 41</th>";
							}
							else if($row['id']==7){
								echo "<th>Penalty percentage</th>";
							}
							echo "<td><center><input type='hidden' name='id".$e."' value='".$row['id']."'><input type='text' name='aa".$e."' id='a".$e."' value='".$row['value']."'></td>";
							echo "</tr>";
							$e++;
						}
					}									
				?>
			</table>
			 <input type="submit" value="Save" name="savePrice" class="btn btn-primary">
		</form>
	</div>
</div>
			