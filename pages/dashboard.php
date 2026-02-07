<?php
/**
 * pages/dashboard.php
 */
require_once "../core/middleware.php";
require_once "../config/database.php"; 
require_once "../layout/header.php";

require_login();

// --- FUNGSI GET_COUNT ---
function get_count($sql) {
    global $conn; 
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_row();
        return $row[0];
    }
    return 0;
}

// --- AMBIL DATA ---
$totalJemaat   = get_count("SELECT COUNT(*) FROM jemaat");
$totalKeluarga = get_count("SELECT COUNT(*) FROM keluarga");
$totalWilayah  = get_count("SELECT COUNT(*) FROM wilayah");
$totalUser     = get_count("SELECT COUNT(*) FROM users");

$jk = ['L' => 0, 'P' => 0];
$resJk = $conn->query("SELECT jenis_kelamin, COUNT(*) as total FROM jemaat GROUP BY jenis_kelamin");
if ($resJk) {
    while ($row = $resJk->fetch_assoc()) {
        $jk[$row['jenis_kelamin']] = $row['total'];
    }
}

$wilayah = [];
$resWil = $conn->query("
    SELECT w.nama_wilayah AS nama, COUNT(j.id) as total
    FROM wilayah w
    LEFT JOIN keluarga k ON k.wilayah_id = w.id
    LEFT JOIN jemaat j ON j.keluarga_id = k.id
    GROUP BY w.id
    ORDER BY total DESC
    LIMIT 5
");
if ($resWil) {
    while ($row = $resWil->fetch_assoc()) {
        $wilayah[] = $row;
    }
}
?>

<div class="d-flex">

    <?php require_once "../layout/sidebar.php"; ?>

    <div class="flex-grow-1 p-4" style="overflow-y: auto; height: 100vh; background-color: #f8f9fa;">
        <div class="container-fluid">
            <h3 class="mb-4">Dashboard</h3>

            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3 shadow-sm">
                        <div class="card-body">
                            <h5>Total Jemaat</h5>
                            <h2><?= $totalJemaat; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3 shadow-sm">
                        <div class="card-body">
                            <h5>Total Keluarga</h5>
                            <h2><?= $totalKeluarga; ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3 shadow-sm">
                        <div class="card-body">
                            <h5>Wilayah</h5>
                            <h2><?= $totalWilayah; ?></h2>
                        </div>
                    </div>
                </div>
                <?php if (has_role('admin')): ?>
                <div class="col-md-3">
                    <div class="card text-white bg-dark mb-3 shadow-sm">
                        <div class="card-body">
                            <h5>User Sistem</h5>
                            <h2><?= $totalUser; ?></h2>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">Jemaat Berdasarkan Jenis Kelamin</div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Laki-laki
                                    <span class="badge bg-primary rounded-pill"><?= $jk['L'] ?? 0; ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Perempuan
                                    <span class="badge bg-danger rounded-pill"><?= $jk['P'] ?? 0; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">Top Wilayah (Jumlah Jemaat)</div>
                        <div class="card-body">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Wilayah</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($wilayah as $w): ?>
                                    <tr>
                                        <td><?= $w['nama']; ?></td>
                                        <td><?= $w['total']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../layout/footer.php"; ?>