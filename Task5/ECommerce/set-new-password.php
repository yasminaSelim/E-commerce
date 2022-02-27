<?php
$title = 'Set New Password';
include_once 'layouts/header.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/database/models/User.php';
include_once 'app/requests/registerRequest.php';
if ($_POST) {
    $Validation = new registerRequest();
    $Validation->setPassword($_POST['password']);
    $Validation->setConfirmPassword($_POST['confirm_password']);
    $passwordValidation = $Validation->passwordValidation();
    $confirmPasswordValidation = $Validation->confirmPasswordValidation();
    $confirmPasswordEqualPassword = $Validation->confirmPasswordEqualPassword();
    if (
        empty($passwordValidation) &&
        empty($confirmPasswordValidation) &&
        empty($confirmPasswordEqualPassword)
    ) {
        $user = new User();
        $user->setPassword($_POST['password']);
        $user->setEmail($_SESSION['user_email']);
        $passwordResult = $user->updatePassword();
        if ($passwordResult) {
            header('Location:login.php');
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
                            <h4> Set New Password </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?php
                                    if (isset($passwordResult)&& !$passwordResult) {
                                        echo "<div class='alert alert-danger'>Something Went Wrong</div>";
                                    }
                                    ?>
                                    <form method="post">
                                        <input type="password" name="password" placeholder="Password">
                                        <?php
                                        if (!empty($passwordValidation)) {
                                            echo $passwordValidation[
                                                'password_required'
                                            ];
                                        }
                                        if (
                                            isset(
                                                $confirmPasswordEqualPassword[
                                                    'password_pattern'
                                                ]
                                            )
                                        ) {
                                            echo $confirmPasswordEqualPassword[
                                                'password_pattern'
                                            ];
                                        }
                                        ?>
                                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                                        <?php
                                        if (
                                            !empty($confirmPasswordValidation)
                                        ) {
                                            echo $confirmPasswordValidation[
                                                'confirmPassword_required'
                                            ];
                                        }
                                        if (
                                            isset(
                                                $confirmPasswordEqualPassword[
                                                    'notmatched'
                                                ]
                                            )
                                        ) {
                                            echo $confirmPasswordEqualPassword[
                                                'notmatched'
                                            ];
                                        }
                                        ?>
                                        <div class="button-box">
                                            <button type="submit"><span>Update</span></button>
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
