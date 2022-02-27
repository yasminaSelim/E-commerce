<?php
$title = 'Verify Code';
include_once 'layouts/header.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/requests/verifyCodeRequest.php';
include_once 'app/database/models/User.php';
if ($_GET) {
    if (isset($_GET['page'])) {
        $pages=['login','register','verify-email'];
        if (!in_array($_GET['page'],$pages)) {
            header('Location:errors/404.php');
            die;
        }
    }
    else{
        header('Location:errors/404.php');
        die;
    }
}
else{
    header('Location:errors/404.php');
    die;
}
if ($_POST) {
    $codeValidation = new verifyCodeRequest;
    $codeValidation->setCode($_POST['code']);
    $codeValidationResult = $codeValidation->codeValidation();
    if (empty($codeValidationResult)) {
        //search code & email
        $userObj = new User;
        $userObj->setCode($_POST['code']);
        $userObj->setEmail($_SESSION['user_email']);
        $checkResult = $userObj->verifyCode();
        if ($checkResult) {
            $userObj->setStatus(1);
            $updateResult = $userObj->updateStatus();
            if ($updateResult) {
                switch ($_GET['page']) {
                    case 'login':
                    case 'register':
                        header('location:login.php');
                        die;
                    default:
                        header('location:set-new-password.php');
                        die;
                }
            }
        }
    }
}
?>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> Verify Code </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="number" name="code" placeholder="Code">
                                        <?php
                                        if (!empty($codeValidationResult)) {
                                            foreach ($codeValidationResult as $key => $error) {
                                                echo $error;
                                            }
                                        }
                                        if (isset($checkResult) && empty($checkResult)) {
                                            echo "<div class='alert alert-danger'>Wrong Code</div>";
                                        }
                                        if (isset($updateResult) && !($checkResult)) {
                                            echo "<div class='alert alert-danger'>Something Went Wrong</div>";
                                        }
                                        ?>
                                        <div class="button-box">
                                            <button type="submit"><span>Check</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer style Start -->
<?php
include_once 'layouts/footer.php'
?>