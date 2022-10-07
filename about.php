<?php require_once('header.php'); ?>

<?php
if($_SESSION['lang'] == 'en') {
    $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);   
}else if($_SESSION['lang'] == 'ar') {
    $statement = $pdo->prepare("SELECT * FROM tbl_arabic_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);   
}                       
foreach ($result as $row) {
   $about_title = $row['about_title'];
    $about_content = $row['about_content'];
    $about_banner = $row['about_banner'];
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $about_banner; ?>);">
    <div class="inner">
        <h1><?php if($_SESSION['lang'] == 'en'){echo 'About Us';} else if($_SESSION['lang'] == 'ar') {echo 'حول  ناروتو';}?></h1>
    </div>
</div>

<div class="page">
    <div class="container" style="text-align:center;">
        <div class="row">            
            <div style="text-align:center; width:70%; margin:auto;">               
                <p>
                    <?php echo $about_content; ?>
                </p>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>