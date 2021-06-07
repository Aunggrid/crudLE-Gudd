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
        
        $moocname_up = $_REQUEST['txt_name'];
        $moocyear_up = $_REQUEST['txt_year'];
        $moocpay_up = $_REQUEST['txt_pay'];
        $moocprice_up = $_REQUEST['txt_price'];
        $moocorder_up = $_REQUEST['txt_order'];
        $moocdiscount_up = $_REQUEST['txt_discount'];
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
                    $update_stmt = $db->prepare("UPDATE tb_mooc SET mooc_name = :mname_up, mooc_course_year = :myear_up,
                     mooc_pay = :mpay_up, mooc_course_price =:mprice_up ,mooc_order = :morder_up,
                     mooc_course_discount = :mdiscount_up ,cs_project_mooc_id = :mproject_up ,
                     cs_project_confirm = :mconfirm_up ,preview = :mpreview WHERE mooc_id = :id");
                    $update_stmt->bindParam(':mname_up', $moocname_up);
                    $update_stmt->bindParam(':myear_up', $moocyear_up);
                    $update_stmt->bindParam(':mpay_up', $moocpay_up);
                    $update_stmt->bindParam(':mprice_up', $moocprice_up);
                    $update_stmt->bindParam(':morder_up', $moocorder_up);
                    $update_stmt->bindParam(':mdiscount_up', $moocdiscount_up);
                    $update_stmt->bindParam(':mproject_up', $mooccsproject_up);
                    $update_stmt->bindParam(':mconfirm_up', $mooccsconfirm_up);
                    $update_stmt->bindParam(':mpreview', $moocpreview_up );
                    $update_stmt->bindParam(':id', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:0.5;index.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>

    <div class="container">
    <div class="display-3 text-center">Edit Course "<?php echo $id; ?>"</div>

    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal mt-5">
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="mooc_name" class="col-sm-3 control-label">Course name</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_name" class="form-control" value="<?php echo $mooc_name; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="mooc_course_year" class="col-sm-3 control-label">Year</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_year" class="form-control" value="<?php echo $mooc_course_year; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="mooc_pay" class="col-sm-3 control-label">Pay</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_pay" class="form-control" value="<?php echo $mooc_pay; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="mooc_order" class="col-sm-3 control-label">Order</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_order" class="form-control" value="<?php echo $mooc_order; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="mooc_course_price" class="col-sm-3 control-label">Price</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_price" class="form-control" value="<?php echo $mooc_course_price; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="mooc_course_discount" class="col-sm-3 control-label">Discount</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_discount" class="form-control" value="<?php echo $mooc_course_discount; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="cs_project_mooc_id" class="col-sm-3 control-label">Project ID</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_project" class="form-control" value="<?php echo $cs_project_mooc_id; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="cs_project_confirm" class="col-sm-3 control-label">Project Confirm</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_confirm" class="form-control" placeholder="(0 = ไม่ต้องอนุมัติ ,1 = อนุมัติ)">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row">
                    <label for="preview" class="col-sm-3 control-label">Preview</label>
                    <div class="col-sm-9">
                        <input type="text" name="txt_preview" class="form-control" placeholder="(0 = ไม่แสดงผล , 1= แสดงผล)">
                    </div>
                </div>
            </div>


            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="index.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>


    </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>