<?php
$title = 'Register';
include_once 'layouts/header.php';
include_once 'app/middleware/guest.php';
include_once 'layouts/nav.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/requests/registerRequest.php';
include_once 'app/database/models/User.php';
include_once 'app/mail/sendMAil.php';
if ($_POST) {
    $Validation = new registerRequest();
    $Validation->setEmail($_POST['email']);
    $emailResult = $Validation->emailValidation();
    // email & phone must be unique in database
    $emailExistsResult = $Validation->emailExists();
    $Validation->setPhone($_POST['phone']);
    $phoneExistsResult = $Validation->phoneExists();
    $Validation->setPassword($_POST['password']);
    $Validation->setConfirmPassword($_POST['confirm_password']);
    $passwordValidation = $Validation->passwordValidation();
    $confirmPasswordValidation = $Validation->confirmPasswordValidation();
    $confirmPasswordEqualPassword = $Validation->confirmPasswordEqualPassword();
    if (
        empty($passwordValidation) &&
        empty($emailResult) &&
        empty($confirmPasswordValidation) &&
        empty($confirmPasswordEqualPassword) &&
        empty($emailExistsResult) &&
        empty($phoneExistsResult)
    ) {
        //insert into database
        $code = rand(10000, 99999);
        $user = new User();
        $user->setName($_POST['full_name']);
        $user->setGender($_POST['gender']);
        $user->setPhone($_POST['phone']);
        $user->setEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setCode($code);
        $result = $user->create();
        if ($result) {
            //check email //send code
            $subject = 'Ecommerce Verification Code';
            $body = "<p>Hello {$_POST['full_name']}</p><p>Your Verification Code Is : <b>$code</b></p>";
            $mail = new sendMail($_POST['email'], $subject, $body);
            $mailresult = $mail->send();
            if ($mailresult) {
                //header to verify code
                $_SESSION['user_email'] = $_POST['email'];
                header('location:verify_code.php?page=register');
                die();
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
                        <a class="active" data-toggle="tab" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?php
                                    if (isset($result)) {
                                        if (!$result) {
                                            echo "<div class='alert alert-danger'>Try Again Later</div>";
                                        }
                                    }
                                    if (isset($mailresult) && !$mailresult) {
                                        echo "<div class='alert alert-danger'>Try Again Later , Something Went Wrong</div>";
                                    }
                                    ?>
                                    <form action="#" method="post">
                                        <input type="text" name="full_name" placeholder="User Full name" value="<?= isset(
                                            $_POST['full_name']
                                        )
                                            ? $_POST['full_name']
                                            : '' ?>">
                                        <input name="email" placeholder="Email" type="email" value="<?= isset(
                                            $_POST['email']
                                        )
                                            ? $_POST['email']
                                            : '' ?>">
                                        <?php
                                        if (!empty($emailResult)) {
                                            foreach ($emailResult as $value) {
                                                echo $value;
                                            }
                                        }
                                        if (!empty($emailExistsResult)) {
                                            foreach (
                                                $emailExistsResult
                                                as $value
                                            ) {
                                                echo $value;
                                            }
                                        }
                                        ?>
                                        <input name="phone" placeholder="Phone" type="tel" value="<?= isset(
                                            $_POST['phone']
                                        )
                                            ? $_POST['phone']
                                            : '' ?>">
                                        <?php if (!empty($phoneExistsResult)) {
                                            foreach (
                                                $phoneExistsResult
                                                as $value
                                            ) {
                                                echo $value;
                                            }
                                        } ?>
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
                                        <select name="gender" class="form-control">
                                            <option value="m" <?= isset(
                                                $_POST['gender']
                                            ) && $_POST['gender'] == 'm'
                                                ? 'selected'
                                                : '' ?>>Male</option>
                                            <option value="f" <?= isset(
                                                $_POST['gender']
                                            ) && $_POST['gender'] == 'f'
                                                ? 'selected'
                                                : '' ?>>Female</option>
                                        </select>
                                        <div class="button-box mt-5">
                                            <button type="submit"><span>Register</span></button>
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
<?php include_once 'layouts/footer.php';
?>
