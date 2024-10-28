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

// Menghapus data jika ada request hapus
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM tabel8 WHERE id='$delete_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Jumlah Penduduk - Peta dan Tabel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        body {
            background-color: #f5f5f5;
        }
        #map {
            height: 340px;
            width: 100%;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            overflow: hidden;
        }
        .table-container {
            animation: fadeIn 0.6s ease;
            margin-top: 20px;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <!-- Map Section -->
            <div class="col-md-12">
                <h2 class="display-8 mb-4 text-center">Peta Jumlah Penduduk Godean dan Sekitarnya</h2>
                <div id="map"></div>
            </div>
        </div>
        <!-- Tabel Section -->
        <div class="table-container">
            <?php
            $sql = "SELECT * FROM tabel8";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table class='table table-striped table-hover table-bordered table-sm mt-3 align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th style='font-size: 1rem;'>Kecamatan</th>
                        <th style='font-size: 1rem;'>Longitude</th>
                        <th style='font-size: 1rem;'>Latitude</th>
                        <th style='font-size: 1rem;'>Luas (km²)</th>
                        <th class='text-end' style='font-size: 0.85rem;'>Jumlah Penduduk</th>
                        <th class='text-center' style='font-size: 0.85rem;'>Aksi</th>
                    </tr>
                </thead>
                <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td style='padding: 6px;'><i class='bi bi-geo-alt-fill text-primary me-2'></i>" . $row["kecamatan"] . "</td>
                        <td style='padding: 6px;'>" . $row["longitude"] . "</td>
                        <td style='padding: 6px;'>" . $row["latitude"] . "</td>
                        <td style='padding: 6px;'>" . $row["luas"] . "</td>
                        <td class='text-end' style='padding: 6px;'><span class='badge bg-info'>" . number_format($row["jumlah_penduduk"]) . "</span></td>
                        <td class='text-center' style='padding: 6px;'>
                            <a href='?delete_id=".$row["id"]."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");' class='btn btn-outline-danger btn-sm'>
                                <i class='bi bi-trash'></i>
                            </a>
                        </td>
                    </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<div class='alert alert-info'>Tidak ada data yang ditemukan</div>";
            }
            // Tutup koneksi
            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([-7.7681, 110.296], 12);
        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        // Add markers from database
        <?php
        $result->data_seek(0);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $lat = $row["latitude"];
                $long = $row["longitude"];
                $info = $row["kecamatan"];
                $luas = $row["luas"];
                $jmlPenduduk = $row["jumlah_penduduk"];
                echo "L.marker([$lat, $long]).addTo(map)
                      .bindPopup('<b>Kecamatan:</b> $info<br><b>Luas:</b> $luas km²<br><b>Jumlah Penduduk:</b> $jmlPenduduk');\n";
            }
        } else {
            echo "console.log('No data found');";
        }
        ?>
    </script>
</body>
</html>
