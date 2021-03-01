<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 2:19 PM
 */

$page_title = "Add Hall Of Residence";
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

            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Hostel Name</label>
                            <input type="text" class="form-control" required placeholder="Hostel Name" name="hostel-name" id="">
                        </div>
                    </div>

                   <div class="col-sm-6">
                       <div class="form-group">
                           <label for="">Hostel Type</label>
                           <select name="hostel-type" id="" class="form-control" required>
                               <option value="" selected>Select</option>
                               <option>Boys Hostel</option>
                               <option>Girls Hostel</option>
                           </select>
                       </div>
                   </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php require_once 'libs/foot.php'?>
