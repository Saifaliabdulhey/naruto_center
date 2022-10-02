<?php
include('./admin/inc/config.php');
$partialStates = $_POST['partialState'];
$query = 'SELECT * FROM tbl_product WHERE p_name LIKE "%' . $partialStates . '%"';
$mysqli = new mysqli("localhost", "root", "", "ecommerceweb");
if ($mysqli->connect_errno) {
    echo "Keine Verbindung mit MySQL. :/";
}
if (!empty($partialStates)) {
    $result = $mysqli->query($query);
    $data = $result->fetch_all();
    foreach ($data as $row) {
?>
        <a href="product.php?id=<?php echo $row[0]; ?>">
            <div style="display:flex; margin: 5px; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:600;">
                <div> <span><img style="width:100px; border-radius:7px; margin-right:5px; margin-top:8px;" src="assets/uploads/<?php echo $row[5] ?>" /></span></div>
                <div style="display:flex; flex-direction:column;">
                    <a href="product.php?id=<?php echo $row[0]; ?>" style="margin:30px 5px; text-decoration:none; color:white;"><?php echo $row[1] ?>
                    </a>
                    <div style="display:flex; align-items:center; color:white; margin-top:-20;">
                        <s style="margin-left:10px;">$<?php echo $row[2]; ?></s>
                        <h4 style="margin-left:10px;">$<?php echo $row[3]; ?></h4>
                    </div>
                </div>
            </div>
        </a>
        <div style="height:1px; width:100%; background:#ffffff45; border-radius: 50px;"></div>
<?php

    }
}
?>