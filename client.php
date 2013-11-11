<script type="text/javascript">
	$(document).ready(function(){
		var id=0;
		$("input:text").live("keyup",function(){
			var url="controller.php";
			var field=$(this).attr("id");
			var ClientInfo = { "value" : $(this).val(), "field" : field, "id" : id }
			$.ajax({
				url:url,
				type:'post',
				data:{ ClientInfo:ClientInfo },
				success:function(success){
					//alert("success")
				}
			})
		})
		$("table a.remove-client").live("click",function(){
			if(confirm("are you sure you want to delete?")){
				id=$(this).closest("tr").find("input:hidden").val()
				$tr = $(this).closest("tr")
					var url="controller.php";
					var Delete = { "id" : id }
					$.ajax({
						url:url,
						type:'post',
						data:{ Delete:Delete },
						success:function(success){
							$tr.remove();
						},
						error:function(error){
							alert(error)
						}
					})		
			}
				
		})
		$("button[name='search']").live("click",function(){
			var url="controller.php";
			var Search = { "value" : $("input[name='searchValue']").val() }
			$.ajax({
				url:url,
				type:'post',
				data:{ Search:Search },
				success:function(success){
					$('tbody').empty().append(success);
				},
				error:function(error){
					alert(error)
				}
			})	
		})
		$(".edit-client").live("click",function(){
			id=$(this).closest("tr").find("input:hidden").val()
			$("#idd").val($(this).closest("tr").find("input:hidden").val())
			$("input[name='meter']").val($(this).closest("tr").find("td").eq(0).html())
			$("input[name='meter_num']").val($(this).closest("tr").find("td").eq(0).html())
			$("input[name='lastname']").val($(this).closest("tr").find("td").eq(1).html())
			$("input[name='firstname']").val($(this).closest("tr").find("td").eq(2).html())
			$("input[name='middlename']").val($(this).closest("tr").find("td").eq(3).html())
			$("input[name='address']").val($(this).closest("tr").find("td").eq(4).html())
			$("input[name='contact']").val($(this).closest("tr").find("td").eq(5).html())

		})
	})
</script>
<div class="container-fluid">
  <div class="row-fluid">
  	<div class="span1"></div>
    <div class="span2">
      <hr style="margin-bottom:15px">
      <input type="text" placeholder="Meter Number" name="meter_num" id="meter_num" class="span12" readonly>
      <input type="text" placeholder="Last Name" name="lastname" id="lastname" class="span12">
      <input type="text" placeholder="First Name" name="firstname" id="firstname" class="span12">
      <input type="text" placeholder="Mddle Name" name="middlename" id="middlename" class="span12">
      <input type="text" placeholder="Address" name="address" id="address" class="span12">
      <input type="text" placeholder="Contact" name="contact" id="contact" class="span12"><br>
      <i class="icon-info-sign"></i>Inline Editing. Click edit then change text
      <hr style="margin-top:15px">
    </div>

    <div class="span8">
      <!--Body content-->

      <div class="table" style="margin-left:10px">
      <a href="" class="btn"><i class="icon-refresh"></i></a>&nbsp;<a href="#myModal" class="btn btn-primary" role="button" data-toggle="modal"><i class="icon-plus"></i></a>
	  <div class="input-append pull-right span9">
	  	<div class="pull-right">
		  <input id="appendedInputButton" type="text" name="searchValue">
	  		<button class="btn" type="button" name="search">Search</button>
	  	</div>
	  </div>

      	<table class="table table-bordered table-striped">
      		<thead>
      			<tr>
      				<th class="span3">Meter No</th>
      				<th class="span2">Lastname</th>
      				<th class="span2">Firstname</th>
      				<th class="span3">Middle Name</th>
      				<th class="span3">Address</th>
      				<th class="span3">Contact</th>
      				<th class="span1">Status</th>
      				<th class="span2">Action</th>
      			</tr>
      		</thead>
      		<tbody>
      		<?php
	      		$listClient = mysql_query("select * from client");
	      		$numrows = mysql_num_rows($listClient);
	      		if($numrows!=0){
      			while($row=mysql_fetch_assoc($listClient)){
      		?>
      			<tr>
      				<td><?php echo $row["meter_num"];?></td>
      				<td><?php echo $row["lastname"];?></td>
      				<td><?php echo $row["firstname"];?></td>
      				<td><?php echo $row["middlename"];?></td>
      				<td><?php echo $row["address"];?></td>
      				<td><?php echo $row["contact"];
					$record = mysql_query("Select * from billing where client_id=".$row["meter_num"]);
					$numrows = mysql_num_rows($record);
					?></td>
      				<td><center><label class="label label-info" style="width:100px;cursor: default;"><?php echo $row["status"];?></label></center></td>
      				<td><input type="hidden" name="id" value="<?php echo $row["id"];?>"><center><a href="javascript:return;" class="btn btn-mini edit-client"><i class="icon-pencil"></i></a>&nbsp;<?php if($numrows==0){ ?><a href="javascript:return;" class="btn btn-mini btn-danger remove-client"><i class="icon-remove"></i></a><?php } ?><center></td>      			
      			</tr>
		    <?php }}else {}


      		?>
      		</tbody>
      	</table>
      </div>
    </div>
  </div>
  <div class="row-fluid">
  	<div class="span1"></div>
  	<div class="span2">
  	<b>Change Password</b>
  	<br/>
  	<form method="post" action="controller.php">
  		<br/>
  	<input type="hidden" name="meter">	
  	<input type="password" name="nPw" id="nPw" placeholder = "New Password" required>
  	<input type="hidden" id="idd" name="idOfNewPw">

  	<input type="submit" name="changePw" value="Save" class="btn btn-primary">
  </form>
  </div>
  </div>
</div>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">New Costumer</h3>
  </div>
    <form action="controller.php" method="post">
	  <div class="modal-body">
	  	<div class="table"> 
	    	<div class="row">
	    		<?php 
	    			$last = mysql_query("select max(meter_num) as lastIndex from client");
	    			$lastIndex = mysql_fetch_assoc($last);
	    		?>
	    		<div class="span1">Meter:</div><div class="span1"><input type="text" name="m_num" value="<?php echo ($lastIndex["lastIndex"]+1); ?>" readonly></div>
	    	</div>
	    	<div class="row">
	    		<div class="span1">Firstname:</div><div class="span1"><input type="text" name="fname" required></div>
	    	</div>
	      	<div class="row">
	    		<div class="span1">Lastname:</div><div class="span1"><input type="text" name="lname" required></div>
	    	</div>
	        <div class="row">
	    		<div class="span1">Middlename:</div><div class="span1"><input type="text" name="mname" required></div>
	    	</div>
	         <div class="row">
	    		<div class="span1">Address:</div><div class="span1"><input type="text" name="adress" required></div>
	    	</div>
	         <div class="row">
	    		<div class="span1">Contact:</div><div class="span1"><input type="text" name="contacts" required></div>
	    	</div>
	         <div class="row">
	    		<div class="span1">Password:</div><div class="span1"><input type="password" name="password" required></div>
	    	</div>
	    </div>	
	  </div>
	  <div class="modal-footer">
	    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	    <input type="submit" id="buttonLoad" name="addClient" value="Save"  data-loading-text="Loading..." class="btn btn-primary">
	  </div>
    </form>
</div>