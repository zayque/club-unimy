<?php
	    
	require '../config-mysqli.php';

		//user
		$club_id = $_POST['clubid1'];
		$club_image = $_POST['clubimage'];
		$club_content = $_POST['clubcontent'];
		$club_content_2 = $_POST['clubcontent2'];
		$club_date = $_POST['clubdate'];
		$club_time = $_POST['clubtime'];
		$club_contact = $_POST['clubcontact'];
		$club_name = $_POST['clubname'];




	$query = "UPDATE club_activity SET
				club_image = '$club_image',
				club_content = '$club_content',
				club_content_2 = '$club_content_2',
				club_date = '$club_date',
				club_time = '$club_time',
				club_contact = '$club_contact',
				club_name = '$club_name'
				WHERE club_id = '$club_id'";

	mysqli_query($conn,$query) or die(mysqli_error($conn));

	echo'<script>alert("Update Success")</script>';

	echo "<script>window.location='esport.php?esport=success';</script>";
	
?>