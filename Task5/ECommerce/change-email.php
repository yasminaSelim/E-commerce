<?php
session_start();
include_once 'app/database/models/User.php';
$userObj = new User();
$userObj->setStatus(1);
$userObj->setEmail($_Get['email']);
$Result = $userObj->updateStatus();
if ($Result) {
    $SESSION['msg'] = "<div class='alert alert-success'>Email Updated Successfully</div>";
}
else{
    $SESSION['msg'] = "<div class='alert alert-danger'>Something Went Wrong</div>";
}
header('Location:my-account.php');
?>