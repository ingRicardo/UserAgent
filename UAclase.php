<?php

 	define("DB_HOST",'localhost');
	define("DB_USER",'root'); 
	define("DB_PASSWORD",'xxxxxxxx'); 
	define("DB_DATABASE",'test'); 
	include_once("DbMySQL.php");
	$firma = $_SERVER['HTTP_USER_AGENT'];
	$address = $_SERVER['REMOTE_ADDR'];
	
class UAclase {
	
	function __construct($argument) {
		
		
	}
	function main($firma,$address,$a){
		echo "$firma<br>";
		echo "<br>$address</br>";
		$queryString="SELECT * FROM agent WHERE gu='".$firma."'";
		$a->query($queryString);
		$res= $a->nextRecord();
		print_r($res);
		
		
		$queryString3="SELECT * FROM ip_agent WHERE ip='".$address."'";
		$a->query($queryString3);
		$res1= $a->nextRecord();
		print_r($res1);
		
		
		if($res){
			if(!$res1){
				addUA($res);
				hazip_ua($address);
			}
				
		}else{
			hazUA($firma);
			hazip_ua($address);
			
		}
	}
	
	function hazUA($firma){
		echo "$address<br>";

		$queryString2="INSERT INTO agent (gu, count) VALUES ('$firma',1)";
		$a->query($queryString2) ;
	}
	function hazip_ua($address){
		echo "$address<br>";
		
		$queryString3="INSERT INTO ip_agent (ip, ip_agent) VALUES ('$address',1)";
		$a->query($queryString3) ;		
	}
	
	function addUA($res){
		
		$count=$res['count']+1;
		$id=$res['id'];
		
		$queryString1="UPDATE agent SET count= $count WHERE id=$id";
		echo "<br/>enter";
		$a->query($queryString1);
		
	} 
	

}
$a = new DbMySQL();
$a->connect();
	
$b= new UAclase();
$b->main($firma, $address,$a);
$a->close();

?>