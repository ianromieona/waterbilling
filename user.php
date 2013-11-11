<script>
   $(document).ready(function(){
        $('#pay').live('click',function(){
			$('#payForm').slideToggle("slow");
		})
		$("table a.remove-client").live("click",function(){
			if(confirm("are you sure you want to delete?")){
				id=$(this).closest("tr").find("input:hidden").val()
				$tr = $(this).closest("tr")
					var url="controller.php";
					var Delete2 = { "id" : id }
					$.ajax({
					url:url,
					type:'post',
					data:{ Delete2:Delete2 },
					success:function(success){
						$tr.remove();
					},
					error:function(error){
						alert(error)
					}
				})		
			}
				
		})
		$("#close").click(function(){
			$("#holder").slideUp("slow");
		})
		$(".edit-user").click(function(){
			$("#holder").slideDown("slow");
			$("#id1").val($(this).parent().siblings(":first").val());
			$("#name1").val($(this).parent().parent().parent().children(":first").text());
			$("#username1").val($(this).parent().parent().parent().children(":first").next().text());
			$("#password1").focus();
		})
	})
	
</script>
<div class="container">
   <div id="payForm" style="display:none">
      <form name="frm" method="post" action="controller.php">
      <div>
          <table class="table" >
            <tr>
               <th>Name</th>
               <td><input type="text" name="name" id="name" required=required></td>
            </tr>
			<tr>
               <th>Username</th>
               <td><input type="text" name="username" id="username" required=required></td>
            </tr>
			<tr>
               <th>Password</th>
               <td><input type="password" name="password" id="password" required=required></td>
            </tr>
			
         </table>
         <input type=hidden id="mode3" name="mode3" value="a">
         <input type=submit value="Add" id="usersave" class="btn btn-primary">
      </div>
      </form>
   </div>
   <input type=button class="btn" id="pay" value="Add users">
   <hr>
   <form name="frm2" method="post" action="controller.php">
    <div style="position:absolute;background:white;border: 3px double gray;margin-left:300px;display:none;" id="holder">
			<table class="table table-bordered table-striped" >
			<tr>
               <th>ID</th>
               <td><input type="text" name="id1" id="id1" readonly></td>
            </tr>
            <tr>
               <th>Name</th>
               <td><input type="text" name="name1" id="name1" required=required></td>
            </tr>
			<tr>
               <th>Username</th>
               <td><input type="text" name="username1" id="username1" required=required></td>
            </tr>
			<tr>
               <th>Password</th>
               <td><input type="password" name="password1" id="password1" required=required></td>
            </tr>
			
         </table>
		 <input type=hidden id="mode4" name="mode4" value="a">
         <center><input type=submit value="Edit" id="editsave" class="btn btn-primary"> <input type=button value="Cancel" id="close" class="btn btn-danger"><br><br>
		</div>
		</form>
   <table class="table table-bordered table-striped">
      <thead>
         <tr>  
            <th class="span2">Name</th>
            <th class="span2">Username</th>
            <th class="span1"><center>Options</th>
            
         </tr>
      </thead>
      <tbody>
      <?php
                       
         $listClient = mysql_query("select * from users");
         $numrows = mysql_num_rows($listClient);
         if($numrows!=0){
         while($row=mysql_fetch_assoc($listClient)){
      ?>
         <tr>
            <td><?php echo $row["name"];?></td>
            <td><?php echo $row["username"];?></td>
            <td><input type="hidden" name="id" value="<?php echo $row["id"];?>"><center><a class="btn btn-mini edit-user"><i class="icon-pencil"></i></a>&nbsp;<a href="javascript:return;" class="btn btn-mini btn-danger remove-client"><i class="icon-remove"></i></a><center></td>      			
      		
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
