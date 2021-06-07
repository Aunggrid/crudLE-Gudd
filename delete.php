<?php  
require_once('connection.php');
if (isset($_REQUEST['delete_id'])) {
    try {
        $id = $_REQUEST['delete_id'];
        $select_stmt = $db->prepare("SELECT * FROM tb_mooc WHERE mooc_id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        
        
    } catch(PDOException $e) {
        $e->getMessage();
    }


    $connect = mysqli_connect("localhost","root","","lifelong_db");
    $check_del_or="SELECT mooc_order FROM tb_mooc WHERE mooc_order >= 0 ";
    $result_delor = (mysqli_query($connect,$check_del_or));
    $count_del_or = mysqli_num_rows($result_delor);
    $MAX = $count_del_or-1;
    $order_stmt_delor = $db->prepare("UPDATE tb_mooc
                SET mooc_order = mooc_order - 1
                WHERE mooc_order IN (SELECT mooc_order FROM tb_mooc where mooc_order IN (
                SELECT mooc_order FROM tb_mooc where mooc_order BETWEEN $mooc_order and $MAX))  ");
    echo "<script> console.log($MAX);</script>";
    echo "<script> console.log($mooc_order);</script>";
    

    if($MAX - $mooc_order != 0 ){
        
        $order_stmt_delor->execute();
        

    }
    $delete_stmt = $db->prepare('DELETE FROM tb_mooc WHERE mooc_id = :id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();


    
    
    header("refresh:0.0001;index.php");
    
   
                
}

?>