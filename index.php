
<?php 

    require_once('connection.php');

  

      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/boostrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/Responsive/css/responsive.dataTables.min.css">
    
    
</head>
<body>
  <div id="page-wrap">

    
    <div class="display-3 text-center">LE</div>
    
  

  <div class="container">
  <div class="row">
  <div class="col-lg-12">
  <a id="addbtn" href="add.php"><button type="button" class="btn btn-success mb-3 d-inline-flex p-2 bd-highlight" >
  ADD(+)</button></a>
  <table id="LE-table" class="table display" cellspacing="0">
        <thead>
            <tr>
               <th></th>
                <th></th>
                <th>ID</th>
                <th>ชื่อคอร์ส</th>
                <th >ปี</th>
                <th>รูปภาพ</th>
                <th style="width: 70px;">ค่าใช้จ่าย</th>
                <th>Order</th>
                <th>ราคา</th>
                <th>ส่วนลด</th>
                <th class="none">ID โปรเจต:</th>
                <th class="none">การอนุมัติ:</th>
                <th class="none">การเเสดงผล:</th>

               
            </tr>
        </thead>

        <tbody>
            <?php 
                $select_stmt = $db->prepare("SELECT * FROM tb_mooc");
                $select_stmt->execute();

                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>

                <tr>
                <td><a href="edit.php?update_id=<?php echo $row["mooc_id"]; ?>" button type="button" class="btn btn-warning">Edit</a></td>
                      
                
                    <td><a href="delete.php?delete_id=<?php echo $row["mooc_id"]; ?>" class="btn btn-danger">Delete</a></td>
                <td><?php echo $row['mooc_id']; ?> </td>
                    <td><div style="width :200px"><?php echo $row["mooc_name"]; ?></div></td>
                    <td><?php echo $row["mooc_course_year"]; ?></td>
                    <td><img style="width: 200px;height:160px;" src='<?php echo $row["mooc_images"]; ?>'></td>
                    <td><?php 
                       if($row["mooc_pay"]==0){
                      $payval ='คอร์สฟรี';
                    }else{
                      $payval ='คอร์สเสียเงิน';
                    } 
                    echo $payval ?></td>
                    <td><?php echo $row["mooc_order"]; ?></td>
                    <td><?php echo $row['mooc_course_price'];echo" บาท"; ?> </td>
                    <td><?php echo $row['mooc_course_discount'];echo" บาท"; ?> </td>
                    <td><?php echo $row['cs_project_mooc_id']; ?> </td>
                    <td><?php 
                     if($row["cs_project_confirm"]==0){
                      $conval ='ไม่อนุมัติ';
                    }else{
                      $conval ='อนุมัติ';
                    } 
                    echo $conval; ?> </td>
                    <td><?php 
                    if($row["preview"]==0){
                      $preval ='ไม่ต้องเเสดงผล';
                    }else{
                      $preval ='เเสดงผล';
                    } ;
                    
                    
                    echo $preval; ?> </td>

                    
                   
                </tr>
                         
            <?php } ?>
        </tbody>
    </table>
    
  
  </div>
  
  </div>
  
  </div>
 


    <!-- Modal -->
<div class="modal fade" id="ADDCourse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ADDCourse" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ADDCourse">ADD NEW COURSE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     <?php include "add.php"; 
     
      
      
     ?>
     

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
  
</div>
<!-- Modal Edit COURSE -->
<div class="modal fade" id="EditCourse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditCourse" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditCourse">Edit COURSE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     <?php include "edit.php"; 
     
      
      
     ?>
     

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
  
</div>

    
    
<script src="assets\js\jQuery\jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script> $(document).ready(function() {
        $('#LE-table').DataTable({
          responsive: true,
            "order": [[ 7, "asc" ]],
        "columnDefs":[{
       "targets": [0,1,5],
       "orderable":false
        }]
      } );
    } )
    ;     </script>
 
<script src="assets/js/bootstrap/bootstrap.bundle.js"></script>
<script src="assets/Responsive/js/dataTables.responsive.min.js"></script>
  </div>
</body>
</html>