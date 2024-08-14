<?php
include "config/app.php";

$crudObj = new crudSOPMaster();

if ($_POST['crudSOPMaster'] == "getData") {
    $divisi = $_POST['divisi'];
    $kategori = $_POST['kategori'];

    $allData = $crudObj->getSOPMASTER($conn, $divisi, $kategori);

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($allData);
}

if ($_POST['crudSOPMaster'] == "getDivisi") {
    $tableData = '<option value=""></option>';
    $allData = $crudObj->getDivisi($conn);
    if (count($allData) > 0) {
        foreach ($allData as $row) {
            $tableData .= '<option value="'.$row['DivisiMain'].'">'.$row['DivisiMain'].'</option>';
        }
    }
    echo $tableData;
}

if ($_POST['crudSOPMaster'] == "saveData") {
    $nosop = $_POST['nosop'];
    $namasop = $_POST['namasop'];
    $divisi = $_POST['divisi'];
    $kategorisop = $_POST['kategorisop'];
    $editId = $_POST['editId'];
    $save = $crudObj->saveData($conn,$nosop,$namasop,$divisi,$kategorisop,$editId);
    if ($save){
        echo "saved";
    }
}

if ($_POST['crudSOPMaster'] == "deleteData"){
    $deleteId = $_POST['deleteId'];
    $delete = $crudObj->deleteData($conn,$deleteId);
    if ($delete){
        echo "deleted";
    }
}


