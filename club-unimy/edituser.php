<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["submit"])) {
    $query = "UPDATE user set name_user = '".$_POST["name_user"]."',studentid_user = '".$_POST["studentid_user"]."', email_user = '".$_POST["email_user"]."', phone_user = '".$_POST["phone_user"]."', club_user = '".$_POST["club_user"]."' WHERE  id_user=".$_GET["id_user"];

    $result = $db_handle->executeQuery($query);
    if(!$result){
        $message = "Problem in Editing! Please Retry!";
    } else {
        header("Location:dashboard.php");
    }
}
$result = $db_handle->runQuery("SELECT * FROM user WHERE id_user='" . $_GET["id_user"] . "'");
?>
<link href="style.css" type="text/css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function validate() {
    var valid = true;
    $(".demoInputBox").css('background-color', '');
    $(".info").html('');

    if (!$("#name_user").val()) {
        $("#name-info").html("(required)");
        $("#name_user").css('background-color', '#FFFFDF');
        valid = false;
    }
    if (!$("#studentid_user").val()) {
        $("#studentid-info").html("(required)");
        $("#studentid_user").css('background-color', '#FFFFDF');
        valid = false;
    }
    if (!$("#email_user").val()) {
        $("#email-info").html("(required)");
        $("#email_user").css('background-color', '#FFFFDF');
        valid = false;
    }
    if (!$("#phone_user").val()) {
        $("#phone-info").html("(required)");
        $("#phone_user").css('background-color', '#FFFFDF');
        valid = false;
    }
    if (!$("#club_user").val()) {
        $("#club-info").html("(required)");
        $("#club_user").css('background-color', '#FFFFDF');
        valid = false;
    }
    if (!$("#id_user").val()) {
        $("#iduser-info").html("(required)");
        $("#id_user").css('background-color', '#FFFFDF');
        valid = false;
    }
    return valid;
}
</script>
<form name="frmToy" method="post" action="" id="frmToy" onClick="return validate();">
    <div id="mail-status">
        <div>
            <label style="padding-top:20px;">Name</label>
            <span id="name-info" class="info"></span><br />
            <input type="hidden" name="id_user" id="id_user" class="demoInputBox"
                value="<?php echo $result[0]["id_user"]; ?>">
            <input type="text" name="name_user" id="name_user" class="demoInputBox"
                value="<?php echo $result[0]["name_user"]; ?>">
        </div>
        <div>
            <label>Student Id</label>
            <span id="studentid-info" class="info"></span><br />
            <input type="text" name="studentid_user" id="studentid_user" class="demoInputBox"
                value="<?php echo $result[0]["studentid_user"]; ?>">
        </div>
        <div>
            <label>Email</label>
            <span id="email-info" class="info"></span><br />
            <input type="text" name="email_user" id="email_user" class="demoInputBox"
                value="<?php echo $result[0]["email_user"]; ?>">
        </div>
        <div>
            <label>Phone Number</label>
            <span id="phone-info" class="info"></span><br />
            <input type="text" name="phone_user" id="phone_user" class="demoInputBox"
                value="<?php echo $result[0]["phone_user"]; ?>">
        </div>
        <div>
            <label>Club</label>
            <span id="club-info" class="info"></span><br />
            <input type="text" name="club_user" id="club_user" class="demoInputBox"
                value="<?php echo $result[0]["club_user"]; ?>">
        </div>
        <div>
            <input type="submit" name="submit" id="btnAddAction" value="Submit" /><br><br>
            <a href="dashboard.php">Back to Admin Panel</a>
        </div>
    </div>
</form>