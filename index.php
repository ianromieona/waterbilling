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
	<script src="bootstrap/js/bootstrap-carousel.js" type="text/javascript"></script>
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

						$("input[name='due']").val(value[0]);
						$("input[name='cons']").val(value[1]);
						$("input[name='amt']").val(parseFloat(value[2]).toFixed(2));
						$("input[name='prev']").val(value[3]);
						$("input[name='pres']").val(value[4]);
						$("input[name='savings']").val(value[5]);
						var d = new Date();
						var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();
						if( (new Date(value[0]).getTime() < new Date(strDate).getTime())){
							<?php
							$query = mysql_query("Select * from readingvalue where id=7");
							$row = mysql_fetch_assoc($query);
							$penal = $row['value'];
							?>
							urpenalty=<?php echo $penal; ?>;
							totpenal=parseFloat(value[2])*parseFloat(urpenalty/100);
							$("input[name='penalty']").val(totpenal.toFixed(2));
							totalamt=parseFloat(value[2])+totpenal;
							$("input[name='total']").val(totalamt.toFixed(2));
						}
						else{
							$("input[name='total']").val(parseFloat(value[2]).toFixed(2));
						}
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
		  $('#reports-installation-not').live("click",function(){
		  		window.open('notinstalled.php','','width=800,height=500');
		  })
		  $('#reports-installation-ok').live("click",function(){
		  		window.open('installed.php','','width=800,height=500');
		  })
		  $('#daily-reports').live("click",function(){
		  		window.open('daily.php','','width=800,height=500');
		  })
		  $('#due-reports').live("click",function(){
		  		window.open('due.php','','width=800,height=500');
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
	$bg="";
//	if(!isset($_GET["module"])){
		$bg="background='water4.jpg'";
	//}
?>
<body <?php echo $bg;?>>
		<div class="navbar">
		  <div class="navbar-inner">
		  	
		    <a class="brand" href="#">San Luis Water District</a>
		    <ul class="nav">
		    	<?php if(isset($_SESSION["username"]) && $_SESSION["username"]=="admin"){ ?>
<!-- 		    		<li class="divider-vertical"></li>
			    	<li><a class="home" href="index.php?module=home"><i class="icon-home"></i>&nbsp;Home</a></li> -->
		    		<li class="divider-vertical"></li>
			    	<li><a class="client" href="index.php?module=client"><i class="icon-user"></i>&nbsp;Client</a></li>
			    	<li class="divider-vertical"></li>
			    	<li><a class="installation" href="index.php?module=installation"><i class="icon-cog"></i>&nbsp;Installation</a></li>
			    	<li class="divider-vertical"></li>
			    	<li><a class="connection" href="index.php?module=connection"><i class="icon-retweet"></i>&nbsp;Connection</a></li>
			    	<li class="divider-vertical"></li>
			    	<li><a class="bill" href="index.php?module=bill"><i class="icon-tasks"></i>&nbsp;Bill</a></li>
			    	<li class="divider-vertical"></li>
			    	<li><a class="payment" href="index.php?module=payment"><i class="icon-circle-arrow-up"></i>&nbsp;Payment</a></l>
				    <li class="divider-vertical"></li>
					<li><a class="price" href="index.php?module=price"><i class="icon-circle-arrow-down"></i>&nbsp;Price/Cu.m</a></l>
				    <li class="divider-vertical"></li>
					<li><a class="user" href="index.php?module=user"><i class="icon-user"></i>&nbsp;Users</a></l>
				    <li class="divider-vertical"></li>
			    	<li><a class="reports" href="index.php?module=reports"><i class="icon-align-justify"></i>&nbsp;Reports</a></l>
				    <li class="divider-vertical"></li>
		    	<?php } if(isset($_SESSION["meter"])){ ?>
<!-- 		    		<li class="divider-vertical"></li>
			    	<li><a class="home" href="index.php?module=home"><i class="icon-home"></i>&nbsp;Home</a></li> -->
		    		<li class="divider-vertical"></li>
			    	<li><a class="profile" href="index.php?client=profile"><i class="icon-user"></i>&nbsp;Profile</a></li>
			    	<li class="divider-vertical"></li>
		    	<?php } ?>
		    </ul>
		    <ul class="nav pull-right">
		      <li class="divider-vertical"></li>
		      <?php
		      	if(!isset($_SESSION["username"])){
		      ?>
		      <li class="dropdown">
	      		<a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>
<!-- 	      		<ul class="dropdown-menu span3">
	      			<li><center><input type="text" placeholder="username" name="username" style="width:190px"></center></li>
	      			<li><center><input type="password" placeholder="password" name="password" style="width:190px"></center></li>
	      			<li class="divider"></li>
	      			<li><center><input type="submit" name="login" class="btn btn-primary span3" value="Sign in"></center></li>
	      		</ul> -->
	      	<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
				<form action="controller.php" method="post">
				<div id="go">
				  <div class="control-group">
				    <div class="controls">
				      <input type="text" id="inputEmail" placeholder="username" name="username">
				    </div>
				  </div>
				  <div class="control-group">
				    <div class="controls">
				      <input type="password" id="inputPassword" placeholder="password" name="password">
				    </div>
				  </div>
				  <div class="control-group">
				    <div class="controls">
				      <input type="submit" name="login" class="btn btn-primary" style="width:100%" value="Sign in">
				    </div>
				  </div>
				  <div class="control-group pull-right">
				    <div class="controls">
				      <a href="javascript:return;" id="new"><small>I'm a Client</small></a>
				    </div>
				  </div>
				 </div>
				</form>
				<form action="controller.php" method="post">
				<div id="go2" style="display:none">
				  <div class="control-group">
				    <div class="controls">

				      <input type="text" placeholder="meter" name="meternumber">
				    </div>
				  </div>
				  <div class="control-group">
				    <div class="controls">
				      <input type="password" placeholder="password" name="password2">
				    </div>
				  </div>
				  <div class="control-group">
				    <div class="controls">
				      <input type="submit" name="login2" class="btn btn-primary" style="width:100%" value="Sign in">
				    </div>
				  </div>
				  <div class="control-group pull-right">
				    <div class="controls">
				      <a href="javascript:return;" id="new2"><small>Back</small></a>
				    </div>
				  </div>
				 </div>
				</form>
		      </div>
		      </li>
		      <?php } else { if(!isset($_SESSION["meter"])){ ?>
		      	<li style="padding-top: 10px;"><b><?php echo $_SESSION['name']; ?></b></li>
		      	<li><a href="controller.php?logout=true"><i class="icon-off"></i></a></li>
			  <?php }else
			  {?>
		      	<li><a href="controller.php?logout=true"><i class="icon-off"></i></a></li>

			  <?php }} ?>
		    </ul>
		  </div>
		</div>
	</form>
	<!-- BODY -->

	<?php
		if(isset($_GET["module"])){
			// if($_GET["module"] == "home"){
			// 	echo "<script>$('.home').parent().addClass('active')</script>";
			// 	include("home.php");
			// }
			if($_GET["module"] == "client"){
				echo "<script>$('.client').parent().addClass('active')</script>";
				include("client.php");
			}
			else if($_GET["module"] == "installation"){
				echo "<script>$('.installation').parent().addClass('active')</script>";
				include("installation.php");
			}
			else if($_GET["module"] == "connection"){
				echo "<script>$('.connection').parent().addClass('active')</script>";
				include("connection.php");
			}
			else if($_GET["module"] == "bill"){
				echo "<script>$('.bill').parent().addClass('active')</script>";
				include("bill.php");
			}
			else if($_GET["module"] == "payment"){
				echo "<script>$('.payment').parent().addClass('active')</script>";
				include("payment.php");
			}
			else if($_GET["module"] == "reports"){
				echo "<script>$('.reports').parent().addClass('active')</script>";
				include("reports.php");
			}
			else if($_GET["module"] == "price"){
				echo "<script>$('.price').parent().addClass('active')</script>";
				include("price.php");
			}
			else if($_GET["module"] == "user"){
				echo "<script>$('.user').parent().addClass('active')</script>";
				include("user.php");
			}
			else if($_GET["module"] == "history"){
				include("history.php");
			}
		}
		if(isset($_GET["client"])){
			if($_GET["client"] == "profile"){
				echo "<script>$('.profile').parent().addClass('active')</script>";
				include("clientmode.php");
			}
		}
		if(!isset($_GET["client"]) && !isset($_GET["module"])){
				include("view.php");
		}
	?>



</body>
</html>