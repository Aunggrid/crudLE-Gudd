<?php  
require_once('connection.php');
$backbtn = '<a class="btn btn-primary" href=\"javascript:history.go(-1)\">Link</a>';
if(isset($_REQUEST['btn_insert'])){
    $mooc_id = $_REQUEST['txt_id'];
    $mooc_name = $_REQUEST['txt_name'];
    $mooc_course_year = $_REQUEST['txt_year'];
    $mooc_pay = $_REQUEST['Pay'];
    $mooc_images = $_REQUEST['txt_images'];
    
    $mooc_course_price = $_REQUEST['txt_course_price'];
    $mooc_course_discount = $_REQUEST['txt_course_discount'];
    $cs_project_mooc_id = $_REQUEST['txt_project_mooc_id'];
    $cs_project_confirm = $_REQUEST['txt_project_confirm'];
    $preview = $_REQUEST['txt_preview'];
    $connect = mysqli_connect("localhost","root","","lifelong_db");
    $check_dup_id="SELECT mooc_id FROM tb_mooc WHERE mooc_id ='$mooc_id' ";
    $result_1 = (mysqli_query($connect,$check_dup_id));
    $count_dup_id = mysqli_num_rows($result_1);
    $check_dup_name="SELECT mooc_id FROM tb_mooc WHERE mooc_name ='$mooc_name' ";
    $result_2 = (mysqli_query($connect,$check_dup_name));
    $count_dup_name = mysqli_num_rows($result_2);
if (empty($mooc_id)){
        $errorMsg = "กรุณาใส่ ID ด้วย";
    }else if ($count_dup_id > 0){
        $errorMsg = "ID ซ้ำ";
    }else if (empty($mooc_name)){
        $errorMsg = "กรุณาใส่ ชื่อ ด้วย";
    }else if ($count_dup_name > 0){
        $errorMsg = "ชื่อ ซ้ำ";
    }else if (empty($mooc_course_year)){
        $errorMsg = "กรุณาใส่ ปี ด้วย";
    }else if (empty($mooc_images)){
        $errorMsg = "กรุณาใส่ Link รูปภาพ ด้วย";
    }else if (empty($cs_project_mooc_id)){
        $errorMsg = "กรุณาใส่ Project ด้วย";
    }else{
        try{
            if (!isset($errorMsg)){
                $insert_stmt = $db->prepare("INSERT INTO tb_mooc(mooc_id,mooc_name,mooc_course_year,mooc_pay,mooc_images,
                mooc_course_price,mooc_course_discount,cs_project_mooc_id,cs_project_confirm,preview) VALUES(:mid,:mname,:myear,:mpay,:mimg,:mprice,:mdiscount,:csid,:csconfirm,:preview)");
                $insert_stmt->bindParam(':mid', $mooc_id);
                $insert_stmt->bindParam(':mname', $mooc_name);
                $insert_stmt->bindParam(':myear', $mooc_course_year);
                $insert_stmt->bindParam(':mpay', $mooc_pay);
                $insert_stmt->bindParam(':mimg', $mooc_images);
                
                
                $insert_stmt->bindParam(':mprice', $mooc_course_price);
                $insert_stmt->bindParam(':mdiscount', $mooc_course_discount);
                $insert_stmt->bindParam(':csid', $cs_project_mooc_id);
                $insert_stmt->bindParam(':csconfirm', $cs_project_confirm);
                $insert_stmt->bindParam(':preview', $preview);

                
                
                 
                


                
                
            if($insert_stmt->execute()){
                
                $connect = mysqli_connect("localhost","root","","lifelong_db");
                $check_add_or="SELECT mooc_order FROM tb_mooc WHERE mooc_order >= 0 ";
                $result_addor = (mysqli_query($connect,$check_add_or));
                $count_add_or = mysqli_num_rows($result_addor);
                $orderval = $count_add_or;
                $orderval_2 = $count_add_or+1;
                
                $insertor_stmt=$db->prepare("UPDATE tb_mooc SET mooc_order = $orderval -1 WHERE mooc_order >  $orderval_2");
                $insertor_stmt->execute();


                $insertMsg="ทำการเพิ่มคอร์สำเร็จ กำลังกลับหน้าหลัก...." ;
                echo "<script> console.log($orderval);</script>";
                header("Refresh:2; url=index.php");
                
                
                
                
                
            }
            


            }

        } catch (PDOException $e){
            echo $e->getMessage();
            
        }

    }




}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/boostrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets\js\jQuery\jquery-3.6.0.min.js"></script>
    
    
    
  <h1><center>เพิ่มคอร์สใหม่!!</center></ha>
    
</head>
<body>
    
    <div class="container justify-content-md-center">
<?php
 if(isset($errorMsg)){
?>

<div class="alert alert-danger">
    <strong>ผิดพลาด! <?php echo $errorMsg;?><a class="btn btn-primary" onclick="back()" role="button"> กลับไปแก้ไข</a></strong>
</div>

 <?php } ?>
 
 <?php
 if(isset($insertMsg)){
?>
<div class="alert alert-success">
    <strong>สำเร็จ!!! <?php echo $insertMsg; ?></strong>
</div>

 <?php } ?>

 <form id='form' name='addform' onsubmit="return validateForm()" metod="post" class="form-label">
     <div class="form-group text-center">

         <div class="row">
    <label for="mooc_id" class="col control-label">ID</label>
    <div class="col-sm-6">
        <input type='text'  name="txt_id" class="form-control" placeholder="Enter Id....">
    </div>
 </div>
 <div class="form-group">
 <div class="row">
    <label for="mooc_name" class="col control-label">ชื่อคอร์ส</label>
    <div class="col-sm-6">
        <input type='text' name="txt_name" class="form-control" placeholder="Enter Name....">   </div>
 </div>
 <div class="form-group">
 <div class="row">
    <label for="mooc_course_year" class="col control-label">ปี</label>
    <div class="col-sm-6">
         
        <select type='text' name="txt_year"class="form-select">
  <option selected>เลือกปี</option>
  <option value="2022">2022</option>
  <option value="2021">2021</option>
  <option value="2020">2020</option>
  <option value="1999">2019</option>
</select>
        </div>
        
 </div>
 
 <div class="Pay-text">ค่าใช้จ่าย :</div>
 <div class="radioadjust1">
 <div class="form-check">
 
  <input class="form-check-input" type="radio" name="Pay" onclick="hidefunc2();" value="0" id="Pay2">
  <label class="form-check-label" for="mooc_pay">
    คอร์สฟรี
  </label>
</div>
<div>&nbsp;&nbsp;</div>

<div class="form-check">
  <input class="form-check-input" type="radio" name="Pay" value="1" onclick="hidefunc1();" id="Pay" >
  <label class="form-check-label" for="mooc_pay">
  คอร์สเสียเงิน
  </label>
</div></div></div>
<div id="paiddetail" style="display:none">
<div class="form-group">
 <div class="row">
    <label for="mooc_course_price" class="col control-label">ราคาคอร์ส</label>
    <div class="col-sm-6">
        <input type='text' name="txt_course_price" class="form-control" placeholder="Enter Price...."id="txt_course_price">  </div>
 </div>
 <div class="form-group">
 <div class="row">
    <label for="mooc_course_discount" class="col control-label">ส่วนลด</label>
    <div class="col-sm-6">
        <input type='text' name="txt_course_discount" class="form-control" placeholder="Enter Discount...."id="txt_course_discount">  </div>
 </div>
</div></div></div>
 <div class="form-group">
 <div class="row">
    <label for="mooc_images" class="col control-label">URL รูปภาพ</label>
    <div class="col-sm-6">
        <input type='text' name="txt_images" class="form-control" placeholder="Enter Image Link...."  id="txt_images">   </div>
 </div>

 <div class="form-group">
 <div class="row">
    <label for="cs_project_mooc_id" class="col control-label">Project mooc id</label>
    <div class="col-sm-6">
        <input type='text' name="txt_project_mooc_id" class="form-control" placeholder="Enter Project mooc ID...." id="txt_project_mooc_id" maxlength="6">  </div>
 </div>
 <div class="form-group">
 <div class="row">
    <label for="cs_project_confirm" class="col control-label">สถานะการอนุมัติ</label>
    <div class="col-sm-6">
         
        <select type='text' name="txt_project_confirm"class="form-select" id="txt_project_confirm">
  <option value="0">ไม่ต้องอนุมัติ</option>
  <option value="1">อนุมัติ</option>
 
</select>
        </div>
        
 </div>
 <div class="form-group">
 <div class="row">
    <label for="preview" class="col control-label">การเเสดงผล</label>
    <div class="col-sm-6">
         
        <select type='text' name="txt_preview"class="form-select" id="txt_preview" id="txt_preview">
  <option value="0">ไม่ต้องแสดง</option>
  <option value="1">แสดง</option>
 
</select>
        </div>
        
 </div>
 

 
 <div class="form-group">
     
    
    <center><div class="col-sm-6">
 <input type='submit'  name="btn_insert"  class="btn btn-success" value="insert"> 
        <a href="index.php" class="btn btn-danger">Close</a>
 </div></center>


 </form>
 </div>

 



    
 <script src="assets/js/bootstrap/bootstrap.bundle.js"></script>
 
 <script>
     function validateForm(){
        var pattern = new RegExp('^(https?:\\/\\/)?'+ 
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ 
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ 
    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ 
    '(\\?[;&a-z\\d%_.~+=-]*)?'+ 
    '(\\#[-a-z\\d_]*)?$','i'); 
    var regforprojectid = /^\d+$/;
         
         var id = document.forms['addform']['txt_id'].value;
         var name = document.forms['addform']['txt_name'].value;
         var imgg = document.forms['addform']['txt_images'].value;
         var proid = document.forms['addform']['txt_project_mooc_id'].value;

         if(id.length > 45){
             swal("CMU Mooc","ค่าในช่อง ('ID')ผิด (มากสุด ='45'ตัวอักษร) ความยาวที่ใส่มา = " + id.length);
             return false;
         }else if(name.length > 255){
            swal("CMU Mooc","ค่าในช่อง ('ชื่อคอร์ส') ผิด  (Max  = 255)ความยาวที่ใส่มา= "+ name.length);
             return false;
         }else if(!!pattern.test(imgg) == false){
            swal("CMU Mooc","ค่าในช่อง('URL รูปภาพ') ผิด  (ใส่ URL ของรูปภาพเท่านั้น)");
             return false;
         }else if(!!regforprojectid.test(proid) == false){
            swal("CMU Mooc","ค่าในช่อง ('Project mooc ID') ผิด (ใส่ตัวเลขเท่านั้น)");
             return false;
         }
         
     
     
     
     
    
     
        }


 </script>
 <script>
function hidefunc1() {
  var checkBox = document.getElementById("Pay");
  var text = document.getElementById("paiddetail");
  
  
  if (checkBox.checked == true){
    text.style.display = "block";
    
  } else {
     text.style.display = "none";
     
  }
}
</script>
<script>
function hidefunc2() {
  var checkBox = document.getElementById("Pay2");
  var text = document.getElementById("paiddetail");
  if (checkBox.checked == true){
    text.style.display = "none";
    document.getElementById("txt_course_price").value = "0";
    document.getElementById("txt_course_discount").value = "0";
  } else {
     text.style.display = "block";
  }
}
</script>
<script>
function back(){
    history.go(-1);
}
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>





