<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 2:28 PM
 */

$page_title = "Payment History";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}

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
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Matric Number</th>
                        <th>Full Name</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Paid At</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Matric Number</th>
                        <th>Full Name</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Paid At</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT p.*, s.matric, s.fname FROM ".DB_PREFIX."payments p INNER JOIN ".DB_PREFIX."students s ON p.student_id = s.id ORDER BY p.id DESC");
                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= strtoupper($rs['matric']) ?></td>
                                <td><?= ucwords($rs['fname']) ?></td>
                                <td><?= amount_format($rs['amount']) ?></td>
                                <td><?= $rs['reference'] ?></td>
                                <td><?= $rs['status'] ?></td>
                                <td><?= $rs['paid_at'] ?></td>
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
