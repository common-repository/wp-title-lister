<?php
include("lib/Provider.php");
include("lib/aDriver.php");
include("lib/iDriver.php");
include("lib/Drivers/Mysql.php");
include("../../../wp-config.php");
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, "3306");
$Driver = new Driver_Mysql($link, "SELECT ID, post_title, post_type, post_date, post_modified FROM ".$table_prefix."posts", array("post_title" => "Başlık", "post_type" => "Tür", "post_date" => "Yayınlama", "post_modified" => "Güncelleme"));
$Driver->SetCharset(DB_CHARSET);

$Driver->AddConverter("post_type", "yaziTuru");
$Driver->AddConverter("post_date", "yayinlamaTarih");

function yaziTuru($string, $row){
	if ($string=='revision'){
	return '<span style="color:#333C42; text-decoration:line-through;">Yedek</span>';
	}elseif ($string=='post'){
	return '<span style="color:#333C42;">post</span>';
	}elseif ($string=='page'){
	return '<span style="color:#FF6600;">Sayfa</span>';
	}elseif ($string=='attachment'){
	return '<span style="color:#FF0066;">Resim/Video</span>';
	}else{
	return $string;
	}
}

function yayinlamaTarih($string, $row){
	$simdi = date('Y-m-d H:i:s');
	if ($string < $simdi){
	return '<span style="color:#333C42;">'.$string.'</span>';
	}else{
	return '<span style="color:#CC0000;">'.$string .'</span>';
	}
}

$Provider = new Provider($Driver, "source");
$Provider->HandleRequest();
