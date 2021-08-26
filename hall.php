<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 2:19 PM
 */

$page_title = "Hall Of Residence";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}

if (isset($_POST['add'])){
    $hostel_type = $_POST['type'];
    $price = 10000;//$_POST['price'];
    $room = $_POST['room'];
    $bed = $_POST['bed'];

    if (empty($hostel_type) or empty($room) or empty($bed)){
        $error[] = "All field(s) are required";
    }

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."hostel WHERE hostel_type_id='$hostel_type' and room='$room'");
    if ($sql->rowCount() >= 1){
        $error[] = "Room $room has already exist in ".hostel_type($hostel_type,'name')." ".hostel_type($hostel_type,'type');
    }

    $error_count = count($error);
    if ($error_count == 0){

        $db->query("INSERT INTO ".DB_PREFIX."hostel (hostel_type_id,room,bed,price)VALUES('$hostel_type','$room','$bed','$price')");

        set_flash("Hall of residence has been added successfully","warning");

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
                <h4 class="modal-title">Add New Hall Of Residence</h4>
            </div>
            <div class="modal-body">

                <form action="" method="post">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Hostel Type</label>
                                <select name="type" class="form-control" required id="">
                                    <option value="" readonly="">Select</option>
                                    <?php
                                    $sql = $db->query("SELECT * FROM ".DB_PREFIX."hostel_type ORDER BY name");
                                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                        <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?> (<?= ucwords($rs['type']) ?>)</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Hostel Room No</label>
                                <input type="text" class="form-control" required name="room" placeholder="Room No" id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Hostel Room No Of Beds</label>
                                <input type="number" class="form-control" required name="bed" placeholder="Hostel Room No Of Beds" id="">
                            </div>
                        </div>

<!--                        <div class="col-sm-12">-->
<!--                            <div class="form-group">-->
<!--                                <label for="">Room Price</label>-->
<!--                                <input type="number" class="form-control" required placeholder="Hostel Price" name="price" id="">-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-danger" value="Submit" name="add" id="">
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

            <?php flash() ?>

            <a href="#"  data-toggle="modal" class="btn btn-danger" data-target="#modal-default" style="margin-bottom: 20px">Add New Hall Of Residence</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
                        <th>Room No</th>
                        <th>Hostel Room No Of Beds</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
                        <th>Room No</th>
                        <th>Hostel Room No Of Beds</th>
                        <th>Created At</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT h.*, h_t.name, h_t.type FROM ".DB_PREFIX."hostel h LEFT JOIN ".DB_PREFIX."hostel_type h_t ON h.hostel_type_id = h_t.id");

                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= ucwords($rs['name']) ?></td>
                                <td><?= ucwords($rs['type']) ?></td>
                                <td>Room <?= $rs['room'] ?></td>
                                <td><?= $rs['bed'] ?></td>
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

<?php require_once 'libs/foot.php'?>
