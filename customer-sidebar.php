<div  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" class="user-sidebar">
    <ul>
    <a  style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" href="dashboard.php"><button style="background: rgb(98,0,255); border:none;" class="btn btn-danger"><?php if($_SESSION['lang'] == 'en') {
        echo 'Settings';
    }else if ($_SESSION['lang'] == 'ar') {
        echo 'الاعدادات';
    } ?></button></a>
    <a href="customer-profile-update.php"><button style="background: rgb(98,0,255); border:none;" class="btn btn-danger"><?php if($_SESSION['lang'] == 'en') {
        echo 'Update Profile';
    }else if ($_SESSION['lang'] == 'ar') {
        echo 'تعديل الملف الشخصي';
    } ?></button></a>
        <a href="customer-billing-shipping-update.php"><button style="background: rgb(98,0,255); border:none;" class="btn btn-danger"><?php if($_SESSION['lang'] == 'en') {
        echo 'Update Shipping info';
    }else if ($_SESSION['lang'] == 'ar') {
        echo 'تعديل معلومات التسوق';
    } ?></button></a>
        <a href="customer-password-update.php"><button style="background: rgb(98,0,255); border:none;" class="btn btn-danger"><?php if($_SESSION['lang'] == 'en') {
        echo 'Update Password';
    }else if ($_SESSION['lang'] == 'ar') {
        echo 'تغيير الرمز';
    } ?></button></a>
        <a href="customer-order.php"><button style="background: rgb(98,0,255); border:none;" class="btn btn-danger"><?php if($_SESSION['lang'] == 'en') {
        echo 'Orders';
    }else if ($_SESSION['lang'] == 'ar') {
        echo 'الطلبات';
    } ?></button></a>
        <a href="logout.php"><button style="background: rgb(98,0,255); border:none;" class="btn btn-danger"><?php if($_SESSION['lang'] == 'en') {
        echo 'Logout';
    }else if ($_SESSION['lang'] == 'ar') {
        echo 'تسجيل الخروج';
    } ?></button></a>
    </ul>
</div>