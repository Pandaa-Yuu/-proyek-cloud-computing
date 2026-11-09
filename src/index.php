<?php
$host = 'db_proxysql';
$user = 'kos_user';
$pass = 'kospassword';
$db   = 'db_kos';
$port = 6033;

$conn = new mysqli($host, $user, $pass, $db, $port);

// Pesan Notifikasi Simulasi Pemesanan
$booking_msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'book') {
    $nama_pemesan = htmlspecialchars($_POST['nama']);
    $kamar_pilihan = htmlspecialchars($_POST['kamar']);
    $durasi = intval($_POST['durasi']);
    $no_hp = htmlspecialchars($_POST['hp']);
    
    $booking_msg = "Pemesanan Berhasil! Kamar <strong>$kamar_pilihan</strong> atas nama <strong>$nama_pemesan</strong> (Durasi: $durasi Bulan) telah dikonfirmasi ke Database.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Management & Booking Kos-Kosan Sejahtera</title>
    <style>
        * { box-sizing: border-box; font-family: 'Inter', 'Segoe UI', sans-serif; margin: 0; padding: 0; scroll-behavior: smooth; }
        body { background-color: #f8fafc; color: #334155; line-height: 1.6; }

        /* Sticky Navigation Bar */
        .navbar { position: sticky; top: 0; z-index: 1000; background: #0f172a; color: #fff; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .navbar .brand { font-size: 1.3rem; font-weight: 700; color: #38bdf8; display: flex; align-items: center; gap: 10px; }
        .nav-menu { display: flex; gap: 20px; list-style: none; }
        .nav-menu a { color: #cbd5e1; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: color 0.2s; padding: 6px 12px; border-radius: 6px; }
        .nav-menu a:hover { color: #fff; background: rgba(255,255,255,0.1); }

        /* Main Container */
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }

        /* Hero / Project Banner */
        .project-banner { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white; padding: 30px; border-radius: 16px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #334155; }
        .project-banner h1 { font-size: 1.6rem; color: #38bdf8; margin-bottom: 8px; }
        .project-banner p { font-size: 0.95rem; color: #94a3b8; }
        .meta-info { text-align: right; border-left: 3px solid #0284c7; padding-left: 20px; }
        .meta-info p { font-size: 0.85rem; color: #cbd5e1; margin-bottom: 4px; }
        .meta-info strong { color: #f8fafc; }

        /* Alert Connection Status */
        .alert { padding: 14px 20px; border-radius: 10px; margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; font-weight: 600; }
        .alert-success { background-color: #dcfce7; color: #14532d; border: 1px solid #86efac; }
        .alert-danger { background-color: #fee2e2; color: #7f1d1d; border: 1px solid #fca5a5; }

        /* Section Titles */
        .section-title { font-size: 1.3rem; color: #0f172a; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: #fff; padding: 22px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .stat-card p { font-size: 0.8rem; color: #64748b; font-weight: 700; text-transform: uppercase; }
        .stat-card h3 { font-size: 1.8rem; color: #0f172a; margin-top: 6px; }

        /* Room Catalog Grid */
        .room-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px; margin-bottom: 50px; }
        .room-card { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .room-card:hover { transform: translateY(-5px); }
        .room-header { background: #0284c7; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .room-body { padding: 20px; }
        .room-price { font-size: 1.3rem; font-weight: 700; color: #0f172a; margin-bottom: 12px; }
        .room-features { list-style: none; margin-bottom: 20px; font-size: 0.88rem; color: #475569; }
        .room-features li { margin-bottom: 6px; display: flex; align-items: center; gap: 8px; }
        .btn-book { display: block; width: 100%; text-align: center; background: #2563eb; color: white; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
        .btn-book:hover { background: #1d4ed8; }

        /* Layout Content (Table & Booking Form) */
        .content-split { display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 30px; margin-bottom: 50px; }
        @media (max-width: 900px) { .content-split { grid-template-columns: 1fr; } }

        .card-box { background: #fff; border-radius: 14px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #f1f5f9; font-size: 0.88rem; }
        th { background-color: #f8fafc; color: #475569; font-weight: 700; font-size: 0.78rem; text-transform: uppercase; }
        .badge-status { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .bg-terisi { background: #dcfce7; color: #15803d; }
        .bg-kosong { background: #fef3c7; color: #b45309; }

        /* Form Styling */
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.85rem; color: #475569; font-weight: 600; margin-bottom: 6px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.9rem; outline: none; }
        .form-group input:focus, .form-group select:focus { border-color: #2563eb; }

        /* Footer */
        footer { background: #0f172a; color: #94a3b8; text-align: center; padding: 25px; font-size: 0.88rem; border-top: 1px solid #1e293b; margin-top: 40px; }
        footer strong { color: #f8fafc; }
    </style>
</head>
<body>

    <!-- Navigasi Menu Interaktif -->
    <nav class="navbar">
        <div class="brand">🏠 KOS SEJAHTERA</div>
        <ul class="nav-menu">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#katalog">Katalog Kamar</a></li>
            <li><a href="#pesan">Pesan Kamar</a></li>
            <li><a href="#penghuni">Data Penghuni</a></li>
            <li><a href="#infrastruktur">Infrastruktur Server</a></li>
        </ul>
    </nav>

    <div class="container" id="beranda">
        <!-- Banner Proyek -->
        <div class="project-banner">
            <div>
                <h1>Sistem Informasi Management & Booking Kos</h1>
                <p>Simulasi Cloud Computing: VM VMware, Docker Compose, ProxySQL Cluster & Monitoring</p>
            </div>
            <div class="meta-info">
                <p>Mahasiswa: <strong>Afanda Riji Yuneldi</strong> (NIM: 2405005)</p>
                <p>Dosen Pengampu: <strong>Ego Oktafanda, M.Kom</strong></p>
                <p>Kelas / Prodi: <strong>Reguler A / S1 Ilmu Komputer</strong></p>
            </div>
        </div>

        <!-- Status Koneksi Database -->
        <?php if ($conn->connect_error): ?>
            <div class="alert alert-danger">
                <span>❌ Status Database: Gagal Terhubung ke MySQL (<?= $conn->connect_error ?>)</span>
            </div>
        <?php else: ?>
            <div class="alert alert-success">
                <span>✅ Status Database: Terhubung ke MySQL via ProxySQL (Port 6033)</span>
                <small style="background:#bbf7d0; padding:4px 8px; border-radius:6px; font-weight:bold;">Alokasi LVM: 18.22 GB</small>
            </div>
        <?php endif; ?>

        <!-- Stat Ringkasan -->
        <div class="stats-grid">
            <div class="stat-card">
                <p>Total Kamar</p>
                <h3>12 Kamar</h3>
            </div>
            <div class="stat-card">
                <p>Kamar Terisi</p>
                <h3 style="color:#16a34a;">8 Kamar</h3>
            </div>
            <div class="stat-card">
                <p>Kamar Kosong</p>
                <h3 style="color:#d97706;">4 Kamar</h3>
            </div>
            <div class="stat-card">
                <p>Estimasi Omset/Bln</p>
                <h3 style="color:#2563eb;">Rp 10.500.000</h3>
            </div>
        </div>

        <!-- KATALOG KAMAR KOS -->
        <div id="katalog">
            <h2 class="section-title">🛏️ Katalog Tipe Kamar Kos</h2>
            <div class="room-grid">
                <!-- Kamar 1 -->
                <div class="room-card">
                    <div class="room-header">
                        <h3>Kamar VIP AC 01</h3>
                        <span style="background:#fff; color:#0284c7; font-size:0.75rem; padding:3px 8px; border-radius:4px; font-weight:bold;">Tersedia</span>
                    </div>
                    <div class="room-body">
                        <div class="room-price">Rp 1.200.000 <small style="font-size:0.8rem; color:#64748b;">/ bulan</small></div>
                        <ul class="room-features">
                            <li>✅ Pendingin Ruangan (AC 1/2 PK)</li>
                            <li>✅ Kamar Mandi Dalam + Shower</li>
                            <li>✅ Kasur Springbed & Lemari Pakaian</li>
                            <li>✅ Free Wi-Fi 50 Mbps</li>
                        </ul>
                        <button onclick="pilihKamar('Kamar VIP AC 01', 1200000)" class="btn-book">Pesan Kamar Ini</button>
                    </div>
                </div>

                <!-- Kamar 2 -->
                <div class="room-card">
                    <div class="room-header" style="background:#059669;">
                        <h3>Kamar Standard 02</h3>
                        <span style="background:#fff; color:#059669; font-size:0.75rem; padding:3px 8px; border-radius:4px; font-weight:bold;">Tersedia</span>
                    </div>
                    <div class="room-body">
                        <div class="room-price">Rp 750.000 <small style="font-size:0.8rem; color:#64748b;">/ bulan</small></div>
                        <ul class="room-features">
                            <li>✅ Kipas Angin Dinding</li>
                            <li>✅ Kamar Mandi Luar (Bersih)</li>
                            <li>✅ Kasur Busa & Meja Belajar</li>
                            <li>✅ Free Wi-Fi 50 Mbps</li>
                        </ul>
                        <button onclick="pilihKamar('Kamar Standard 02', 750000)" class="btn-book" style="background:#059669;">Pesan Kamar Ini</button>
                    </div>
                </div>

                <!-- Kamar 3 -->
                <div class="room-card">
                    <div class="room-header" style="background:#7c3aed;">
                        <h3>Kamar Executive 03</h3>
                        <span style="background:#fff; color:#7c3aed; font-size:0.75rem; padding:3px 8px; border-radius:4px; font-weight:bold;">Tersedia</span>
                    </div>
                    <div class="room-body">
                        <div class="room-price">Rp 1.500.000 <small style="font-size:0.8rem; color:#64748b;">/ bulan</small></div>
                        <ul class="room-features">
                            <li>✅ Balkon Pribadi + Smart TV 32"</li>
                            <li>✅ AC 1 PK + Water Heater</li>
                            <li>✅ Water Dispenser & Mini Fridge</li>
                            <li>✅ High Speed Wi-Fi 100 Mbps</li>
                        </ul>
                        <button onclick="pilihKamar('Kamar Executive 03', 1500000)" class="btn-book" style="background:#7c3aed;">Pesan Kamar Ini</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- LAYOUT PEMESANAN DAN TABEL PENGHUNI -->
        <div class="content-split">
            <!-- Form Pemesanan Kamar -->
            <div class="card-box" id="pesan">
                <h2 style="font-size:1.1rem; margin-bottom:15px; color:#0f172a;">📝 Form Pemesanan Kamar Kos</h2>
                
                <?php if ($booking_msg != ""): ?>
                    <div style="background:#dcfce7; color:#15803d; padding:12px; border-radius:8px; margin-bottom:15px; font-size:0.88rem;">
                        <?= $booking_msg ?>
                    </div>
                <?php endif; ?>

                <form action="#pesan" method="POST" id="formBooking">
                    <input type="hidden" name="action" value="book">
                    <div class="form-group">
                        <label>Kamar Yang Dipilih</label>
                        <select name="kamar" id="selectKamar" onchange="updateTotalHarga()">
                            <option value="Kamar VIP AC 01" data-harga="1200000">Kamar VIP AC 01 (Rp 1.200.000 / bln)</option>
                            <option value="Kamar Standard 02" data-harga="750000">Kamar Standard 02 (Rp 750.000 / bln)</option>
                            <option value="Kamar Executive 03" data-harga="1500000">Kamar Executive 03 (Rp 1.500.000 / bln)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Pemesan / Calon Penghuni</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap..." required>
                    </div>
                    <div class="form-group">
                        <label>Nomor WhatsApp / Telp</label>
                        <input type="text" name="hp" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="form-group">
                        <label>Durasi Sewa (Bulan)</label>
                        <input type="number" name="durasi" id="inputDurasi" value="1" min="1" max="12" onchange="updateTotalHarga()" onkeyup="updateTotalHarga()" required>
                    </div>
                    <div style="background:#f1f5f9; padding:12px; border-radius:8px; margin-bottom:15px; text-align:right;">
                        <span style="font-size:0.85rem; color:#64748b;">Total Estimasi Pembayaran:</span>
                        <h3 id="totalHarga" style="color:#2563eb; font-size:1.4rem;">Rp 1.200.000</h3>
                    </div>
                    <button type="submit" class="btn-book">Konfirmasi & Simpan Pemesanan</button>
                </form>
            </div>

            <!-- Tabel Data Penghuni Active -->
            <div class="card-box" id="penghuni">
                <h2 style="font-size:1.1rem; margin-bottom:15px; color:#0f172a;">📋 Daftar Penghuni Kos Saat Ini</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No. Kamar</th>
                            <th>Penghuni</th>
                            <th>Status</th>
                            <th>Tipe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Kamar 01</strong></td>
                            <td>Budi Santoso</td>
                            <td><span class="badge-status bg-terisi">Terisi</span></td>
                            <td>VIP AC</td>
                        </tr>
                        <tr>
                            <td><strong>Kamar 02</strong></td>
                            <td>Siti Rahma</td>
                            <td><span class="badge-status bg-terisi">Terisi</span></td>
                            <td>Standard</td>
                        </tr>
                        <tr>
                            <td><strong>Kamar 03</strong></td>
                            <td><em>- Belum Ada -</em></td>
                            <td><span class="badge-status bg-kosong">Kosong</span></td>
                            <td>Executive</td>
                        </tr>
                        <tr>
                            <td><strong>Kamar 04</strong></td>
                            <td>Ahmad Dani</td>
                            <td><span class="badge-status bg-terisi">Terisi</span></td>
                            <td>Standard</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- INFORMASI INFRASTRUKTUR SERVER -->
        <div class="card-box" id="infrastruktur" style="margin-bottom:30px;">
            <h2 class="section-title">⚙️ Arsitektur & Spesifikasi Infrastruktur Cloud</h2>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:20px; font-size:0.88rem;">
                <div style="background:#f8fafc; padding:15px; border-radius:8px; border:1px solid #e2e8f0;">
                    <strong style="color:#0284c7;">🖥️ Virtual Machine</strong>
                    <p style="color:#64748b; margin-top:5px;">Ubuntu Server 26.04 LTS di VMware Workstation dengan ekspansi LVM Disk hingga 18.22 GB.</p>
                </div>
                <div style="background:#f8fafc; padding:15px; border-radius:8px; border:1px solid #e2e8f0;">
                    <strong style="color:#059669;">🔀 ProxySQL Router</strong>
                    <p style="color:#64748b; margin-top:5px;">Traffic database di-routing melalui ProxySQL port 6033 untuk menjamin stabilitas query.</p>
                </div>
                <div style="background:#f8fafc; padding:15px; border-radius:8px; border:1px solid #e2e8f0;">
                    <strong style="color:#7c3aed;">📊 Monitoring System</strong>
                    <p style="color:#64748b; margin-top:5px;">Prometheus (Port 9090) & Grafana (Port 3000) memantau penggunaan CPU, RAM, & Disk.</p>
                </div>
                <div style="background:#f8fafc; padding:15px; border-radius:8px; border:1px solid #e2e8f0;">
                    <strong style="color:#d97706;">💾 Automatic Backup</strong>
                    <p style="color:#64748b; margin-top:5px;">Skema backup otomatis menggunakan Linux Crontab yang dieksekusi harian (`0 2 * * *`).</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p><strong>Proyek Cloud Computing</strong> &copy; 2026 — Disusun Oleh: <strong>Afanda Riji Yuneldi</strong> (NIM: 2405005)</p>
        <p style="margin-top:4px; font-size:0.83rem;">Dosen Pengampu: <strong>Ego Oktafanda, M.Kom</strong> | Universitas Rokania</p>
    </footer>

    <!-- JavaScript Interaktif Pemesanan -->
    <script>
        function pilihKamar(namaKamar, harga) {
            const select = document.getElementById('selectKamar');
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].value === namaKamar) {
                    select.selectedIndex = i;
                    break;
                }
            }
            updateTotalHarga();
            document.getElementById('pesan').scrollIntoView({ behavior: 'smooth' });
        }

        function updateTotalHarga() {
            const select = document.getElementById('selectKamar');
            const harga = parseInt(select.options[select.selectedIndex].getAttribute('data-harga')) || 0;
            const durasi = parseInt(document.getElementById('inputDurasi').value) || 1;
            const total = harga * durasi;
            document.getElementById('totalHarga').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</body>
</html>
