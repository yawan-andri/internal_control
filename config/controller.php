<?php

function select($query) {
    global $conn; // Assuming $conn is a PDO instance

    try {
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    } catch (PDOException $e) {
        // Handle exceptions here
        echo "Error: " . $e->getMessage();
        return false; // Or handle errors differently
    }
}

function selectparams($query, $params = []) {
    global $conn;

    try {
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log the error or handle it appropriately
        error_log("Database error: " . $e->getMessage());
        return []; // Or throw a custom exception
    }
}

class crudSOPMaster
{

    // public function getSOPMASTER($conn)
    // {
    //     $result = select  
    //                 ("SELECT * FROM tbSOP
    //                 OUTER APPLY (SELECT TOP 1 KategoriSOP FROM tbSOPKategori kat
    //                             WHERE kat.NoSOP = tbSOP.NoSOP
    //                             )tbSOPKategori
    //                 ");
    //     return $result;
    // }

    public function getSOPMASTER($conn, $divisi, $kategori)
    {
        $query = "SELECT * FROM tbSOP
                    OUTER APPLY (SELECT TOP 1 KategoriSOP FROM tbSOPKategori kat
                                WHERE kat.NoSOP = tbSOP.NoSOP
                                ) tbSOPKategori
                    WHERE 1=1";

        $params = [];

        if (!empty($divisi)) {
            $query .= " AND DivisiMain = :divisi";
            $params[':divisi'] = $divisi;
        }

        if (!empty($kategori)) {
            $query .= " AND KategoriSOP = :kategori";
            $params[':kategori'] = $kategori;
        }

        return selectparams($query, $params);
    }

    public function getDivisi($conn)
    {
        $result = select ("SELECT DISTINCT DivisiMain FROM tbSOP");
        return $result;
    }

    public function saveData($conn,$nosop,$namasop,$divisi,$kategorisop,$editId)
    {

        $nosop = htmlspecialchars(strtoupper($nosop));
        $namasop = htmlspecialchars(strtoupper($namasop));
        $divisi = htmlspecialchars(strtoupper($divisi));
        $kategorisop = htmlspecialchars(strtoupper($kategorisop));
        $oldnosop = htmlspecialchars(strtoupper($editId));


        $checkNoSOP = $conn->prepare("SELECT COUNT(*) FROM tbSOP WHERE NoSOP = ?");
        $checkNoSOP->bindParam(1, $nosop, PDO::PARAM_STR);
        $checkNoSOP->execute();
        $c_checkNoSOP = $checkNoSOP->fetchColumn();

        if ($c_checkNoSOP > 0 && $editId == "") { // Duplicate found and not editing
            echo "duplicateNoSOP"; // Return duplicate error
            return false;
        }

        $checkNamaSOP = $conn->prepare("SELECT COUNT(*) FROM tbSOP WHERE NamaSOP = ?");
        $checkNamaSOP->bindParam(1, $namasop, PDO::PARAM_STR);
        $checkNamaSOP->execute();
        $c_checkNamaSOP = $checkNamaSOP->fetchColumn();

        if ($c_checkNamaSOP > 0 && $editId == "") { // Duplicate found and not editing
            echo "duplicateNamaSOP"; // Return duplicate error
            return false;
        }

        try {
            if ($editId == "") {
                $stmt1 = $conn->prepare("INSERT INTO tbSOP VALUES (?, ?, ?, '', '', '')");
                $stmt1->bindParam(1, $nosop, PDO::PARAM_STR);
                $stmt1->bindParam(2, $namasop, PDO::PARAM_STR);
                $stmt1->bindParam(3, $divisi, PDO::PARAM_STR);

                $stmt2 = $conn->prepare("INSERT INTO tbSOPKategori VALUES (?, ?)");
                $stmt2->bindParam(1, $nosop, PDO::PARAM_STR);
                $stmt2->bindParam(2, $kategorisop, PDO::PARAM_STR);

            }else{
                $stmt1 = $conn->prepare("UPDATE tbSOP SET NoSOP = ?, NamaSOP = ?, DivisiMain = ? WHERE NoSOP = ?");
                $stmt1->bindParam(1, $nosop, PDO::PARAM_STR);
                $stmt1->bindParam(2, $namasop, PDO::PARAM_STR);
                $stmt1->bindParam(3, $divisi, PDO::PARAM_STR);
                $stmt1->bindParam(4, $oldnosop, PDO::PARAM_STR);

                $stmt2 = $conn->prepare("UPDATE tbSOPKategori SET NoSOP = ?, KategoriSOP = ? WHERE NoSOP = ?");
                $stmt2->bindParam(1, $nosop, PDO::PARAM_STR);
                $stmt2->bindParam(2, $kategorisop, PDO::PARAM_STR);
                $stmt2->bindParam(3, $oldnosop, PDO::PARAM_STR);
            }
            $stmt1->execute();
            $stmt2->execute();
            return $stmt1;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; 
        }
    }
    
    public function deleteData($conn,$deleteId) {

        $nosop = strtoupper($deleteId);

        try {
            $stmt1 = $conn->prepare("DELETE FROM tbSOP WHERE NoSOP = ?");
            $stmt1->bindParam(1, $nosop);
            $stmt1->execute();

            $stmt2 = $conn->prepare("DELETE FROM tbSOPKategori WHERE NoSOP = ?");
            $stmt2->bindParam(1, $nosop);
            $stmt2->execute();
            return $stmt1;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; 
        }
    }
}