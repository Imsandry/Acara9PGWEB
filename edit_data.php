<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb8";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST['edit_data'])) {
    $id = $_POST['id'];
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];

    $update_sql = "UPDATE tabel8 SET 
                   kecamatan='$kecamatan', 
                   longitude='$longitude', 
                   latitude='$latitude', 
                   luas='$luas', 
                   jumlah_penduduk='$jumlah_penduduk' 
                   WHERE id='$id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    header("Location: index.php");
    exit();
}
?>
