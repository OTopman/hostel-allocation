<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 2:28 PM
 */

require_once 'config/core.php';
$student_id = $_GET['id'];
if (!isset($student_id) or empty($student_id)){
    redirect(base_url('404.php'));
    return;
}

$sql = $db->query("SELECT s.*, d.name as dept FROM ".DB_PREFIX."students s 
        LEFT JOIN ".DB_PREFIX."departments d
            ON s.dept = d.id
        WHERE s.id='$student_id'");

if ($sql->rowCount() == 0){
    redirect(base_url('404.php'));
    return;
}

$data = $sql->fetch(PDO::FETCH_ASSOC);

$page_title = strtoupper($data['matric'])." - Dashboard";

require_once 'libs/head.php';
?>

<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">

    <?php flash(); ?>

    <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow-gradient">
            <h3 class="widget-user-username"><?= ucwords($data['fname']) ?></h3>
            <h5 class="widget-user-desc">Level : <?= ucwords($data['level']) ?></h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="<?= image_url('icon.jpeg') ?>" style="width: 80px; height: 80px;" alt="User Avatar">
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= ucwords($data['gender']) ?></h5>
                        <span class="description-text">Gender</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= $data['dept'] ?></h5>
                        <span class="description-text">Department</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                    <div class="description-block">
                        <h5 class="description-header"><?= $data['email'] ?></h5>
                        <span class="description-text">Email Address</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.widget-user -->
</div>

<?php require_once 'libs/foot.php';?>
