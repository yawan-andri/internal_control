<?php 
    include 'template/header.php';
    include 'template/footer.php';

    $laporan_kip = select ("SELECT * FROM tbLaporan WHERE Jenis = 'KIP'");
    
?>


<div class="container mt-2">
    <form id="myForm" action="" method="post" enctype="">
        <div class="row mb-3">
            <label for="laporan" class="col-sm-2 col-form-label col-form-label-sm">Laporan</label>
            <div class="col-sm-3">
                <select name ="laporan" id="laporan" class="form-control form-control-sm" onchange="UbahLaporan()"required>
                    <option value="">-- Pilih Laporan --</option>
                    <?php foreach ($laporan_kip as $kip) : ?>
                    <option value="<?= $kip['Laporan']; ?>"><?= $kip['Laporan']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="database" class="col-sm-2 col-form-label col-form-label-sm">Unit Usaha</label>
            <div class="col-sm-3">
                <select name ="database" id="database" class="form-control form-control-sm" required>
                    <option value="">-- Pilih Unit Usaha --</option>
                    <option value="DESWEB"> DES </option>
                    <option value="KLOUDMIFCL"> STS </option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="periode" class="col-sm-2 col-form-label col-form-label-sm">Periode</label>
            <div class="col-sm-3">
                <input type="text" class="yearpicker form-control form-control-sm" id="periode" name="periode" required>
            </div>
        </div>
        <button type="submit" name="excel" class="btn btn-outline-success">Export Excel</button>
    </form>
</div>

<script>
    const today = new Date();

    $('.yearpicker').yearpicker({
        year: today.getFullYear()
    });

    function UbahLaporan() {
        const selectElement = document.getElementById('laporan');
        const form = document.getElementById('myForm');
        const selectedValue = selectElement.value;
        const actionDisplay = document.getElementById('action-display');

        if (selectedValue === 'Claim Web') {
            form.action = 'spreadsheet/excel-claim-web.php';
        } else if (selectedValue === 'Claim Web Asuransi Include') {
            form.action = 'spreadsheet/excel-claim-include.php';
        } 

        const filename = form.action;
        actionDisplay.value = filename;
    }


</script>