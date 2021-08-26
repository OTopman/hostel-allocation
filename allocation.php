<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 2:28 PM
 */

$page_title = "Hostel Allocation";
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
                        <th>Department</th>
                        <th>Level</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
                        <th>Room</th>
                        <th>Amount Paid</th>
                        <th>Reference</th>
                        <th>Bed Number</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Matric Number</th>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Hostel Name</th>
                        <th>Hostel Type</th>
                        <th>Room</th>
                        <th>Amount Paid</th>
                        <th>Reference</th>
                        <th>Bed Number</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $allocation_sql = $db->query("SELECT a.*, h.room, ht.name, ht.type, p.amount, p.reference, s.matric, s.fname, d.name as dept, p.amount, p.reference, s.level FROM ".DB_PREFIX."allocation a 
            INNER JOIN ".DB_PREFIX."hostel h ON a.hostel_id = h.id
            INNER JOIN ".DB_PREFIX."hostel_type ht ON h.hostel_type_id = ht.id
            INNER JOIN ".DB_PREFIX."payments p ON a.id = p.allocation_id
            INNER JOIN ".DB_PREFIX."students s ON a.student_id = s.id
            INNER JOIN ".DB_PREFIX."departments d ON s.dept = d.id
            ORDER BY a.id DESC");
                    while ($rs = $allocation_sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= strtoupper($rs['matric']) ?></td>
                            <td><?= ucwords($rs['fname']) ?></td>
                            <td><?= ucwords($rs['dept']) ?></td>
                            <td><?= strtoupper($rs['level']) ?></td>
                            <td><?= ucwords($rs['name']) ?></td>
                            <td><?= ucwords($rs['type']) ?></td>
                            <td>Room <?= $rs['room'] ?></td>
                            <td><?= amount_format($rs['amount']) ?></td>
                            <td><?= $rs['reference'] ?></td>
                            <td><?= $rs['bed'] ?></td>
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
