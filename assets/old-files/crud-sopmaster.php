<?php
include "config/app.php";

$crudObj = new crudSOPMaster();

if ($_POST['crudSOPMaster'] == "getData") {
    $no = 1;
    $tableData = '';
    $allData = $crudObj->getSOPMASTER($conn);
    if (count($allData) > 0) {
        foreach ($allData as $row) {
            $tableData .= ' <tr>
                <td>'.$no++.'</td>
                <td>'.$row['NoSOP'].'</td>
                <td>'.$row['NamaSOP'].'</td>
                <td>'.$row['DivisiMain'].'</td>
                <td>'.$row['KategoriSOP'].'</td>
                <td>
                    <a href="javaScript:void(0)" onclick="editData(\''.$row['NoSOP'].'\',\''.$row['NoSOP'].'\',\''.$row['NamaSOP'].'\',\''.$row['DivisiMain'].'\',\''.$row['KategoriSOP'].'\');" class="btn btn-warning btn-sm">Edit</a>
                    <a href="javaScript:void(0)" onclick="deleteData(\''.$row['NoSOP'].'\');" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>';
        }
    }
    echo $tableData;
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


