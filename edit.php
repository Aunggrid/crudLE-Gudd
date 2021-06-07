<?php  
require_once('connection.php');
if (isset($_REQUEST['update_id'])) {
    try {
        $id = $_REQUEST['update_id'];
        $select_stmt = $db->prepare("SELECT * FROM tb_mooc WHERE mooc_id = :id");
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
    } catch(PDOException $e) {
        $e->getMessage();
    }
}
if (isset($_REQUEST['btn_update'])) {
    $moocid_up = $_REQUEST['txt_id']; 
    $moocimg_up = $_REQUEST['txt_images']; 
    $moocname_up = $_REQUEST['txt_name'];
    $moocyear_up = $_REQUEST['txt_year'];
    $moocpay_up = $_REQUEST['Pay'];
    $moocprice_up = $_REQUEST['txt_course_price'];
    $moocorder_up = $_REQUEST['txt_order'];
    $moocdiscount_up = $_REQUEST['txt_course_discount'];
    $mooccsproject_up = $_REQUEST['txt_project'];
    $mooccsconfirm_up = $_REQUEST['txt_confirm'];
    $moocpreview_up = $_REQUEST['txt_preview'];
    

    if (empty($moocname_up)) {
        $errorMsg = "Please Enter Fisrtname";
    } else if (empty($moocyear_up)) {
        $errorMsg = "Please Enter Lastname";
    } else {
        try {
            if (!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE tb_mooc SET mooc_id = :mid_up,mooc_name = :mname_up, mooc_course_year = :myear_up,
                 mooc_pay = :mpay_up, mooc_course_price =:mprice_up,mooc_images =:img_up ,mooc_order = :morder_up,
                 mooc_course_discount = :mdiscount_up ,cs_project_mooc_id = :mproject_up ,
                 cs_project_confirm = :mconfirm_up ,preview = :mpreview WHERE mooc_id = :id");
                $update_stmt->bindParam(':mid_up', $moocid_up);
                $update_stmt->bindParam(':mname_up', $moocname_up);
                $update_stmt->bindParam(':myear_up', $moocyear_up);
                $update_stmt->bindParam(':mpay_up', $moocpay_up);
                $update_stmt->bindParam(':mprice_up', $moocprice_up);
                $update_stmt->bindParam(':img_up', $moocimg_up);
                $update_stmt->bindParam(':morder_up', $moocorder_up);
                $update_stmt->bindParam(':mdiscount_up', $moocdiscount_up);
                $update_stmt->bindParam(':mproject_up', $mooccsproject_up);
                $update_stmt->bindParam(':mconfirm_up', $mooccsconfirm_up);
                $update_stmt->bindParam(':mpreview', $moocpreview_up );
                $update_stmt->bindParam(':id', $id);
                
                $connect = mysqli_connect("localhost","root","","lifelong_db");
                $check_dup_order="SELECT mooc_order FROM tb_mooc WHERE mooc_order = $moocorder_up ";
                $result_3 = (mysqli_query($connect,$check_dup_order));
                $count_dup_order = mysqli_num_rows($result_3);
                
                $order_stmt_npm = $db->prepare("UPDATE tb_mooc
                SET mooc_order = mooc_order - 1
                WHERE mooc_order IN (SELECT mooc_order FROM tb_mooc where mooc_order IN (
                SELECT mooc_order FROM tb_mooc where mooc_order BETWEEN $mooc_order and $moocorder_up))  ");
                 
                $order_stmt_mpn = $db->prepare("UPDATE tb_mooc
                 SET mooc_order = mooc_order + 1
                 WHERE mooc_order IN (SELECT mooc_order FROM tb_mooc where mooc_order IN (
                 SELECT mooc_order FROM tb_mooc where mooc_order BETWEEN $moocorder_up and $mooc_order ))  ");
                
                
                $check_dup_order_2="SELECT mooc_order FROM tb_mooc WHERE mooc_order >= $mooc_order ";
                $result_3_2 = (mysqli_query($connect,$check_dup_order_2));
                $count_dup_order_2=mysqli_num_rows($result_3_2);
                $ng = $count_dup_order_2   ;
                $n2 = $count_dup_order - $ng;
                $nz= $moocorder_up - $mooc_order;
                if($count_dup_order != 0){

                if ($nz != 0){
                   
                    if($nz > 0){
                        $order_stmt_npm->execute();

                       // npm;

                   }
                   if($nz < 0){
                    $order_stmt_mpn->execute();

                       //mpn;

                }
            }
              
               
            }

                if ($update_stmt->execute()) {
                    
                    $UpdateMsg = "Record update successfully...";
                    header("refresh:1;index.php");
                    echo "<script> console.log($count_dup_order);</script>";
                    echo "<script> console.log($ng);</script>";
                    echo "<script> console.log($nz);</script>";
                }

            }
        } catch(PDOException $e) {
            
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
    <link rel="stylesheet" href="assets/css/styleedit.css">
    <script src="assets\js\jQuery\jquery-3.6.0.min.js"></script>
    
    
    
  <h1><center></center></ha>
    
</head>
<body>
<div class="display-3 text-center">Edit Course "<?php echo $id; ?>"</div>
    <div class="container justify-content-md-center">
<?php
 if(isset($errorMsg)){
?>

<div class="alert alert-danger">
    <strong>ผิดพลาด! <?php echo $errorMsg;?><a class="btn btn-primary" onclick="back()" role="button">กลับไปแก้ไข</a></strong>
</div>

 <?php } ?>
 
 <?php
 if(isset($UpdateMsg)){
?>
<div class="alert alert-success">
    <strong>สำเร็จ!!! <?php echo $UpdateMsg; ?></strong>
</div>

 <?php } ?>

 <form method="post" name='upform' class="form-horizontal mt-5"onsubmit="return validateForm()" >
 <div class="container">
 <div class="form-group text-center">

<div class="row">
<label for="mooc_id" class="col-sm-3 control-label">ID</label>
<div class="col-sm-6">
<input type='text' readonly="readonly"  name="txt_id" class="form-control" value="<?php echo $mooc_id; ?>" id="txt_id" >
</div>
</div>

     
            <div class="form-group text-center">
                <div class="row">
                    <label for="mooc_name" class="col-sm-3 control-label">ชื่อคอร์ส</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_name" class="form-control" value="<?php echo $mooc_name; ?>">
                    </div>
                </div>
            
                <div class="form-group">
 <div class="row">
    <label for="mooc_course_year" class="col-sm-3 control-label">ปี</label>
    <div class="col-sm-6">
         
        <select type='text' name="txt_year"class="form-select" value="<?php echo $mooc_course_year; ?>">
 
  <option value="2022">2022</option>
  <option value="2021">2021</option>
  <option value="2020">2020</option>
  <option value="1999">2019</option>
</select>
        </div>
        
 </div>
 <div class="form-group">
 <div class="row">
    <label for="mooc_images" class="col-sm-3 control-label">URL รูปภาพ</label>
    <div class="col-sm-6">
        <input type='text' name="txt_images" class="form-control" value="<?php echo $mooc_images; ?>"  id="txt_images">   </div>
 </div>
 <label style="margin-right: 75%;" class="col-sm-3 control-label">รูปภาพปัจจุบัน</label>
 
 
     <img  class="previewpic" style="width: 150px;height:100px;margin-left: 25%;padding-top:-35%;
     margin-top:-3.4%;" src="<?php echo $mooc_images ?>">
 
           
            <div class="form-group ">
                <div class="row">
                    <label for="mooc_order" class="col-sm-3 control-label">ลำดับ</label>
                    <div class="col-sm-6">
                        <input type="text" name="txt_order" class="form-control" value="<?php echo $mooc_order; ?>">
                    </div>
                </div>
            </div></div></div>
            
            <div  class="form-group text-center ">
                <div  class="payalingwtf">
            <div class="row">
            <div class="Pay-text">ค่าใช้จ่าย</div>
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
</div></div>
<div class="paiddetail" id="paiddetail"style="display:none;" >
<div class="form-group">
 <div class="row row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
    <label style="font-size: 18px;" for="mooc_course_price" class="col control-label"><b>ราคาคอร์ส</b></label>
    <div class="col-sm-6">
        <input type='text' name="txt_course_price" class="form-control" value="<?php echo $mooc_course_price; ?>"id="txt_course_price">  </div>
 </div>
 <div class="form-group">
 <div class="row row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
    <label style="font-size: 18px;" for="mooc_course_discount" class="col control-label"><b>ส่วนลด</b></label>
    <div class="col-sm-6">
        <input type='text' name="txt_course_discount" class="form-control" value="<?php echo $mooc_course_discount; ?>"id="txt_course_discount">  </div>
 </div>
</div></div></div></div></div>



            <div class="cscontrol">
             <div class="P_P">
            <div class="form-group">
 <div class="row ">
    <label for="cs_project_mooc_id" class="col control-label">Project id</label>
    <div class="col-sm-6">
        <input style="margin-left: -63%;" type='text' name="txt_project" class="form-control" value="<?php echo $cs_project_mooc_id; ?>" id="txt_project" maxlength="6">  </div>
 </div>
 <div class="form-group">
 <div class="row">
    <label for="cs_project_confirm" class="col control-label">การอนุมัติ</label>
    <div class="col-sm-6">
         
        <select style="margin-left: -63%;" type='text' name="txt_confirm"class="form-select" value="<?php echo $cs_project_mooc_id; ?>" id="txt_confirm">
        <option value="<?php echo $cs_project_confirm; ?>">ค่าเดิม(<?php echo $cs_project_confirm; ?>)</option>
        <option value="0">ไม่ต้องอนุมัติ(0)</option>
  <option value="1">อนุมัติ(1)</option>
 
</select>
        </div>
        
 </div>
 <div class="form-group">
 <div class="row">
    <label for="preview" class="col control-label">เเสดงผล</label>
    <div class="col-sm-6">
         
        <select style="margin-left: -63%;" type='text' name="txt_preview"class="form-select" id="txt_preview">
 <option value="<?php echo $preview; ?>">ค่าเดิม(<?php echo $preview; ?>) </option>
  <option value="0">ไม่ต้องแสดง(0)</option>
  <option value="1">แสดง(1)</option>
 
</select>
        </div></div></div></div>
        
 </div>
 </div>
            
            </div>


            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
            </div>

    </form>

    
    


    
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
         
        
         var name = document.forms['upform']['txt_name'].value;
         var imgg = document.forms['upform']['txt_images'].value;
         var proid = document.forms['upform']['txt_project'].value;

          if(name.length > 255){
            swal("CMU Mooc","ค่าในช่อง ('Name') ผิด(สูงสุด  255 ตัวอักษร)ค่าของคุณคือ "+ name.length);
             return false;
         }else if(!!pattern.test(imgg) == false){
            swal("CMU Mooc","ค่าในช่อง('URL รูปภาพ') ผิด  (ใส่Linkเท่านั้น)");
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