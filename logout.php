<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 8:59 PM
 */

require_once 'config/core.php';
unset($_SESSION[USER_SESSION_HOLDER]);
unset( $_SESSION['loggedin']);
redirect(base_url('index.php'));