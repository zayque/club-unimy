<?php
// output headers so that the file is downloaded rather than displayed
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="List Students BizTech Club.csv"');
 
// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');
 
// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');
 
// Open the connection
$link = mysqli_connect('localhost', 'root', '', 'clubunimy');
// send the column headers
fputcsv($file, array('Name', 'Student Id', 'Email', 'Phone Number'));


//query the database
// $query = "SELECT name_user, studentid_user, email_user, phone_user, club_user FROM user";
$query = "SELECT name_user, studentid_user, email_user, phone_user  FROM user WHERE club_user LIKE '%BizTech%'";
 
if ($rows = mysqli_query($link, $query))
{
// loop over the rows, outputting them
while ($row = mysqli_fetch_assoc($rows))
{
fputcsv($file, $row);
}
// free result set
// mysqli_free_result($result);
}
// close the connection
mysqli_close($link);

?>