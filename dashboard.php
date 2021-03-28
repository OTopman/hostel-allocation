<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2/26/21
 * Time: 2:20 PM
 */

$page_title = "Dashboard";
require_once 'config/core.php';
require_once 'libs/head.php';
?>

<div class="col-lg-6 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>
                <?php
                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin");
                    echo $sql->rowCount();
                ?>
            </h3>
            <p>All Staffs</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="staff.php" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-6 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>
                <?php
                $sql = $db->query("SELECT * FROM ".DB_PREFIX."students");
                echo $sql->rowCount();
                ?>
            </h3>
            <p>All Students</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="student.php" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-6 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>
                <?php
                $sql = $db->query("SELECT * FROM ".DB_PREFIX."hostel_type");
                echo $sql->rowCount();
                ?>
            </h3>
            <p>All Hostel Type</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="student.php" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>



<?php require_once 'libs/foot.php';?>
