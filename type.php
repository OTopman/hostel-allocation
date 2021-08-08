<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-03-28
 * Time: 08:21
 */

$page_title = "Hall Of Residence Type";
require_once 'config/core.php';

if (!is_login()){
    redirect(base_url('index.php'));
    return;
}


if (isset($_POST['add'])){
    $name = strtolower($_POST['name']);
    $type = strtolower($_POST['type']);
    $duration = $_POST['duration'];

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."hostel_type WHERE name='$name'");
    if ($sql->rowCount() >= 1){
        $error[] = "Hostel name has already exist";
    }

    if (strlen($name) < 3 or strlen($name) > 100){
        $error[] = "Hostel name should be between 3 - 100 characters";
    }

    if (strlen($type) < 3 or strlen($type) > 20){
        $error[] = "Hostel name should be between 3 - 20 characters";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $db->query("INSERT INTO ".DB_PREFIX."hostel_type (name,type,duration)VALUES('$name','$type','$duration')");

        set_flash("Hostel type has been added successfully","warning");

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}

require_once 'libs/head.php';
?>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Hostel Type</h4>
                </div>
                <div class="modal-body">

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="">Hostel Name</label>
                            <input type="text" class="form-control" placeholder="Hostel Name" name="name" id="" required>
                        </div>

                        <div class="form-group">
                            <label for="">Hostel Type</label>
                            <input type="text" class="form-control" name="type" required placeholder="Hostel Type (e.g Male hostel)" id="">
                        </div>

                        <div class="form-group">
                            <label for="">Duration</label>
                            <input type="number" class="form-control" name="duration" required placeholder="Duration (e.g 365)" id="">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-danger" name="add" value="Submit" id="">
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $page_title ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">

            <?php flash(); ?>

            <a href="#"  data-toggle="modal" class="btn btn-danger" data-target="#modal-default" style="margin-bottom: 20px">Add New Hostel Type</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
                        <th>Duration</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
                        <td>Duration</td>
                        <th>Created At</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT * FROM ".DB_PREFIX."hostel_type ORDER BY id DESC");
                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= $rs['name'] ?></td>
                                <td><?= $rs['type'] ?></td>
                                <td><?= ($rs['duration'] == 1) ? $rs['duration'].'day' : $rs['duration'].'days' ?></td>
                                <td><?= $rs['created_at'] ?></td>
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