<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2/26/21
 * Time: 6:50 AM
 */

$page_title = "All Staff";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}

if (isset($_POST['add'])){
    $username = $_POST['username'];
    $email = strtolower($_POST['email']);
    $fname = $_POST['fname'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin WHERE username='$username'");
    if ($sql->rowCount() >= 1){
        $error[] = "Username has already exist";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $db->query("INSERT INTO ".DB_PREFIX."admin (username,fname,email,phone,gender,password)VALUES('$username','$fname','$email','$phone','$gender','$password')");

        set_flash("Staff has been added successfully","info");

        redirect(base_url('staff.php'));

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
                <h4 class="modal-title">Add New Staff</h4>
            </div>
            <div class="modal-body">

                <form action="" method="post">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" class="form-control" required placeholder="Username" name="username" id="">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Full Name</label>
                                <input type="text" class="form-control" required placeholder="Full Name" name="fname" id="">
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Email Address</label>
                                <input type="email" class="form-control" required placeholder="Email Address" name="email" id="">
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Phone Number</label>
                                <input type="text" class="form-control" required placeholder="Phone Number" name="phone" id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" required name="password" placeholder="Password" id="">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Gender</label>
                                <select name="gender" required id="" class="form-control">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
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

<div class="col-md-12">

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

            <a href="#"  data-toggle="modal" class="btn btn-danger" data-target="#modal-default" style="margin-bottom: 20px">Add New Staff</a>

            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Gender</th>
                        <th>Created At</th>
                    </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $sql = $db->query("SELECT * FROM ".DB_PREFIX."admin ORDER BY id DESC");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $rs['username'] ?></td>
                                    <td><?= $rs['fname'] ?></td>
                                    <td><?= $rs['email'] ?></td>
                                    <td><?= $rs['phone'] ?></td>
                                    <td><?= $rs['gender'] ?></td>
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
    <!-- /.box -->
</div>

<?php require_once 'libs/foot.php';?>
