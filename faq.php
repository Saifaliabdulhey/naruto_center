<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $faq_title = $row['faq_title'];
    $faq_banner = $row['faq_banner'];
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $faq_banner; ?>);">
    <div class="inner">
        <h1><?php  if($_SESSION['lang']== 'en') {
            echo 'FAQ';
        } else if($_SESSION['lang']== 'ar'){
            echo 'التعليمات';
        }?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                
                <div class="panel-group" id="faqAccordion">                    

                    <?php
                    if($_SESSION['lang']== 'en') {
                        $statement = $pdo->prepare("SELECT * FROM tbl_faq");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);  
                    } else if($_SESSION['lang']== 'ar') {
                        $statement = $pdo->prepare("SELECT * FROM tel_faq_arabic");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);  
                    }                    
                    foreach ($result as $row) {
                        ?>
                        <div class="panel panel-default" style="<?php if($_SESSION['lang'] == 'en') {
                            echo 'direction:ltr';
                        } else if($_SESSION['lang'] == 'ar') {
                            echo 'direction:rtl';
                        }?>">
                            <div class="panel-heading accordion-toggle question-toggle collapsed" data-toggle="collapse" data-parent="#faqAccordion" data-target="#question<?php echo $row['faq_id']; ?>">
                                <h4 class="panel-title">
                                     <?php echo $row['faq_title']; ?>
                                </h4>
                            </div>
                            <div id="question<?php echo $row['faq_id']; ?>" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <h5><span class="label label-primary"><?php if($_SESSION['lang'] == 'en') {
                                        echo 'Answer';
                                    } else if($_SESSION['lang'] == 'ar') {
                                        echo 'الاجابة';
                                    }?></span></h5>
                                    <p>
                                        <?php echo $row['faq_content']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>