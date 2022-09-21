<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["id_user"])) {
    $query = "DELETE FROM user WHERE id_user=".$_GET["id_user"];
    $result = $db_handle->executeQuery($query);
	if(!empty($result)){
		header("Location:dashboard.php");
	}
}
?>