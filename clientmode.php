<?php include('connection/connection.php');?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/ui-lightness/jquery-ui-1.8.13.custom.css">
	<script src="bootstrap/js/jquery.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap-dropdown.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap-tooltip.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap-modal.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap-button.js" type="text/javascript"></script>
	<script src="bootstrap/js/jquery.ui.datepicker.js" type="text/javascript"></script>
	<script src="bootstrap/js/jquery-ui-1.8.16.custom.js" type="text/javascript"></script>
	<meta charset="UTF-8">
	<title>Home</title>
	<script>
		$(document).ready(function(){
			$("select[name='meter']").live("change",function(){
				var dates = {"id":$(this).val()};
				$.ajax({
					url:"controller.php",
					type:"post",
					data:{dates:dates},
					success:function(result){
						var value = result.split(",");
						$("input[name='fname']").val(value[0])
						$("input[name='lname']").val(value[1])
						$("input[name='mname']").val(value[2])
						$("input[name='address']").val(value[3])
						$("input[name='contact']").val(value[4])

					}
				})
			})

			$("select[name='client']").live("change",function(){
				var clients = {"id":$(this).val()};
				$.ajax({
					url:"controller.php",
					type:"post",
					data:{clients:clients},
					success:function(result){
						var value = result.split(",");

						$("input[name='firstName']").val(value[0])
						$("input[name='lastName']").val(value[1])
						$("input[name='middleName']").val(value[2])
						$("input[name='address']").val(value[3])
						$("input[name='contact']").val(value[4])
						$("input[name='previous']").val(value[5])
					}
				})
			})

			$("select[name='bill']").live("change",function(){
				var bills = {"id":$(this).val()};
				$.ajax({
					url:"controller.php",
					type:"post",
					data:{bills:bills},
					success:function(result){
						var value = result.split(",");

						$("input[name='due']").val(value[0])
						$("input[name='cons']").val(value[1])
						$("input[name='amt']").val(value[2])
						$("input[name='prev']").val(value[3])
						$("input[name='pres']").val(value[4])
					}
				})
			})

			$(".connect").live("click",function(){
				//$(this).attr("data-original-title","Disconnect");
				$(this).children("i").removeClass("icon-retweet").addClass("icon-random");
				id = $(this).attr("class").split(" ")[2].split("_")[1];
				$(this).removeClass().addClass("btn btn-danger id_"+id+" disconnect")
				var connect = {"id":id}
				$.ajax({
					url:'controller.php',
					type:'post',
					data: {connect:connect},
					success:function(result){
					}
				})
			})
			$(".disconnect").live("click",function(){
				//$(this).attr("data-original-title","Connect");
				$(this).children("i").removeClass("icon-random").addClass("icon-retweet");
				id = $(this).attr("class").split(" ")[2].split("_")[1];
				$(this).removeClass().addClass("btn btn-primary id_"+id+" connect")
				var disconnect = {"id":id}
				$.ajax({
					url:'controller.php',
					type:'post',
					data: {disconnect:disconnect},
					success:function(result){
					}
				})
			})
		  // Setup drop down menu
		  $('.dropdown-toggle').dropdown();
		 
		  // Fix input element click problem
		  $('.dropdown input, .dropdown select,#new,#new2').click(function(e) {
		    e.stopPropagation();
		  });
			$('#disconnect').tooltip('hide');
			$('#connect').tooltip('hide');
			$("#buttonLoad,#saveBill,#savePayment").live("click",function(){
				$(this).button('loading')			
			})
		  $('input[name="showStatement"]').live("click",function(){
		  		id=$("select[name='customer']").val().split("-")[0];
		  		window.open('customerreport.php?customer=true&id='+id,'','width=800,height=500');
		  })
		  $('input[name="showMonth"]').live("click",function(){
		  		window.open('monthly.php?datefrom='+$("input[name='dateFrom']").val()+'&dateto='+$("input[name='dateTo']").val(),'','width=800,height=500');
		  })
			$( ".datepicker" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "yy-mm-dd"
			});
		  $("#new").click(function(){
		  	$("#go2").slideDown("slow");
		  	$("#go").slideUp("slow");
		  })
		  $("#new2").click(function(){
		  	$("#go").slideDown("slow");
		  	$("#go2").slideUp("slow");
		  })
		})
	</script>
</head>
<?php
	//$bg="";
	//if(!isset($_GET["module"])){
		$bg="background='water4.jpg'";
	//}
?>
<body <?php echo $bg;?>>
		<div class="navbar">
		  <div class="navbar-inner">
		  	<span class="span1"></span>
		    <a class="brand" href="#">San Luis Water District</a>
		    <ul class="nav pull-right">
		      <li class="divider-vertical"></li>
		      	<li><a href="controller.php?logout=true"><i class="icon-off"></i></a></li>
		    </ul>
		  </div>
		</div>
	</form>
 <?php 
	      		$listClient = mysql_query("select * from client where meter_num=".$_SESSION["meter"]);
      			$row=mysql_fetch_assoc($listClient);
				$savings = mysql_query("select * from billing where client_id=".$_SESSION["meter"]); 
				$rows=mysql_fetch_assoc($savings);
 ?>
 <div class="container">
	<div class="table">
		<div class="row">
			<h3><?php echo $row["firstname"]." ".$row["lastname"]." ".$row["middlename"];?></h3> 
			<table class="table table-bordered table-striped">
				<tr>
					<th>
						Meter No
					</th>
					<td>
						<?php echo $row["meter_num"];?>
					</td>
					<th>
						Savings
					</th>
					<td>
						&#8369; <?php echo $rows["savings"];?>
					</td>
				</tr>
				<tr>
					<th>
						Address
					</th>
					<td>
						<?php echo $row["address"];?>
					</td>
						<th>
							Contact
						</th>
					<td>
						<?php echo $row["contact"];?>
					</td>
				</tr>
				<tr>
					<th>
						Status
					</th>
					<td>
						<label class="label label-info"><?php echo $row["status"];?></label>
					</td>
					<th>
						Connection Status
					</th>
					<td>
						<label class="label label-info"><?php echo $row["connected"];?></label>
					</td>
				</tr>
			</table>	
        <form action="clientmode.php">
        <strong>Billing Status <label class="label label-info"><?php echo $rows["status"];?></label></strong>
		  <div class="input-append pull-right span9">
		  	<div class="pull-right">
		  		<div class="input-prepend input-append">
		  			<input type="hidden" name="client" value="profile">
				  <span class="add-on">From</span>
		  		  <input type="text" class="datepicker" name="searchValue1" value="<?php if(isset($_GET["searchValue1"])){echo $_GET["searchValue1"];}?>">
				  <span class="add-on">To</span>
				  <input id="appendedInputButton" type="text" class="datepicker" name="searchValue2" value="<?php if(isset($_GET["searchValue2"])){echo $_GET["searchValue2"];}?>">
				  <input class="btn" type="submit" name="search1" value="Search">
				</div>
		  	</div>
		  </div>
        </form>
	<table class="table table-bordered table-striped">
      		<thead>
      			<tr>
      				<th class="span1">Bid</th>
      				<th class="span2">Consumption</th>
      				<th class="span2">Due</th>
      				<th class="span3">Amount</th>
      			</tr>
      		</thead>
      		<tbody>
      		<?php
      					$total=0;
                        $search="";
                        if(isset($_GET["search1"])){
                              $search = "b.dueDate between '".$_GET["searchValue1"]."' and '".$_GET["searchValue2"]."' and ";
                        }
	      		$listClient = mysql_query("select c.id as id,
                                                 c.meter_num as meter,
                                                 c.lastname as lastname,
                                                 c.firstname as firstname,
                                                 b.consumption as consumption,
                                                 b.bill_Id as bId,
                                                 b.billAmt as amt,
                                                 b.dueDate as due,
                                                 b.status as status
                                          from client c,billing b 
                                          where $search c.meter_num=b.client_id and b.client_id=".$_SESSION["meter"]." order by bill_Id ASC");
	      		$numrows = mysql_num_rows($listClient);
	      		if($numrows!=0){
      			while($row=mysql_fetch_assoc($listClient)){
      		?>
      			<tr>
      				<td><?php echo $row["bId"];?></td>
      				<td><?php echo $row["consumption"];?></td>
      				<td><?php echo $row["due"];?></td>
      				<td><?php echo $row["amt"];?></td>
      			</tr>
		    <?php $total += $row["amt"];}
		    	echo "<tr><td></td><td></td><td>Total:</td><td>$total</td></tr>";
				}else {

		    ?>
      			<tr>
      				<td colspan="100%"><i class="icon-info-sign"></i>No Records.</td>
      			</tr>
		    <?php
			}
      		?>
      		</tbody>
      	</table>	

      	</div>  
  </div>
  </body>
</html>