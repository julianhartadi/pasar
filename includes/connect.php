<?php
	$connect= mysql_connect('localhost','root','');
	
	if(!$connect){
		die('Tidak bisa konek'.mysql_error() );
	}
	
	$db_selected = mysql_select_db("pasar");
	if(!$db_selected){
		die('Tidak bisa pilih database'.mysql_error() );
	}
?>