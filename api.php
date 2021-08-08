<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-03-28
 * Time: 09:07
 */

require_once 'config/core.php';
require_once 'pdf/vendor/autoload.php';

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');


try {
    $mpdf = new \Mpdf\Mpdf([
        //'tempDir' => __DIR__ . '/pdf', // uses the current directory's parent "tmp" subfolder
        'setAutoTopMargin' => 'stretch',
        'setAutoBottomMargin' => 'stretch',
    ]);

    //$mpdf->useOnlyCoreFonts = true;    // false is default
    //$mpdf->SetAuthor("Sanros Trading Co.");
    $mpdf->SetWatermarkText("Hostel Allocation");
    $mpdf->SetWatermarkImage(image_url('logo2fade.png'));
    $mpdf->showWatermarkImage = true;
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

} catch (\Mpdf\MpdfException $e) {
    print "Creating an mPDF object failed with" . $e->getMessage();
}

$action_data = @$_POST;
$data = $hostel_room = $hostel_room = array();


switch ($action_data['action']){
    case 'login' :

        $matric = $action_data['matric'];
        $password = $action_data['password'];

        $sql = $db->query("SELECT s.*, d.name as dept FROM ".DB_PREFIX."students s 
        LEFT JOIN ".DB_PREFIX."departments d
            ON s.dept = d.id
        WHERE s.matric='$matric' and s.password='$password'");

        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        if ($sql->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "Invalid login details, try again";
        }else{
            $data['error'] =1;
            $student_info = array(
                'id'=>$rs['id'],
                'matric'=>strtoupper($rs['matric']),
                'fname'=>ucwords($rs['fname']),
                'level'=>ucwords($rs['level']),
                'email'=>$rs['email'],
                'phone'=>$rs['phone'],
                'dept'=>ucwords($rs['dept']),
                'gender'=>ucwords($rs['gender'])
            );

            $hostel_sql = $db->query("SELECT id,name,type FROM ".DB_PREFIX."hostel_type");
            while ($rs2 = $hostel_sql->fetch(PDO::FETCH_ASSOC)){
                $hostel_data[] = array(
                    'id'=>$rs2['id'],
                    'name'=>ucwords($rs2['name']),
                    'type'=>ucwords($rs2['type'])
                );
            }

            $sql_room = $db->query("SELECT * FROM ".DB_PREFIX."hostel");
            while ($rs3 = $sql_room->fetch(PDO::FETCH_ASSOC)){
                $hostel_room[] = array(
                    'id'=>$rs3['id'],
                    'hostel_type_id'=>$rs3['hostel_type_id'],
                    'room'=>$rs3['room']
                );
            }

        }

        $data = array(
            'status'=>$data,
            'student_info'=>$student_info,
            'hostel_data'=>$hostel_data,
            'hostel_room'=>$hostel_room
        );

        get_json($data);

        break;
    case 'change_password' :

        $student_id = $action_data['student_id'];
        $password = $action_data['password'];
        $npassword = $action_data['npassword'];

        $sql = $db->query("SELECT * FROM ".DB_PREFIX."students WHERE id='$student_id'");

        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        if ($password != $rs['password'] or $sql->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "Invalid old password entered, please try again";
        }else{
            $db->query("UPDATE ".DB_PREFIX."students SET password='$npassword' WHERE id='$student_id'");
            $data['error'] = 1;
            $data['msg'] = "Your password has been changed successfully";
        }

        get_json($data);

        break;

    case 'payment' :

        $student_id = $action_data['student_id'];
        $hostel_type_id = $action_data['hostel_id'];
        $ref = $action_data['ref'];
        $amount = 10000;

        $hostel_name = hostel_type($hostel_type_id,'name');
        $hostel_type =  hostel_type($hostel_type_id,'type');

        $sql = $db->query("SELECT h.*, h_t.name, h_t.type FROM ".DB_PREFIX."hostel h INNER JOIN ".DB_PREFIX."hostel_type h_t ON h.hostel_type_id = h_t.id WHERE h.hostel_type_id='$hostel_type_id' and h.bed > 0 ORDER BY RAND()");

        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        if ($sql->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "No available rooms in ".ucwords($hostel_name)." (".ucwords($hostel_type).")";
        }else{
            $data['error'] =1;
            $hostel_id = $rs['id'];

            $sql2 = $db->query("SELECT * FROM ".DB_PREFIX."allocation WHERE hostel_id='$hostel_id'");

            $total_left_bed = ($sql2->rowCount() == 0) ? 1 : $sql2->rowCount() + 1;
            $bed = $total_left_bed ;

            $hostel_bed = $rs['bed'] - 1;
            $room = $rs['room'];

            $db->query("UPDATE ".DB_PREFIX."hostel SET bed='$hostel_bed' WHERE id='$hostel_type_id'");

            $db->query("INSERT INTO ".DB_PREFIX."allocation (student_id,hostel_id,bed)VALUES('$student_id','$hostel_id','$bed')");

            $allocation_id = $db->lastInsertId();

            $db->query("INSERT INTO ".DB_PREFIX."payments (student_id,amount,reference,allocation_id)VALUES('$student_id','$amount','$ref','$allocation_id')");

            $allocation_sql = $db->query("SELECT a.*, h.room, ht.name, ht.type, p.amount, p.reference FROM ".DB_PREFIX."allocation a 
            INNER JOIN ".DB_PREFIX."hostel h ON a.hostel_id = h.id
            INNER JOIN ".DB_PREFIX."hostel_type ht ON h.hostel_type_id = ht.id
            INNER JOIN ".DB_PREFIX."payments p ON a.id = p.allocation_id
            WHERE a.id='$allocation_id'");

            $allocation = $allocation_sql->fetch(PDO::FETCH_ASSOC);

            $data['msg'] = $allocation;

        }

        get_json($data);

        break;
    default;
}