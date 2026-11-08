<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Kos-Kosan | Cloud Computing</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; color: #333; text-align: center; padding: 50px; }
        .card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1); display: inline-block; max-width: 500px; width: 100%; }
        h1 { color: #1F4E78; }
        .status { padding: 10px; border-radius: 5px; font-weight: bold; margin-top: 20px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🏠 Kos-Kosan Sejahtera</h1>
        <p>Proyek Cloud Computing - Simulasi Infrastruktur VM VMware & Docker</p>
        <hr>
        <h3>Status Koneksi Database:</h3>
        <?php
        // Cek koneksi ke container mysql
        $host = 'mysql';
        $user = 'root';
        $pass = 'rootpassword123';
        $db   = 'db_kos';

        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            echo '<div class="status error">❌ Gagal terhubung ke Database MySQL: ' . $conn->connect_error . '</div>';
        } else {
            echo '<div class="status success">✅ Berhasil terhubung ke Database MySQL (`db_kos`)!</div>';
        }
        ?>
    </div>
</body>
</html>
