<?php
include('connection/connection.php');

/*log in user*/
if(isset($_POST["login"])){
	$login = mysql_query("select name,username,password from users where username='".$_POST["username"]."' and password='".$_POST["password"]."'");
	$numrows = mysql_num_rows($login);
	$row=mysql_fetch_assoc($login);
	if($numrows!=0){
		$_SESSION["username"]=$_POST["username"];
		$_SESSION["name"]=$row["name"];
		if ($_SESSION["username"]=="admin"){
			header('location:index.php?module=client');
		}
		else{
			header('location:index.php?module=reports');
		}
	}
	else{
		echo "<script>alert('invalid username/password');location='index.php'</script>";
	}
}
if(isset($_POST["login2"])){
	$login = mysql_query("select user,password from clientmode where user='".$_POST["meternumber"]."' and password='".$_POST["password2"]."'");
	$numrows = mysql_num_rows($login);
	if($numrows!=0){
		$_SESSION["meter"]=$_POST["meternumber"];
		header('location:clientmode.php');
	}
	else{
		echo "<script>alert('invalid username/password');location='index.php'</script>";
	}
}
if(isset($_POST["ClientInfo"])){
	mysql_query("update client set ".$_POST["ClientInfo"]["field"]."='".$_POST["ClientInfo"]["value"]."' where id=".$_POST["ClientInfo"]["id"]);
	return;
}
if(isset($_POST["Delete"])){
	mysql_query("Delete from client where id=".$_POST["Delete"]["id"]);
	return;
}
if(isset($_POST["Delete2"])){
	mysql_query("Delete from users where id=".$_POST["Delete2"]["id"]);
	return;
}
if(isset($_POST["Search"])){
	$search = mysql_query("select * from client where lastname like '%".$_POST["Search"]["value"]."%'");
	$numrows = mysql_num_rows($search);
	if($numrows!=0){
		while($row=mysql_fetch_assoc($search)){
			echo "
      			<tr>
      				<td>". $row["meter_num"]."</td>
      				<td>". $row["lastname"]."</td>
      				<td>". $row["firstname"]."</td>
      				<td>". $row["middlename"]."</td>
      				<td>". $row["address"]."</td>
      				<td>". $row["contact"]."</td>
      				<td><center><label class='label label-info' style='width:100px'>".$row["status"]."</label></center></td>
      				<td><center><a href='javascript:return;' class='btn btn-mini'><i class='icon-pencil'></i></a>&nbsp;<a href='javascript:return;' class='btn btn-mini btn-danger'><i class='icon-remove'></i></a><center></td>      			
      			</tr>";
		}
		return;
	}
	else{
		echo "<tr><td colspan=8><i>No records found.</i></td></tr>";
		return;
	}
}
if(isset($_POST["add"])){
	try {
		mysql_query("insert into installation values(installationId,'".$_POST["date"]."',".$_POST["installation"].",".$_POST["meter"].")");
		mysql_query("update client set status='INSTALLED' where meter_num=".$_POST["meter"]);
		header('location:index.php?module=installation');
	} catch (Exception $e) {
		echo $e;
	}

}
if(isset($_POST["dates"])){
	$value 		= 	mysql_query("select * from client where meter_num=".$_POST["dates"]["id"]);
	$values		=	mysql_fetch_assoc($value); 
	$numrows 	= 	mysql_num_rows($value);
	$fetched	=	"";
	if($numrows!=0){
		$fetched = $values["firstname"].",".$values["middlename"].",".$values["lastname"].",".$values["address"].",".$values["contact"]; 
		echo $fetched;
		return;
	}
}

if(isset($_POST["bills"])){
	$value 		= 	mysql_query("select * from billing where bill_id=".$_POST["bills"]["id"]."");
	$values		=	mysql_fetch_assoc($value); 
	$numrows 	= 	mysql_num_rows($value);
	$fetched	=	"";
	if($numrows!=0){
		$_SESSION['sav']=$values["savings"];
		$fetched = $values["billDate"].",".$values["consumption"].",".$values["billAmt"].",".$values["previousUse"].",".$values["presentUse"].",".$values["savings"]; 
	}
	else{
		$fetched = " , ,0, , "; 
	}
	echo $fetched;
	return;
}

if(isset($_POST["clients"])){
	$value 		= 	mysql_query("select * from client where meter_num=".$_POST["clients"]["id"]);
	$v2 		= 	mysql_query("select * from billing where client_id = ".$_POST["clients"]["id"]." order by billDate DESC limit 1");
	$values		=	mysql_fetch_assoc($value); 
	$v2s 		=	mysql_fetch_assoc($v2); 
	$numrows 	= 	mysql_num_rows($value);
	$fetched	=	"";
	if($numrows!=0 && mysql_num_rows($v2)!=0){
		$fetched = $values["firstname"].",".$values["middlename"].",".$values["lastname"].",".$values["address"].",".$values["contact"].",".$v2s["presentUse"]; 
		echo $fetched;
		return;
	}
	if($numrows!=0 && mysql_num_rows($v2)==0){
		$fetched = $values["firstname"].",".$values["middlename"].",".$values["lastname"].",".$values["address"].",".$values["contact"].",0"; 
		echo $fetched;
		return;
	}
}

if(isset($_POST["deleteInstall"])){
	foreach ($_POST["deleteClient"] as $key => $value) {
		mysql_query("update client set status='NOT INSTALLED' where meter_num=".$value);
		mysql_query("delete from installation where meter_id=".$value);
	}
	header('location:index.php?module=installation');
}
if(isset($_POST["connect"])){
	mysql_query("update client set connected='CONNECTED' where meter_num=".$_POST["connect"]["id"]);
	mysql_query("insert into connection values (id,".$_POST["connect"]["id"].",'".date("Y/M/d")."','CONNECTED')");	
	return;
}
if(isset($_POST["disconnect"])){
	mysql_query("update client set connected='DISCONNECTED' where meter_num=".$_POST["disconnect"]["id"]);
	mysql_query("insert into connection values (id,".$_POST["disconnect"]["id"].",'".date("Y/M/d")."','DISCONNECTED')");	
	return;
}
if(isset($_POST['addClient'])){
	mysql_query("insert into client values (id,".$_POST["m_num"].",'".$_POST["fname"]."','".$_POST["lname"]."','".$_POST["mname"]."','".$_POST["adress"]."','".$_POST["contacts"]."','NOT INSTALLED','DISCONNECTED')");
	mysql_query("insert into clientmode values (id,".$_POST["m_num"].",'".$_POST["password"]."')");
	header('location:index.php?module=client');
}

if(isset($_POST['mode'])){
	if($_POST['mode'] == 'new'){
		$due = mysql_query("Select client_id from billing where client_id=".$_POST['client']);
		$nums       =     mysql_num_rows($due); 
		if($nums==0){
			try {
				mysql_query("insert into billing values (".$_POST['billingID'].",".$_POST['client'].",".$_POST['previous'].",".$_POST['present'].",'".$_POST['billDate1']."','".$_POST['due']."',".$_POST['consumption'].",".$_POST['totalBill'].",".$_POST['price'].",0,'UNPAID')");
				header('location:index.php?module=bill');

			} catch (Exception $e) {
					echo $e;
			}
		}
		else{
			mysql_query("Update billing set previousUse=".$_POST['previous'].",presentUse=".$_POST['present'].",billDate='".$_POST['billDate1']."',dueDate='".$_POST['due']."',consumption=".$_POST['consumption'].",billAmt=billAmt+".$_POST['totalBill'].",pricePer=pricePer+".$_POST['price'].",status='UNPAID' where client_id=".$_POST['client']);
			header('location:index.php?module=bill');
		}
	}
}
if(isset($_POST['mode2'])){	
	mysql_query("insert into payment values (".$_POST['orID'].",".$_POST['bill'].",'".$_POST['due']."',".$_POST['amt'].",'".$_POST['aw']."','".$_POST['penalty']."',".$_POST['balance'].")");
		if($_POST['balance']==0){
			mysql_query("update billing set status = 'PAID',savings=".$_POST['savings']." where bill_id = ".$_POST['bill']."");
		}
		else{
			mysql_query("update billing set billAmt = ".$_POST['balance'].",savings=".$_POST['savings']." where bill_id = ".$_POST['bill']."");
		}
		unset($_SESSION['sav']);
		header('location:index.php?module=payment');
}
if(isset($_POST['mode3'])){
	mysql_query("insert into users values ('','".$_POST['name']."','".$_POST['username']."','".$_POST['password']."')");
	header('location:index.php?module=user');
}
if(isset($_POST['mode4'])){
	mysql_query("update users set name='".$_POST['name1']."',username='".$_POST['username1']."',password='".$_POST['password1']."' where id=".$_POST['id1']."");
	header('location:index.php?module=user');
}
if(isset($_POST['changePw'])){
	if($_POST['meter']!=""){
		mysql_query("Update clientmode set password = '".$_POST['nPw']."' where user='".$_POST['meter']."'");
		header('location:index.php?module=client');
	}
	else{
		echo "<script>alert('Error Occured!');location='index.php?module=client'</script>";
	}
}
if(isset($_POST['savePrice'])){
	for($i=0;$i<7;$i++){
		mysql_query("Update readingvalue set value = ".$_POST['aa'.$i]." where id=".$_POST['id'.$i]."");
	}
	header('location:index.php?module=price');

}
/**
*  GET METHOD
*
*
*/
if (isset($_GET["logout"])) {
	header('location:index.php');
	unset($_SESSION["username"]);
	unset($_SESSION["meter"]);
}

?>