<?php require $_SERVER['DOCUMENT_ROOT']."/science/car/auth/auth.php";?>
<?php require $_SERVER['DOCUMENT_ROOT']."/science/vendor/autoload.php";?>
<?php
date_default_timezone_set('Asia/Bangkok');
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
use App\Model\Car\Book;
use App\Model\Car\Position;
use App\Model\Car\Department;
use App\Model\Car\Choose;
use App\Model\Car\Car;
use App\Model\Car\Timebook;

if($_REQUEST['action']=='edit'){
    $bookObj = new Book;
    $book = $bookObj->getBookById($_REQUEST['id']);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจองรถ</title>
    <?php require $_SERVER['DOCUMENT_ROOT']."/science/car/components/link.php";?>
</head>
<body class="font-kanit">
    <div class="">
        <?php require $_SERVER['DOCUMENT_ROOT']."/science/car/components/navbar.php";?>

    </div>
    <div class="container">
        <?php //print_r($_SESSION);?>
        <div class="row mt-5">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5>แบบฟอร์ม<?php echo ($_REQUEST['action']=='edit') ? " แก้ไขข้อมูลขอใช้รถ" : " เพิ่มข้อมูลขอใช้รถ";?></h5>
                        
                    </div>
                        <div class="card-body">
                            <form action="save.php" method="get">
                                <input type="hidden" name="action" value="<?php echo ($_REQUEST['action']=='edit') ? "edit" : "add";?>">
                                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                                <p class="mt-3"><b>ผู้ขอ<?php //echo $_SESSION['p_id'];?> </b></p>
                                <hr>
                                <div class="row">
                                    <?php

                                    ?>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">ชื่อ</label>
                                            <input type="text" id="name" class="form-control" name="name" required value="<?php echo $_SESSION['name']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="surname"class="form-label">นามสกุล</label>
                                            <input type="text" id="surname" class="form-control" name="surname" required value="<?php echo $_SESSION['surname']; ?>"readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="position"class="form-label">ตำแหน่ง</label>
                                            <select class="form-select" aria-label="Default select example" id="position" name="position" required>
                                                <option  value="">เลือก</option>
                                                <?php
                                                    $positionObj = new Position;
                                                    $positions = $positionObj->getAllPosition(); 
                                                    foreach($positions as $position) {
                                                        $selected =($position['id']==$_SESSION['p_id']) ? 
                                                        "selected" : "disabled";
                                                        echo "
                                                        <option value='{$position['id']}' {$selected} >{$position['name']}</option>
                                                        ";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="department"class="form-label">สังกัด</label>
                                            <select class="form-select" aria-label="Default select example" id="department" name="department" required>
                                                <option value="">เลือก</option>
                                                <?php
                                                    $departmentObj = new Department;
                                                    $departments = $departmentObj->getAlldepartment(); 
                                                    foreach($departments as $department) {
                                                        $selected =($department['id']==$_SESSION['d_id']) ? 
                                                        "selected" : "disabled";
                                                        echo "
                                                        <option value='{$department['id']}' {$selected} >{$department['name']}</option>
                                                        ";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3"><b>รายละเอียดการเดินทาง</b></p>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="origin"class="form-label">จุดขึ้นรถ</label>
                                            <input type="text" class="form-control" id="origin" name="origin" required value="<?php echo $book['origin']; ?>" autofocus>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="destination"class="form-label">ขออนุญาตใช้รถไปที่ไหน</label>
                                            <input type="text" class="form-control" id="destination" name="destination" required value="<?php echo $book['destination']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="title"class="form-label">ขออนุญาตใช้รถเพื่อ</label>
                                            <input type="text" class="form-control" id="title" name="title" required value="<?php echo $book['title']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3 col-lg-2">
                                        <div class="form-group">
                                            <label for="count"class="form-label">จำนวนผู้เดินทาง</label>
                                            <input type="number" class="form-control" id="number" name="count" required value="<?php echo $book['count']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg">
                                        <div class="form-group">
                                            <label for="people"class="form-label">รายชื่อ</label>
                                            <textarea rows="<?php echo 5;?>" class="form-control" id="people" name="people" required><?php echo $book['people']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3"><b>วันที่ใช้รถ</b></p>
                                <hr>
                                <div class="row">
                                    <div class="col-6 col-sm-6 col-md-6 col-lg">
                                        <div class="form-group">
                                            <label for="datepicker"class="form-label">วันที่</label>
                                            <input type="text" id="datepicker" class="form-control" name="start_date" required autocomplete="off" value="<?php echo $book['start_date']; ?>" min="<?php echo date('Y-m-d');?>">
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                        <div class="form-group">
                                            <label for="start_time"class="form-label">เวลา</label>
                                            <select class="form-select" aria-label="Default select example" id="start_time" name="start_time" required>
                                                <option value="">เลือก</option>
                                                <?php
                                                    $timeObj = new Timebook;
                                                    $times = $timeObj->getAlltime(); 
                                                    foreach($times as $time) {
                                                        $selected =($time['time'].":00"==$book['start_time']) ? 
                                                        "selected" : "";
                                                        echo "
                                                        <option value='{$time['time']}' {$selected} >{$time['time']}</option>
                                                        ";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg">
                                        <div class="form-group">
                                            <label for="datepicker2"class="form-label">ถึงวันที่</label>
                                            <input type="text" id="datepicker2" class="form-control" name="end_date" required autocomplete="off" value="<?php echo $book['end_date']; ?>" min="<?php echo date('Y-m-d');?>">
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-2">
                                        <div class="form-group">
                                            <label for="end_time"class="form-label">เวลา</label>
                                            <select class="form-select" aria-label="Default select example" id="end_time" name="end_time" required>
                                                <option value="">เลือก</option>
                                                <?php
                                                    // $timeObj = new Timebook;
                                                    $times = $timeObj->getAlltime(); 
                                                    foreach($times as $time) {
                                                        $selected =($time['time'].":00"==$book['end_time']) ? 
                                                        "selected" : "";
                                                        echo "
                                                        <option value='{$time['time']}' {$selected} >{$time['time']}</option>
                                                        ";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                               
                                <p class="mt-3"><b>ความประสงของผู้ใช้รถ</b></p>
                                <hr>
                                <div class="row">
                                    <?php
                                        if($book['provin']=='Yes'){
                                            $pro1 ='checked';
                                        }else{
                                            $pro2 ='checked';
                                        }
                                    ?>
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                        <div class="form-group">
                                            <label for="count"class="form-label">สถานที่ไป</label>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='provin' id='pro1' value='Yes' <?php echo $pro1; ?>>
                                                <label class='form-check-label' for='pro1'>ในเขต กทม.</label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='provin' id='pro2' value='No' <?php echo $pro2; ?>>
                                                <label class='form-check-label' for='pro2'>นอกเขต กทม.</label>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        if($book['esypass']=='Yes'){
                                            $tang1 ='checked';
                                        }else{
                                            $tang2 ='checked';
                                        }
                                    ?>
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                        <div class="form-group">
                                            <label for="count"class="form-label">ขอใช้ทางด่วน</label>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='esypass' id='tang1' value='Yes' <?php echo $tang1; ?>>
                                                <label class='form-check-label' for='tang1'>ผ่าน</label>
                                            </div>
                                            <div class='form-check'>
                                                <input class='form-check-input' type='radio' name='esypass' id='tang2' value='No'<?php echo $tang2; ?>>
                                                <label class='form-check-label' for='tang2'>ไม่ผ่าน</label>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                    <div class="form-group">
                                            <label for="car"class="form-label">ประเถทรถ</label>
                                            <select class="form-select" aria-label="Default select example" id="car" name="car" required>
                                                <option value="">เลือก</option>
                                                <?php
                                                    $carObj = new Car;
                                                    if($_SESSION['role']=='member'){
                                                        $cars = $carObj->getAllcar(); 
                                                    }else{
                                                        $cars = $carObj->getAllcarByAdmin(); 
                                                    } 
                                                    foreach($cars as $car) {
                                                        $selected =($car['id']==$book['c_id']) ? 
                                                        "selected" : "";
                                                        echo "
                                                        <option value='{$car['id']}' {$selected} >{$car['name']}</option>
                                                        ";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <label for="count"class="form-label">เลือกการรับส่ง</label>
                                                <?php
                                                    $chooseObj = new Choose;
                                                    $chooses = $chooseObj->getAllchoose(); 
                                                    $i=0;
                                                    foreach($chooses as $choose) {
                                                        $selected =($choose['id']==$book['ch_id'] OR ($i==0)) ? 
                                                        "checked" : "";
                                                        echo "
                                                            <div class='form-check'>
                                                                <input class='form-check-input' type='radio' name='choose' id='flexRadioDefault{$choose['id']}' {$selected} value='{$choose['id']}'>
                                                                <label class='form-check-label' for='flexRadioDefault{$choose['id']}'>
                                                                {$choose['name']}
                                                                </label>
                                                            </div>
                                                        ";
                                                        $i++;
                                                    }
                                                    
                                                ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg">
                                        <div class="form-group">
                                            <label for="remark"class="form-label">หมายเหตุ</label>
                                            <textarea rows="<?php echo $i;?>" class="form-control" id="remark" name="remark" required><?php echo $book['remark']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                    <button class="btn btn-success text-white" type="submit">บันทึก</button>
                                    <a href="/car/" class="btn btn-warning text-white">ย้อนกลับ</a>
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js'></script> -->
    
    <script src='../../theme/js/bootstrap-datepicker.js'></script>
    <script src='../../theme/js/bootstrap-datepicker-thai.js'></script>
    <script src='../../theme/js/locales/bootstrap-datepicker.th.js'></script>
    
    <script type="text/javascript">
        
        $(function(){
            $("#datepicker").datepicker({
                language:'th-en',
                format: 'yyyy-mm-dd',
                minDate: 0,
                autoclose: true
                
            });
            $("#datepicker2").datepicker({
                language:'th-en',
                format:'yyyy-mm-dd',
                autoclose: true
            });
            
        });
       
    </script>
</body>
</html>