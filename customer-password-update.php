<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if (!isset($_SESSION['customer'])) {
    header('location: ' . BASE_URL . 'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'], 0));
    $total = $statement->rowCount();
    if ($total) {
        header('location: ' . BASE_URL . 'logout.php');
        exit;
    }
}
?>

<?php
if (isset($_POST['form1'])) {

    $valid = 1;

    if (empty($_POST['cust_password']) || empty($_POST['cust_re_password'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_138 . "<br>";
    }

    if (!empty($_POST['cust_password']) && !empty($_POST['cust_re_password'])) {
        if ($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139 . "<br>";
        }
    }

    if ($valid == 1) {

        // update data into the database

        $password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_password=? WHERE cust_id=?");
        $statement->execute(array(md5($password), $_SESSION['customer']['cust_id']));

        $_SESSION['customer']['cust_password'] = md5($password);

        $success_message = LANG_VALUE_141;
    }
}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3 style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" class="text-center">
                        <?php if ($_SESSION['lang'] == 'en') {
                            echo 'Update Password';
                        } else if ($_SESSION['lang'] == 'ar') {
                            echo 'تغيير الرمز';
                        } ?>
                    </h3>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <?php
                                if ($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $error_message . "</div>";
                                }
                                if ($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>" . $success_message . "</div>";
                                }
                                ?>
                                <div class="form-group">
                                    <label style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" for=""> <?php if ($_SESSION['lang'] == 'en') {
                                                                                                                                                echo 'New Password';
                                                                                                                                            } else if ($_SESSION['lang'] == 'ar') {
                                                                                                                                                echo 'الرمز الجديد';
                                                                                                                                            } ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" for=""> <?php if ($_SESSION['lang'] == 'en') {
                                                                                                                                                echo 'Retype New Password';
                                                                                                                                            } else if ($_SESSION['lang'] == 'ar') {
                                                                                                                                                echo 'اعد كتابة الرمز';
                                                                                                                                            } ?> *</label>
                                    <input type="password" class="form-control" name="cust_re_password">
                                </div>
                                <input style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" type="submit" class="btn btn-primary" value="                        <?php if ($_SESSION['lang'] == 'en') {
                                                                                                                                                                                                        echo 'Update';
                                                                                                                                                                                                    } else if ($_SESSION['lang'] == 'ar') {
                                                                                                                                                                                                        echo 'تطبيق';
                                                                                                                                                                                                    } ?>" name="form1">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>