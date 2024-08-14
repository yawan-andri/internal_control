<?php 
    include 'template/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">      
                <label for="divisifil">Divisi </label>          
                <select name ="divisifil" id="divisifil" class="form-control form-control-sm" required>
                    <div id ="divisifil"></div>
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">      
                <label for="kategorifil">Kategori SOP </label>          
                <select name ="kategorifil" id="kategorifil" class="form-control form-control-sm" required>
                    <option value=""></option>
                    <option value="SOP">SOP</option>
                    <option value="PRA-SOP">PRA-SOP</option>                   
                </select>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <a href="javaScript:void(0);" onclick="tambahData()" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary btn-sm mb-2"> <i class="fa fa-plus-circle"></i> Tambah </a>
    <a href="spreadsheet/master-sop-excel.php" class="btn btn-outline-success btn-sm mb-2">Export Excel</a>
    <table class="table table-bordered table-hover">
        <thead id="thead">
            <tr>
                <th>No</th>
                <th>No SOP</th>
                <th>Nama SOP</th>
                <th>Divisi</th>
                <th>KategoriSOP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="sopMaster" class="table-group-divider"></tbody>
    </table>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Master SOP</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="crudAppForm">
                    <input type="hidden" name="editId" id="editId" value="" />
                    <div class="row mb-3">
                        <label for="nosop" class="col-sm-2 col-form-label col-form-label-sm">No SOP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="nosop" name="nosop" placeholder="No SOP ..." required>
                        </div>
                        <p id="duplicateNoSOP" class="text-danger" style="display: none;">*Tidak bisa input No SOP yang sama!</p>
                    </div>
                    <div class="row mb-3">
                        <label for="namasop" class="col-sm-2 col-form-label col-form-label-sm">Nama SOP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="namasop" name="namasop" placeholder="Nama SOP ..." required>
                        </div>
                        <p id="duplicateNamaSOP" class="text-danger" style="display: none;">*Tidak bisa input Nama SOP yang sama!</p>
                    </div>
                    <div class="row mb-3">
                        <label for="divisi" class="col-sm-2 col-form-label col-form-label-sm">Divisi Main</label>
                        <div class="col-sm-10">
                            <select name ="divisi" id="divisi" class="form-control form-control-sm" required>
                                <div id ="divisi"></div>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="kategorisop" class="col-sm-2 col-form-label col-form-label-sm">Kategori SOP</label>
                        <div class="col-sm-10">
                            <select name ="kategorisop" id="kategorisop" class="form-control form-control-sm" required>
                                <option value="SOP">SOP</option>
                                <option value="PRA-SOP">PRA-SOP</option>
                            </select>
                        </div>
                    </div>
            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="submitBtn" id="submitBtn" class="btn btn-primary btn-sm"><span id="buttonLabel"> Simpan</span></button>
                    </div>
                </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getSOPMaster(); // Initial load
        getDivisi(); // Load division options

        // Add change event listeners to the select elements
        $('#divisifil, #kategorifil').change(function() {
            getSOPMaster(); // Reload data with selected filters
        });
    });

    function getSOPMaster() {
        // Get selected values from the dropdowns
        var selectedDivisi = $('#divisifil').val();
        var selectedKategori = $('#kategorifil').val();

        $.post("crud-sopmastertest1.php", {
            crudSOPMaster: "getData",
            divisi: selectedDivisi,
            kategori: selectedKategori
        }, function(response) {
            // Clear the table body
            $("#sopMaster").empty();
            
            // Iterate over JSON data and append rows to the table
            response.forEach(function(row, index) {
                var tableRow = '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + row.NoSOP + '</td>' +
                    '<td>' + row.NamaSOP + '</td>' +
                    '<td>' + row.DivisiMain + '</td>' +
                    '<td>' + row.KategoriSOP + '</td>' +
                    '<td>' +
                    '<a href="javaScript:void(0)" onclick="editData(\'' + row.NoSOP + '\',\'' + row.NoSOP + '\',\'' + row.NamaSOP + '\',\'' + row.DivisiMain + '\',\'' + row.KategoriSOP + '\');" class="btn btn-warning btn-sm me-1">Edit</a>' +
                    '<a href="javaScript:void(0)" onclick="deleteData(\'' + row.NoSOP + '\');" class="btn btn-danger btn-sm">Delete</a>' +
                    '</td>' +
                    '</tr>';
                $("#sopMaster").append(tableRow);
            });
        }, "json");
    }

    function getDivisi() {
        $.post("crud-sopmaster.php",{
            crudSOPMaster:"getDivisi"
        },function (allData) {
            $("#divisi").html(allData);
            $("#divisifil").html(allData);
        });
    }

    $("form#crudAppForm").on("submit",function (e) {
        e.preventDefault();
        var nosop = $("#nosop").val();
        var namasop = $("#namasop").val();
        var divisi  = $("#divisi").val();
        var editId = $("#editId").val();
        var kategorisop = $('#kategorisop').val();

        if (nosop == ""){
            alert("No SOP kosong!");
            $("#nosop").focus();
        } else if (namasop == "") {
            alert("Nama SOP kosong!");
            $("#namasop").focus();
        } else if (divisi == "") {
            alert("Divisi kosong!");
            $("#divisi").focus();
        } else if (kategorisop == "") {
            alert("Kategori SOP kosong!");
            $("#kategorisop").focus();           
        } else {
            $("#buttonLabel").html("Saving...");
            $.post("crud-sopmaster.php", {
                crudSOPMaster:"saveData",
                nosop:nosop,
                namasop:namasop,
                divisi:divisi,
                kategorisop:kategorisop,
                editId:editId
            }, function (response) {
                if (response == "saved") {
                    $("#buttonLabel").html("Save");
                    $("#duplicateNoSOP").hide();
                    $("#duplicateNamaSOP").hide();
                    $("#myModal").modal('hide');
                    $("form#crudAppForm").each(function () {
                        this.reset();
                    });
                    getSOPMaster();
                } else if (response == "duplicateNoSOP") { 
                    $("#duplicateNoSOP").show();
                    $("#buttonLabel").html("Save");
                } else if (response == "duplicateNamaSOP") { 
                    $("#duplicateNamaSOP").show();
                    $("#buttonLabel").html("Save");
                } 
            });
        }
    });


    function tambahData(editId,nosop,namasop,divisi,kategorisop) {
        $("#editId").val('');
        $("#nosop").val('');
        $("#namasop").val('');
        $("#divisi").val('');
        $("#kategorisop").val('');
        $("#myModal").modal('show');
        $("#duplicateNoSOP").hide();
        $("#duplicateNamaSOP").hide();
    }

    function editData(editId,nosop,namasop,divisi,kategorisop) {
        $("#editId").val(editId);
        $("#nosop").val(nosop);
        $("#namasop").val(namasop);
        $("#divisi").val(divisi);
        $("#kategorisop").val(kategorisop);
        $("#myModal").modal('show');
    }

    function deleteData(deleteId) {
        if(confirm("Yakin hapus SOP ini " + deleteId + "?")){
            $.post("crud-sopmaster.php",{crudSOPMaster:"deleteData",deleteId:deleteId},function (response) {
                if (response == "deleted") {
                    getSOPMaster();
                }
            });
        }
    }
</script>

<?php 
    include 'template/footer.php';
?>
