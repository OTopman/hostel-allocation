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

<?php require_once 'libs/foot.php';?>
