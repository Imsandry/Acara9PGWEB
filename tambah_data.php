<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb8";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tambah data jika ada request tambah
if (isset($_POST['tambah_data'])) {
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];
    
    $insert_sql = "INSERT INTO tabel8 (kecamatan, longitude, latitude, luas, jumlah_penduduk) 
                   VALUES ('$kecamatan', '$longitude', '$latitude', '$luas', '$jumlah_penduduk')";
    
    if ($conn->query($insert_sql) === TRUE) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Error inserting record: " . $conn->error;
    }
    // Redirect kembali ke halaman utama setelah data ditambahkan
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Penduduk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h4>Form Tambah Data</h4>
        <form method="POST" action="tambah_data.php">
            <div class="mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" name="kecamatan" id="kecamatan" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" name="longitude" id="longitude" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" name="latitude" id="latitude" required>
            </div>
            <div class="mb-3">
                <label for="luas" class="form-label">Luas (km²)</label>
                <input type="text" class="form-control" name="luas" id="luas" required>
            </div>
            <div class="mb-3">
                <label for="jumlah_penduduk" class="form-label">Jumlah Penduduk</label>
                <input type="text" class="form-control" name="jumlah_penduduk" id="jumlah_penduduk" required>
            </div>
            <button type="submit" name="tambah_data" class="btn btn-primary">Tambah Data</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
