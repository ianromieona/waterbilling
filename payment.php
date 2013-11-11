<script>
   $(document).ready(function(){
         

         $('#pay').live('click',function(){
            $('#payForm').show();
            var currentTime = new Date()
            var month = currentTime.getMonth() + 1
            var day = currentTime.getDate()
            var year = currentTime.getFullYear()
            $('#payDate').val(year + "-" + month + "-" + day);
            <?php 
               $query = mysql_query("Select * from payment order by orId DESC limit 1");
               if(mysql_num_rows($query) == 0){
                  $pay_id = 0;
               }
               else{
                  $row = mysql_fetch_assoc($query);
                  $pay_id = $row['orId'];
               }
            ?>
            payId = "<?php echo $pay_id+1; ?>";
            var num = 5 - payId.length;
            var con = "";
            if(num != 0){
               for(i = 0; i < num; i++){
                  con = con+"0";
               }
            }

            $('#orID').val(con+payId)
            
         })

         $('#payment1').live('change',function(){

            cash = $('#payment1').val()
            a = $('#amt1').val();
            penalty = $('#penalty1').val();
            sub = parseFloat(a)+parseFloat(penalty) ;
            bal = parseFloat(sub)-(parseFloat(cash)+parseFloat($('#savings').val()));
			wew2=parseFloat($('#payment1').val())+parseFloat("<?php echo $_SESSION['sav']; ?>");
			$("#aw").val(wew2);
			if((parseFloat($('#payment1').val())+parseFloat("<?php echo $_SESSION['sav']; ?>")) > parseFloat($('#total').val())){
				wew=(parseFloat($('#payment1').val())+parseFloat("<?php echo $_SESSION['sav']; ?>"))-parseFloat($('#total').val());
				$('#savings').val('0');
				$('#savings').val(wew.toFixed(2));
			}
			else{
				$('#savings').val('0');
			}
			if(parseFloat($('#payment1').val()) > parseFloat($('#total').val())){
				wew=parseFloat($('#payment1').val())-parseFloat($('#total').val());
				$('#savings').val('0');
				$('#savings').val(wew.toFixed(2));
			}
			else{
				$('#savings').val('0');
			}
			if(bal<0){
				bal=0;
			}
            $('#balance1').val(bal.toFixed(2));
            
         })

   })
</script>
<div class="container">
   <div id="payForm" style="display:none">
      <form name="frm" method="post" action="controller.php">
      <table class="table table-striped">
            <thead class="pull-right">
               <tr>
                  <td>
                     <b>OR ID : </b>
                  </td>
                  <td>
                     <input type="text" name="orID" id="orID" readonly>
                  </td>
               </tr>
            </thead>
      </table>
      <div>
          <table class="table">
            <tr>
               <th>
                  Billing ID
               </th>
               <td>
                  <select name="bill" id="bill" required="required">
                           <?php
                                 $id         =     mysql_query("select *
                                  from billing where status='UNPAID'");
                                 $nums       =     mysql_num_rows($id); 
                                 if($nums!=0){
                                       echo "<option value=0>Select</option>";
                                       while($rows=mysql_fetch_assoc($id)){
                           ?>
                                       <option value="<?php echo $rows["bill_id"];?>"><?php echo $rows["client_id"];?></option>
                           <?php
                                       }
                                 }
                           ?>
                     </select>
               </td>
            </tr>
            <tr>
               <th>Due Date</th>
               <td><input type="text" name="due" id="due" readonly></td>
            </tr>
            <tr>
               <th>Bill Amount</th>
               <td><input type="text" name="amt" id="amt1" required readonly></td>
            </tr>
            <tr>
               <th>Consumption</th>
               <td><input type="text" name="cons" id="cons" readonly></td>
            </tr>
            <tr>
               <th>Previous Usage</th>
               <td><input type="text" name="prev" id="prev" readonly></td>
            </tr>
            <tr>
               <th>Present Usage</th>
               <td><input type="text" name="pres" id="pres" readonly></td>
            </tr>
            <tr>
               <th>Payment</th>
               <td><input type="text" name="payment" id="payment1" required></td>
            </tr>
            <tr>
               <th>Penalty</th>
               <td><input type="text" name="penalty" id="penalty1" readonly value=0></td>
            </tr>
			<tr>
               <th>Total Amount</th>
               <td><input type="text" name="total" id="total" readonly><input type="hidden" name="aw" id="aw"></td>
            </tr>
            <tr>
               <th>Balance</th>
               <td><input type="text" name="balance" id="balance1" readonly></td>
            </tr>
			<tr>
               <th>Savings</th>
               <td><input type="text" name="savings" id="savings" readonly></td>
            </tr>
			
         </table>
         <input type=hidden id="mode2" name="mode2" value="a">
         <input type=submit value="Pay" id="savePayment" class="btn btn-primary">
      </div>
      </form>
   </div>
   <input type=button class="btn" id="pay" value="Pay Bills">
   <hr>
       <div class="pull-right">
            <form class="form-search" method="get" action="index.php">
                  <input type="hidden" name="module" value="payment">
                  <input type="text" name="installed" class="input-medium search-query span5" value="<?php if(isset($_GET['installed'])){echo $_GET['installed'];}?>">
                  <input type="submit" class="btn" name="searchInstalled" value="Search">
            </form>
      </div>
   <table class="table table-bordered table-striped">
      <thead>
         <tr>  
            <th class="span2">Meter No.</th>
            <th class="span2">Lastname</th>
            <th class="span2">Firstname</th>
            <th class="span3">Consumption</th>
            <th class="span2">Amount</th>
            <th class="span3">Due</th>
            <th class="span2">Penalty</th>
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
                                                 c.lastname as lastname,
                                                 c.firstname as firstname,
                                                 c.meter_num as meter,
                                                 b.consumption as consumption,
                                                 b.bill_Id as bId,
                                                 b.billAmt as amt,
                                                 b.dueDate as due,
                                                 b.status as status
                                          from client c,billing b 
                                          where c.meter_num=b.client_id $search order by bill_Id ASC");
         $numrows = mysql_num_rows($listClient);
         if($numrows!=0){
         while($row=mysql_fetch_assoc($listClient)){
      ?>
         <tr>
            <td><?php echo $row["meter"];?></td>
            <td><?php echo $row["lastname"];?></td>
            <td><?php echo $row["firstname"];?></td>
            <td><?php echo $row["consumption"];?></td>
            <td>&#8369; <?php echo number_format($row["amt"], 2, '.', '');?></td>
            <td><?php echo $row['due']; ?></td>
			<?php 
			$num = mysql_query("Select * from readingvalue where id=7");
			$rowss = mysql_fetch_assoc($num);
			if(strtotime($row["due"]) < strtotime(date('Y-m-d')) && $row['status']=="UNPAID" ) { ?>
				<td><?php echo $row["amt"]*($rowss['value']/100); ?></td>
			<?php } else{ 
				echo "<td>0</td>";
			} ?>

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
</div>
