<script>
   $(document).ready(function(){
         $('#tab1').live('click',function(){
            $('#tab2c').hide()
            $('#tab1c').fadeIn()
            $(this).parent('li').addClass('active');
            $('#tab2').parent('li').removeClass();
         })

         $('#tab2').live('click',function(){
            $('#tab1c').hide()
            $('#tab2c').fadeIn()
            $(this).parent('li').addClass('active');
            $('#tab1').parent('li').removeClass();
         })

         $('#client').live('change',function(){
            id = $(this).val()
            
         
         })

         $('#btnAdd').live('click',function(){
            $('#billForm').slideToggle()
            $('#mode').val('new')
            var currentTime = new Date()
            var month = currentTime.getMonth() + 1
            var day = currentTime.getDate()
            var year = currentTime.getFullYear()
            $('#billDate1').val(year + "-" + month + "-" + day);
            <?php 
               $query = mysql_query("Select * from billing order by bill_id DESC limit 1");
               if(mysql_num_rows($query) == 0){
                  $bill_id = 0;
               }
               else{
                  $row = mysql_fetch_assoc($query);
                  $bill_id = $row['bill_id'];
               }
            ?>
            billId = "<?php echo $bill_id+1; ?>";
            var num = 5 - billId.length;
            var con = "";
            if(num != 0){
               for(i = 0; i < num; i++){
                  con = con+"0";
               }
            }

            $('#billingID').val(con+billId)
         })

         $('#present').live('change',function(){

            present = $('#present').val(); 
            prev = $('#previous').val();
            cons = present-prev;
            if(cons <= 10){
				billR = parseFloat($("#a0").val());
            }
            if(cons > 10 && cons <21){
				billR = parseFloat($("#a0").val())+parseFloat($("#a1").val());
            }
            if(cons > 20 && cons <31){
				billR = parseFloat($("#a0").val())+parseFloat($("#a2").val());
            }
            if(cons > 30 && cons <41){
				billR = parseFloat($("#a0").val())+parseFloat($("#a3").val());
            }
            if(cons > 40){
				billR = parseFloat($("#a0").val())+parseFloat($("#a4").val());
				if(cons>41){
					billR=billR+((cons-41)*parseFloat($("#a5").val()));
				}
            }
            total = billR;
            $('#consumption').val(cons);
            $('#price').val(billR.toFixed(2));
            $('#totalBill').val(total.toFixed(2));
            
         })

   })
</script>
<?php
	$e=0;
	$bill = mysql_query("Select * from readingvalue");
	$nums       =     mysql_num_rows($bill); 
	if($nums!=0){
		while($row = mysql_fetch_assoc($bill)){
			echo "<input type='hidden' name='aa".$e."' id='a".$e."' value='".$row['value']."'>";
			$e++;
		}
	}									
?>
<div class="container">
      <div>
      <form name="frm" method="post" action="controller.php">
         <table class="table table-striped">
            <thead class="pull-right">
               <tr>
                  <td>
                     <b>Billing ID : </b>
                  </td>
                  <td>
                     <input type="text" name="billingID" id="billingID" readonly>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      <fieldset>
      <legend>
         <input type="button" class="btn btn-primary" id="btnAdd" value="ADD">
      </legend>
      
      <div class="tabbable" id="billForm" style="display:none">
   
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" id="tab1" data-toggle="tab">Client Details</a></li>
          <li><a href="#tab2" id="tab2" data-toggle="tab">Reading Details</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1c">
            <table class="table">
                     <tr>
                        <th>
                           Meter No.
                        </th>
                        <td>
                           <select name="client" id="client" required="required">
                                    <?php
										  
                                          $id         =     mysql_query("select *
                                           from client where status='INSTALLED'");
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
                        </td>
                        <th>
                           Middle Name
                        </th>
                        <td>
                           <input type="text" name="middleName" id="middleName" required="required" readonly>
                        </td>
                     </tr>
                     <tr>
                        <th>
                           Last Name
                        </th>
                        <td>
                           <input type="text" name="lastName" id="lastName" required="required" readonly>
                        </td>
                        <th>
                           Address
                        </th>
                        <td>
                           <input type="text" name="address" id="address" required="required" readonly>
                        </td>
                     </tr>
                     <tr>
                        <th>
                           First Name
                        </th>
                        <td>
                           <input type="text" name="firstName" id="firstName" required="required" readonly>
                        </td>
                        <th>
                           Contact
                        </th>
                        <td>
                           <input type="text" name="contact" id="contact" required="required" readonly>
                        </td>
                     </tr>
                     <tr>
                        <th>Date</th>
                           <td colspan=3><input type="text" name="billDate1" id="billDate1" class="datepicker" required="required" placeholder = "YYYY-MM-DD"></td>
                     </tr>

                  </table>
          </div>
          <div class="tab-pane" id="tab2c">
            <table class="table">
                    
                     <tr>
                        <th>
                           Previous Reading
                        </th>
                        <td>
                           <input type="text" name="previous" id="previous" readonly> Cu.m
                        </td>
                        <th>
                           Bill Amount
                        </th>
                        <td>
                           <input type="text" name="totalBill" id="totalBill" required readonly>
                        </td>
                     </tr>
                     <tr>
                        <th>
                           Present Reading
                        </th>
                        <td>
                           <input type="text" name="present" id="present" required="required"> Cu.m
                        </td>
                       <th>
                           Price/Cu.m
                        </th>
                        <td>
                           <input type="hidden" name="billDate2" id="billDate2" required="required" placeholder = "YYYY-MM-DD">
                           <input type="text" name="price" id="price" required="required" readonly>
                        </td>
                     </tr>
                     <tr>
                        <th>
                           Consumption
                        </th>
                        <td>
                           <input type="text" name="consumption" id="consumption" required="required" readonly> Cu.m
                        </td>
                      <th>
                           Due Date
                        </th>
                        <td>
                           <input type="text" name="due" id="due" required="required" class="datepicker">
                        </td>
                     </tr> 
                  </table>
          </div>
        </div>
        <input type="hidden" name="mode" id="mode" >
      <input type="submit" value="Save" id="saveBill" class="btn btn-primary">
      </div>
   </form>
       <div class="pull-right">
            <form class="form-search" method="get" action="index.php">
                  <input type="hidden" name="module" value="bill">
                  <input type="text" name="installed" class="input-medium search-query span5" value="<?php if(isset($_GET['installed'])){echo $_GET['installed'];}?>">
                  <input type="submit" class="btn" name="searchInstalled" value="Search">
            </form>
      </div>
   <form action="controller.php" method="post">
            <table class="table table-bordered table-striped">
               <thead>
                  <tr>  
                     <th class="span2">Meter No.</th>
                     <th class="span2">Lastname</th>
                     <th class="span2">Firstname</th>
                     <th class="span3">Consumption</th>
                     <th class="span2">Amount</th>
                     <th class="span3">Due</th>
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
														  c.meter_num as mn,
                                                          c.lastname as lastname,
                                                          c.firstname as firstname,
                                                          b.consumption as consumption,
                                                          b.billAmt as amt,
                                                          b.dueDate as due,
                                                          b.status as status
                                                   from client c,billing b 
                                                   where c.meter_num=b.client_id $search");
                  $numrows = mysql_num_rows($listClient);
                  if($numrows!=0){
                  while($row=mysql_fetch_assoc($listClient)){
               ?>
                  <tr>
                     <td><?php echo $row["mn"];?></td>
                     <td><?php echo $row["lastname"];?></td>
                     <td><?php echo $row["firstname"];?></td>
                     <td><?php echo $row["consumption"];?></td>
                     <td>&#8369; <?php echo number_format($row["amt"], 2, '.', '');?></td>
                     <td><?php echo $row["due"];?></td>
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
</fieldset>
</div>
