<?php
error_reporting(E_ALL^E_NOTICE); 
date_default_timezone_set('Asia/Singapore');
session_start();
$connection = mysql_connect("localhost","root","");
mysql_select_db("waterbilling",$connection);
?>