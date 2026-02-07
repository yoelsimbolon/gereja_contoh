<?php
/**
 * pages/laporan/export_excel.php
 * Export laporan ke Excel
 */

require_once "../../core/middleware.php";
require_once "../../core/helper.php";
require_once "../../models/JemaatModel.php";
require_once "../../models/KeluargaModel.php";
require_once "../../models/WilayahModel.php";

// Pastikan user login
require_login();

// Hak akses laporan
authorize('laporan');

// Jenis laporan
$type = $_GET['type'] ?? 'jemaat'; // jemaat | keluarga
$wilayah_id = $_GET['wilayah_id'] ?? null;

$wilayahModel = new WilayahModel();
$wilayahNama  = 'Semua Wilayah';

if ($wilayah_id) {
    $w = $wilayahModel->getById($wilayah_id);
    if ($w) {
        $wilayahNama = $w['nama'];
    }
}

// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_$type.xls");
header("Pragma: no-cache");
header("Expires: 0");

// ================== LAPORAN JEMAAT ==================
if ($type === 'jemaat') {

    $jemaatModel = new JemaatModel();
    $data = $jemaatModel->getReport($wilayah_id);

    echo "<h3>Laporan Jemaat</h3>";
    echo "<p>Wilayah: <strong>$wilayahNama</strong></p>";

    echo "<table border='1' cellpadding='5'>";
    echo "
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal Lahir</th>
            <th>Keluarga</th>
            <th>Wilayah</th>
        </tr>
    ";

    $no = 1;
    foreach ($data as $j) {
        echo "
            <tr>
                <td>{$no}</td>
                <td>{$j['nama']}</td>
                <td>" . ($j['jenis_kelamin']=='L'?'Laki-laki':'Perempuan') . "</td>
                <td>{$j['tanggal_lahir']}</td>
                <td>{$j['kepala_keluarga']}</td>
                <td>{$j['wilayah']}</td>
            </tr>
        ";
        $no++;
    }

    echo "</table>";
    exit;
}

// ================== LAPORAN KELUARGA ==================
if ($type === 'keluarga') {

    $keluargaModel = new KeluargaModel();
    $data = $keluargaModel->getReport($wilayah_id);

    echo "<h3>Laporan Keluarga</h3>";
    echo "<p>Wilayah: <strong>$wilayahNama</strong></p>";

    echo "<table border='1' cellpadding='5'>";
    echo "
        <tr>
            <th>No</th>
            <th>Kode Keluarga</th>
            <th>Kepala Keluarga</th>
            <th>Wilayah</th>
            <th>Jumlah Anggota</th>
        </tr>
    ";

    $no = 1;
    foreach ($data as $k) {
        echo "
            <tr>
                <td>{$no}</td>
                <td>{$k['kode_keluarga']}</td>
                <td>{$k['kepala_keluarga']}</td>
                <td>{$k['wilayah']}</td>
                <td>{$k['jumlah_anggota']}</td>
            </tr>
        ";
        $no++;
    }

    echo "</table>";
    exit;
}

// Jika type tidak valid
set_flash('error', 'Jenis laporan tidak valid');
redirect('index.php');
