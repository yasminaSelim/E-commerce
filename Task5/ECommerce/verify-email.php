<?php
$title = 'Verify Email';
include_once 'layouts/header.php';
include_once 'layouts/breadcrumb.php';
include_once 'app/requests/verifyCodeRequest.php';
include_once 'app/database/models/User.php';
include_once 'app/requests/registerRequest.php';
include_once 'app/mail/sendMAil.php';
if ($_POST) {
    $Validation = new registerRequest();
    $Validation->setEmail($_POST['email']);
    $emailResult = $Validation->emailValidation();
    if (empty($emailResult)) {
        $newCode = rand(10000, 99999);
        $user = new User();
        $user->setEmail($_POST['email']);
        $result = $user->checkEmailExists();
        if ($result) {
            $userDate = $result->fetch_object();
            $user->setCode($newCode);
            $resultCode = $user->updateCode();
            if ($resultCode) {
                $subject = 'Ecommerce Verification Code';
                $body = "<p>Hello {$userDate->name}</p><p>Your Verification Code Is : <b>$newCode</b></p>";
                $mail = new sendMail($_POST['email'], $subject, $body);
                $emailResult = $mail->send();
                if ($emailResult) {
                    $_SESSION['user_email'] = $_POST['email'];
                    header('location:verify_code.php?page=verify-email');
                    die();
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
                            <h4> Verify Email </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post">
                                        <input type="email" name="email" placeholder="Email">
                                      <?php
                                      if (!empty($emailResult)) {
                                          foreach ($emailResult as $value) {
                                              echo $value;
                                          }
                                      }
                                      if (isset($result) && empty($result)) {
                                          echo "<div class='alert alert-danger'>Email Doesn't Exist</div>";
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
<?php include_once 'layouts/footer.php';
?>
