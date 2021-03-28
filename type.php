<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-03-28
 * Time: 08:21
 */

$page_title = "Hall Of Residence Type";
require_once 'config/core.php';
require_once 'libs/head.php';
?>


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

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
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