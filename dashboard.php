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

<div class="col-lg-4 col-xs-12">
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

<div class="col-lg-4 col-xs-12">
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

<div class="col-lg-4 col-xs-1">
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
            <i class="ion ion-home"></i>
        </div>
        <a href="type.php" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-sm-6">
    <div class="box ">
        <div class="box-header with-border">All Students</div>
        <div class="box-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."students ORDER BY id DESC LIMIT 0,8");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= $rs['fname'] ?></td>
                            <td><?= $rs['phone'] ?></td>
                            <td><?= (!empty($rs['email'])) ? $rs['email'] : 'N/A' ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="box ">
        <div class="box-header with-border">All Staffs</div>
        <div class="box-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin ORDER BY id DESC LIMIT 0,8");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= $rs['fname'] ?></td>
                            <td><?= $rs['phone'] ?></td>
                            <td><?= $rs['email'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>



<?php require_once 'libs/foot.php';?>
