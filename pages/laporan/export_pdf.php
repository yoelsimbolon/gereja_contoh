<?php
/**
 * pages/laporan/export_pdf.php
 * Export laporan ke PDF
 */

require_once "../../core/middleware.php";
require_once "../../core/helper.php";
require_once "../../models/JemaatModel.php";
require_once "../../models/KeluargaModel.php";
require_once "../../models/WilayahModel.php";
require_once "../../vendor/autoload.php";

use Dompdf\Dompdf;

// Pastikan login & role
require_login();
authorize('laporan');

$type       = $_GET['type'] ?? 'jemaat';
$wilayah_id = $_GET['wilayah_id'] ?? null;

$wilayahModel = new WilayahModel();
$wilayahNama  = 'Semua Wilayah';

if ($wilayah_id) {
    $w = $wilayahModel->getById($wilayah_id);
    if ($w) {
        $wilayahNama = $w['nama'];
    }
}

$html = '
<style>
body { font-family: Arial, sans-serif; font-size: 12px; }
h2 { text-align: center; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th, td { border: 1px solid #000; padding: 5px; }
th { background-color: #eee; }
.footer { text-align:center; margin-top:20px; font-size:10px; }
</style>
';


// ================== LAPORAN JEMAAT ==================
if ($type === 'jemaat') {

    $model = new JemaatModel();
    $data  = $model->getReport($wilayah_id);

    $html .= "<h2>Laporan Jemaat</h2>";
    $html .= "<p>Wilayah: <strong>$wilayahNama</strong></p>";

    $html .= "
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>JK</th>
            <th>Tgl Lahir</th>
            <th>Keluarga</th>
            <th>Wilayah</th>
        </tr>
    ";

    $no = 1;
    foreach ($data as $j) {
        $html .= "
        <tr>
            <td>{$no}</td>
            <td>{$j['nama']}</td>
            <td>" . ($j['jenis_kelamin']=='L'?'L':'P') . "</td>
            <td>{$j['tanggal_lahir']}</td>
            <td>{$j['kepala_keluarga']}</td>
            <td>{$j['wilayah']}</td>
        </tr>
        ";
        $no++;
    }

    $html .= "</table>";
}

// ================== LAPORAN KELUARGA ==================
if ($type === 'keluarga') {

    $model = new KeluargaModel();
    $data  = $model->getReport($wilayah_id);

    $html .= "<h2>Laporan Keluarga</h2>";
    $html .= "<p>Wilayah: <strong>$wilayahNama</strong></p>";

    $html .= "
    <table>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Kepala Keluarga</th>
            <th>Wilayah</th>
            <th>Anggota</th>
        </tr>
    ";

    $no = 1;
    foreach ($data as $k) {
        $html .= "
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

    $html .= "</table>";
}

$html .= '
<div class="footer">
Dicetak pada: ' . date('d-m-Y H:i') . '
</div>
';

// ================== GENERATE PDF ==================
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("laporan_$type.pdf", ["Attachment" => true]);
exit;
