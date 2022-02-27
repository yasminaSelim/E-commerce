<?php $title = 'My Account Profile';
include_once 'layouts/header.php';
include_once 'app/middleware/auth.php';
include_once 'layouts/nav.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/database/models/User.php';
include_once 'app/services/Media.php';
include_once 'app/requests/registerRequest.php';
include_once 'app/requests/registerRequest.php';
include_once 'app/mail/sendMAil.php';
$userObj = new User();
$Validation = new registerRequest();
$userObj->setEmail($_SESSION['user']->email);
$errors = [];
$success = [];
//update user info
if (isset($_POST['updateInfo'])) {
    if (
        empty($_POST['name']) ||
        empty($_POST['phone']) ||
        empty($_POST['gender'])
    ) {
        $errors['update_profile']['all_fields'] =
            "<div class='alert alert-danger'>All Fields Are Required</div>";
    } else {
        //print_r($_FILES['img']);die;
        if ($_FILES['image']['error'] == 0) {
            $media = new Media();
            $media->setImg($_FILES['image']);
            $mediaResult = $media
                ->sizeValidation(10 ** 6)
                ->extensionValidation(['png', 'jpg', 'jpeg'])
                ->uploadImg('users');
            if (empty($mediaResult->errors)) {
                $userObj->setImg($mediaResult->imgName);
            }
        }
        $userObj
            ->setName($_POST['name'])
            ->setPhone($_POST['phone'])
            ->setGender($_POST['gender']);
        $updateResult = $userObj->update();
        if ($updateResult) {
            $_SESSION['user']->name = $_POST['name'];
            $_SESSION['user']->phone = $_POST['phone'];
            $_SESSION['user']->gender = $_POST['gender'];
            $success['update_profile']['success'] =
                "<div class='alert alert-success'>All Fields Are Updated Successfully</div>";
        } else {
            $errors['update_profile']['error'] =
                "<div class='alert alert-danger'>Something Went Wrong</div>";
        }
    }
}
//update user password
if (isset($_POST['updatePassword'])) {
    $Validation->setPassword($_POST['oldPassword']);
    $oldPasswordValidation = $Validation->passwordValidation();
    if (empty($oldPasswordValidation)) {
        $oldPasswordPattern = $Validation->passwordPattern();
        if (empty($oldPasswordPattern)) {
            if (sha1($_POST['oldPassword']) != $_SESSION['user']->password) {
                $oldPasswordValidation['oldPassword'] =
                    "<div class='alert alert-danger'>Old Password Is Wrong</div>";
            }
        }
    }
    $Validation->setPassword($_POST['newPassword']);
    $Validation->setConfirmPassword($_POST['PasswordConfirm']);
    $passwordValidation = $Validation->passwordValidation();
    $confirmPasswordValidation = $Validation->confirmPasswordValidation();
    $confirmPasswordEqualPassword = $Validation->confirmPasswordEqualPassword();
    if (
        empty($passwordValidation) &&
        empty($confirmPasswordValidation) &&
        empty($confirmPasswordEqualPassword) &&
        empty($oldPasswordValidation) &&
        empty($oldPasswordPattern)
    ) {
        $userObj->setPassword($_POST['newPassword']);
        $passwordResult = $userObj->updatePassword();
        if ($passwordResult) {
            $success['updatePassword']['success'] =
                "<div class='alert alert-success'>Password Updated Successfully</div>";
        } else {
            $errors['update_password']['error'] =
                "<div class='alert alert-danger'>Something Went Wrong</div>";
        }
    }
}
if (isset($_POST['updateEmail'])) {
    $Validation->setEmail($_POST['newEmail']);
    $emailValidationResult = $Validation->emailValidation();
    // email & phone must be unique in database
    $emailExistsResult = $Validation->emailExists();
    if (empty($emailValidationResult) && empty($emailExistsResult)) {
        //insert into database
        $userObj->setEmail($_POST['newEmail']);
        $userObj->setStatus(0);
        $userObj->setId($_SESSION['user']->id);
        $result = $userObj->updateEmail();
        if ($result) {
            //check email //send code
            $page = "http://localhost/Task-5/ECommerce/change-email.php?email={$_POST['newEmail']}";
            $subject = 'Ecommerce Verification Code';
            $body = "<p>Hello {$_SESSION['user']->name}</p><p>To Confirm Your Email Please Click The Link :</p><div><a class='btn btn-success' href='$page'>Verify</a><p>Thank You</p></div>";
            $email = new sendMail($_POST['newEmail'], $subject, $body);
            $emailResult = $email->send();
        }
    }
}
//get user info
$userResult = $userObj->checkEmailExists();
if ($userResult) {
    $userDate = $userResult->fetch_object();
}
?>
<!-- my account start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse <?php if (
                                isset($_POST['updateInfo'])
                            ) {
                                echo 'show';
                            } ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>My Account Information</h4>
                                            <h5>Your Personal Details</h5>
                                        </div>
                                        <?php
                                        if (isset($errors['update_profile'])) {
                                            foreach (
                                                $errors['update_profile']
                                                as $key => $error
                                            ) {
                                                echo $error;
                                            }
                                        }
                                        if (
                                            isset(
                                                $success['update_profile'][
                                                    'success'
                                                ]
                                            )
                                        ) {
                                            echo $success['update_profile'][
                                                'success'
                                            ];
                                        }
                                        if (
                                            isset($mediaResult->errors) &&
                                            !empty($mediaResult->errors)
                                        ) {
                                            foreach (
                                                $mediaResult->errors
                                                as $key => $errors
                                            ) {
                                                echo $errors;
                                            }
                                        }
                                        ?>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="row m-5">
                                                <div class="col-lg-6 col-md-6 m-auto">
                                                    <div class="billing-info m-auto">
                                                        <img src="assets/img/users/<?= $userDate->img ?>" class="m-5 rounded-circle w-50 h-50">
                                                        <input type="file" name="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Name</label>
                                                        <input type="text" name="name" placeholder="Name" value="<?= $userDate->name ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Phone</label>
                                                        <input type="number" name="phone" placeholder="Phone" value="<?= $userDate->phone ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Gender</label>
                                                        <select name="gender" class="form-control">
                                                            <option value="m" <?= $userDate->gender ==
                                                            'm'
                                                                ? 'selected'
                                                                : '' ?>>Male</option>
                                                            <option value="f" <?= $userDate->gender ==
                                                            'f'
                                                                ? 'selected'
                                                                : '' ?>>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="updateInfo">Update Info</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse <?php if (
                                isset($_POST['updatePassword'])
                            ) {
                                echo 'show';
                            } ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                        </div>
                                        <?php
                                        if (
                                            isset($passwordResult) &&
                                            !$passwordResult
                                        ) {
                                            echo "<div class='alert alert-danger'>Something Went Wrong</div>";
                                        }
                                        if (isset($errors['update_password'])) {
                                            foreach (
                                                $errors['update_profile']
                                                as $key => $error
                                            ) {
                                                echo $error;
                                            }
                                        }
                                        if (
                                            isset(
                                                $success['updatePassword'][
                                                    'success'
                                                ]
                                            )
                                        ) {
                                            echo $success['updatePassword'][
                                                'success'
                                            ];
                                        }
                                        ?>
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>Old Password</label>
                                                        <input type="password" placeholder="Old Password" name="oldPassword">
                                                    </div>
                                                </div>
                                                <?php
                                                if (
                                                    !empty(
                                                        $oldPasswordValidation
                                                    )
                                                ) {
                                                    foreach (
                                                        $oldPasswordValidation
                                                        as $key => $value
                                                    ) {
                                                        echo $value;
                                                    }
                                                }
                                                if (
                                                    !empty($oldPasswordPattern)
                                                ) {
                                                    echo $oldPasswordPattern[
                                                        'password_pattern'
                                                    ];
                                                }
                                                ?>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>New Password</label>
                                                        <input type="password" placeholder="New Password" name="newPassword">
                                                    </div>
                                                </div>
                                                <?php
                                                if (
                                                    !empty($passwordValidation)
                                                ) {
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
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>New Password Confirm</label>
                                                        <input type="password" placeholder="New Password Confirm" name="PasswordConfirm">
                                                    </div>
                                                </div>
                                                <?php
                                                if (
                                                    !empty(
                                                        $confirmPasswordValidation
                                                    )
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
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="updatePassword">Update Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Change your Email </a></h5>
                            </div>
                            <div id="my-account-3" class="panel-collapse collapse <?php if (
                                isset($_POST['updateEmail']) || isset($SESSION['msg']))
                            {
                                echo 'show';
                            } ?>">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Email</h4>
                                            <h5>Your Email</h5>
                                        </div>
                                        <?php
                                        if ( isset($emailResult) && !$emailResult) {
                                            echo "<div class='alert alert-danger'>Try Again Later , Something Went Wrong</div>";
                                        }
                                        if ( isset($emailResult) &&$emailResult) {
                                            echo "<div class='alert alert-success'>Done , Check Your Email</div>";
                                            unset($_SESSION['user']);
                                            header('Refresh: 5; url=login.php');die;

                                        }
                                        if (isset($result)) {
                                            if (!$result) {
                                                echo "<div class='alert alert-danger'>Try Again Later</div>";
                                            }
                                        }
                                        if (isset($SESSION['msg'])) {
                                                echo  $SESSION['msg'];
                                                unset($SESSION['msg']);
                                        }
                                        ?>
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="billing-info">
                                                        <label>New Email</label>
                                                        <input type="email" placeholder="New Email" name="newEmail" value="<?= $userDate->email ?>">
                                                    </div>
                                                    <?php
                                                    if (!empty($emailResult)) {
                                                        foreach ($emailResult as $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    if (!empty($emailExistsResult)
                                                    ) {
                                                        foreach ($emailExistsResult as $value) {
                                                            echo $value;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="billing-back-btn">
                                                    <div class="billing-btn">
                                                        <button type="submit" name="updateEmail">Update Email</button>
                                                    </div>
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
</div>
<!-- my account end -->
<?php include_once 'layouts/footer.php';
?>
