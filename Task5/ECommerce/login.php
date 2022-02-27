<?php
$title = 'Login';
include_once 'layouts/header.php';
include_once 'app/middleware/guest.php';
include_once 'layouts/nav.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/requests/registerRequest.php';
include_once 'app/database/models/User.php';
if ($_POST) {
    $Validation = new registerRequest();
    $Validation->setEmail($_POST['email']);
    $emailResult = $Validation->emailValidation();
    $Validation->setPassword($_POST['password']);
    $passwordValidation = $Validation->passwordValidation();
    $passwordPatternValidation = $Validation->passwordPattern();
    if (
        empty($emailResult) &&
        empty($passwordValidation) &&
        empty($passwordPatternValidation)
    ) {
        //get user from database}
        $userObj = new User();
        $userObj->setEmail($_POST['email']);
        $userObj->setPassword($_POST['password']);
        $loginResult = $userObj->login();
        if ($loginResult) {
            // print_r($loginResult);
            $loginData = $loginResult->fetch_object();
            switch ($loginData->status) {
                case '1':
                    $_SESSION['user'] = $loginData;
                    // print_r($_POST);die;
                    if (isset($_POST['remember_me'])) {
                        setcookie("user", $_POST['email'], time() + (86400 * 30), "/"); // 86400 = 1 day
                    }
                    header('location:index.php');
                    die();
                case '0':
                    $_SESSION['user_email'] = $_POST['email'];
                    header('location:verify_code.php?page=login');
                    die();
            }
        } else {
            $msg =
                "<div class='alert alert-danger'>Wrong Email Or The Account Doesn't Exist</div>";
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
                            <h4> login </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <?php if (isset($msg)) {
                                            echo $msg;
                                        } ?>
                                        <input type="email" name="email" placeholder="Email" value="<?php if (
                                                                                                        isset($_SESSION['user_email'])
                                                                                                    ) {
                                                                                                        echo $_SESSION['user_email'];
                                                                                                        unset($_SESSION['user_email']);
                                                                                                    } ?>">
                                        <?php if (!empty($emailResult)) {
                                            foreach ($emailResult as $value) {
                                                echo $value;
                                            }
                                        } ?>
                                        <input type="password" name="password" placeholder="Password">
                                        <?php
                                        if (!empty($passwordValidation)) {
                                            echo $passwordValidation['password_required'];
                                        }
                                        if (
                                            isset(
                                                $passwordPatternValidation['password_pattern']
                                            )
                                        ) {
                                            echo "<div class='alert alert-danger'>wrong Attempt</div>";
                                        }
                                        ?>
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox" name="remember_me">
                                                <label>Remember me</label>
                                                <a href="verify-email.php">Forgot Password?</a>
                                            </div>
                                            <button type="submit"><span>Login</span></button>
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
<?php include_once 'layouts/footer.php';
?>