<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 2:19 PM
 */

$page_title = "Hall Of Residence";
require_once 'config/core.php';
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
                                    <option value="" disabled>Select</option>
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
                                <input type="number" class="form-control" required name="room" placeholder="Room No" id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Hostel Room No Of Beds</label>
                                <input type="number" class="form-control" required name="bed" placeholder="Room No" id="">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Room Price</label>
                                <input type="number" class="form-control" required placeholder="Hostel Price" name="" id="">
                            </div>
                        </div>
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

            <a href="#"  data-toggle="modal" class="btn btn-warning" data-target="#modal-default" style="margin-bottom: 20px">Add New Hall Of Residence</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
                        <th>Room No</th>
                        <th>Hostel Room No Of Beds</th>
                        <th>Room Price</th>
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
                        <th>Room Price</th>
                        <th>Created At</th>
                    </tr>
                    </tfoot>
                </table>
            </div>


        </div>
    </div>
</div>

<?php require_once 'libs/foot.php'?>
