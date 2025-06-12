<?php
// manajemenAkun.php (or statusUser.php)
session_start();

// Koneksi ke database
include '../koneksi.php'; // Pastikan path ini benar
include("../modular/headerOperator.php"); // Pastikan path ini benar

// Fungsi untuk mengubah status user
function updateUserStatus($conn, $id, $role, $status) {
    $table = "";
    $id_column = "";
    
    switch ($role) {
        case 'pembaca':
            $table = "pembaca";
            $id_column = "id_pembaca";
            break;
        case 'penulis':
            $table = "penulis";
            $id_column = "id_penulis";
            break;
        default:
            return false;
    }
    
    $sql = "UPDATE $table SET status = ? WHERE $id_column = ?";
    $stmt = mysqli_prepare($conn, $sql);
    // Tambahkan error check untuk prepare statement
    if ($stmt === false) {
        error_log("Failed to prepare statement: " . mysqli_error($conn));
        return false;
    }
    mysqli_stmt_bind_param($stmt, "ss", $status, $id);
    $execute_result = mysqli_stmt_execute($stmt);
    if ($execute_result === false) {
        error_log("Failed to execute statement: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_close($stmt); // Tutup statement setelah digunakan
    return $execute_result;
}

// Proses perubahan status
if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['role'])) {
    $id = $_GET['id'];
    $role = $_GET['role'];
    $action = $_GET['action'];
    
    $pesan = "";
    $redirect_url = "statusUser.php"; // Halaman tujuan setelah aksi

    if ($action === 'activate') {
        $status = 'aktif';
        if (updateUserStatus($conn, $id, $role, $status)) {
            $pesan = "Status berhasil diaktifkan!";
        } else {
            $pesan = "Gagal mengaktifkan status user!";
        }
    } elseif ($action === 'deactivate') {
        $status = 'nonaktif';
        if (updateUserStatus($conn, $id, $role, $status)) {
            $pesan = "Status berhasil dinonaktifkan! User tidak bisa login sampai diaktifkan kembali.";
        } else {
            $pesan = "Gagal menonaktifkan status user!";
        }
    } else {
        $pesan = "Aksi tidak valid!";
    }
    
    // Echo JavaScript alert dan redirect
    echo "<script>alert('" . htmlspecialchars($pesan) . "'); window.location.href='" . $redirect_url . "';</script>";
    exit(); // Penting: Hentikan eksekusi script PHP setelah redirect JavaScript
}

// Ambil data semua user
function getUsers($conn, $role) {
    $table = "";
    $id_column = "";
    $columns = "";
    
    switch ($role) {
        case 'pembaca':
            $table = "pembaca";
            $id_column = "id_pembaca";
            $columns = "$id_column, username, email, status, tanggal_daftar";
            break;
        case 'penulis':
            $table = "penulis";
            $id_column = "id_penulis";
            $columns = "$id_column, username, email, status, tanggal_daftar";
            break;
        default:
            return array();
    }
    
    $sql = "SELECT $columns FROM $table";
    $result = mysqli_query($conn, $sql);
    
    $users = array();
    if ($result) { // Pastikan query berhasil
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    } else {
        error_log("Error fetching users: " . mysqli_error($conn));
    }
    return $users;
}

$pembaca = getUsers($conn, 'pembaca');
$penulis = getUsers($conn, 'penulis');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .status-aktif {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .status-nonaktif {
            background-color: #f8d7da;
            color: #842029;
        }
        .action-btn {
            width: 100px;
            margin: 2px;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-bottom: 3px solid #0d6efd;
        }
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php // include("../modular/headerOperator.php"); // Ini sudah di include di bagian paling atas, hindari double include ?>

    <main class="container mt-5" style="margin-top: 120px !important;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Status User</h2>
        </div>

        <?php /* Notifikasi alert Bootstrap ini tidak lagi digunakan karena kita menggunakan JavaScript alert */ ?>
        <?php /*
        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-<?= $_SESSION['pesan_type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['pesan'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['pesan']); unset($_SESSION['pesan_type']); ?>
        <?php endif; ?>
        */ ?>

        <ul class="nav nav-tabs mb-4" id="accountTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pembaca-tab" data-bs-toggle="tab" data-bs-target="#pembaca" type="button" role="tab">Pembaca</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="penulis-tab" data-bs-toggle="tab" data-bs-target="#penulis" type="button" role="tab">Penulis</button>
            </li>
        </ul>

        <div class="tab-content" id="accountTabsContent">
            <div class="tab-pane fade show active" id="pembaca" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pembaca)): ?>
                                <?php foreach ($pembaca as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id_pembaca']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= $user['status'] ?>">
                                            <?= ucfirst($user['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($user['tanggal_daftar']) ?></td>
                                    <td>
                                        <?php if ($user['status'] == 'aktif'): ?>
                                            <a href="?action=deactivate&id=<?= $user['id_pembaca'] ?>&role=pembaca"
                                               class="btn btn-sm btn-danger action-btn"
                                               onclick="return confirm('Apakah Anda yakin ingin menonaktifkan user ini? User tidak akan bisa login.');">Nonaktifkan</a>
                                        <?php else: ?>
                                            <a href="?action=activate&id=<?= $user['id_pembaca'] ?>&role=pembaca"
                                               class="btn btn-sm btn-success action-btn"
                                               onclick="return confirm('Apakah Anda yakin ingin mengaktifkan user ini?');">Aktifkan</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6">Tidak ada data pembaca.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="penulis" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($penulis)): ?>
                                <?php foreach ($penulis as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id_penulis']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= $user['status'] ?>">
                                            <?= ucfirst($user['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($user['tanggal_daftar']) ?></td>
                                    <td>
                                        <?php if ($user['status'] == 'aktif'): ?>
                                            <a href="?action=deactivate&id=<?= $user['id_penulis'] ?>&role=penulis"
                                               class="btn btn-sm btn-danger action-btn"
                                               onclick="return confirm('Apakah Anda yakin ingin menonaktifkan user ini? User tidak akan bisa login.');">Nonaktifkan</a>
                                        <?php else: ?>
                                            <a href="?action=activate&id=<?= $user['id_penulis'] ?>&role=penulis"
                                               class="btn btn-sm btn-success action-btn"
                                               onclick="return confirm('Apakah Anda yakin ingin mengaktifkan user ini?');">Aktifkan</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6">Tidak ada data penulis.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?php include("../modular/footer.php"); // Pastikan path ini benar ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inisialisasi tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($conn);
?>