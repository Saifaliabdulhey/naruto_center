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
       <span><img style="width:100px;" src="assets/uploads/<?php echo $row[5]?>"/></span> <a style="margin:30px 5px;" href="product.php?id=<?php echo $row[0]; ?>"><?php echo $row[1] ?></a><br/><hr/>

        <?php
        
    }
}
?>
