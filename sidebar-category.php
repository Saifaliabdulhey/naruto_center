
<!--  -->
    <div id="left" class="span3">

        <ul id="menu-group-1" class="nav menu">
            <?php
                $i=0;
                if($_SESSION['lang'] == 'en') {
                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                } else if($_SESSION['lang'] == 'ar') {
                    $statement = $pdo->prepare("SELECT * FROM tbl_top_arabic WHERE show_on_menu=1");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                }
                foreach ($result as $row) {
                    $i++;
                    ?>
                    <li class="cat-level-1 deeper parent">
                        <a style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700; background: rgb(98,0,255); border:none; border-radius: 20px;" class="" href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category">
                            <span style="background:none;" data-toggle="collapse" data-parent="#menu-group-1" href="#cat-lvl1-id-<?php echo $i; ?>" class="sign"><i  class="fa fa-plus"></i></span>
                            <span   class="lbl"><?php echo $row['tcat_name']; ?></span>                      
                        </a>
                        <ul class="children nav-child unstyled small collapse" id="cat-lvl1-id-<?php echo $i; ?>">
                            <?php
                            if($_SESSION['lang'] == 'en') {
                                $j=0;
                                $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                                $statement1->execute(array($row['tcat_id']));
                                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                            } else if($_SESSION['lang'] == 'ar') {
                                $j=0;
                                $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_arabic_category WHERE tcat_id=?");
                                $statement1->execute(array($row['tcat_id']));
                                $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                            }
                            foreach ($result1 as $row1) {
                                $j++;
                                ?>
                                <li class="deeper parent">
                                    <a  class="" href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category">
                                        <span style="background:none; color:black;" data-toggle="collapse" data-parent="#menu-group-1" href="#cat-lvl2-id-<?php echo $i.$j; ?>" class="sign"><i class="fa fa-plus"></i></span>
                                        <span style="background:none; color:black;"  class="lbl lbl1"><?php echo $row1['mcat_name']; ?></span> 
                                    </a>
                                    <ul class="children nav-child unstyled small collapse" id="cat-lvl2-id-<?php echo $i.$j; ?>">
                                        <?php
                                            $k=0;
                                            $statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
                                            $statement2->execute(array($row1['mcat_id']));
                                            $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result2 as $row2) {
                                                $k++;
                                                ?>
                                                <li class="item-<?php echo $i.$j.$k; ?>">
                                                    <a style="background:none; color:black;"  class="" href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category">
                                                        <span class="sign"></span>
                                                        <span style="background:none; color:black;"  class="lbl lbl1"><?php echo $row2['ecat_name']; ?></span>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
            ?>
        </ul>

    </div>