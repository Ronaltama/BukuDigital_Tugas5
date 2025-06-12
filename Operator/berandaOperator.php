<?php
session_start(); // Start session for messages

// Include necessary header and database connection
include("../modular/headerOperator.php");

// Sertakan file koneksi database
include("../koneksi.php"); // Ensure this file establishes $conn

// Aktifkan pelaporan error penuh untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize counts
$pendingBooksCount = 0;
$pendingPaymentsCount = 0;
$rejectedBooksCount = 0;

// Fetch counts from database if connection is successful
if ($conn) {
    // Count for Pending Books (status_verifikasi di tabel buku sudah benar)
    $sqlBooksCount = "SELECT COUNT(*) AS total FROM buku WHERE status_verifikasi = 'pending'";
    $resultBooksCount = $conn->query($sqlBooksCount);
    if ($resultBooksCount && $resultBooksCount->num_rows > 0) {
        $rowBooksCount = $resultBooksCount->fetch_assoc();
        $pendingBooksCount = $rowBooksCount['total'];
    }

    // Count for Pending Payments (MENGGUNAKAN `status_pembayaran`)
    $sqlPaymentsCount = "SELECT COUNT(*) AS total FROM pembayaran WHERE status_pembayaran = 'pending'";
    $resultPaymentsCount = $conn->query($sqlPaymentsCount);
    if ($resultPaymentsCount && $resultPaymentsCount->num_rows > 0) {
        $rowPaymentsCount = $resultPaymentsCount->fetch_assoc();
        $pendingPaymentsCount = $rowPaymentsCount['total'];
    }

    // Count for Rejected Books
    $sqlRejectedBooksCount = "SELECT COUNT(*) AS total FROM buku WHERE status_verifikasi = 'ditolak'";
    $resultRejectedBooksCount = $conn->query($sqlRejectedBooksCount);
    if ($resultRejectedBooksCount && $resultRejectedBooksCount->num_rows > 0) {
        $rowRejectedBooksCount = $resultRejectedBooksCount->fetch_assoc();
        $rejectedBooksCount = $rowRejectedBooksCount['total'];
    }
}

// --- Start of User Status Management Logic ---

// Function to update user status
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
    mysqli_stmt_bind_param($stmt, "ss", $status, $id);
    return mysqli_stmt_execute($stmt);
}

// Process status change requests for Users (Pembaca/Penulis)
if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['role'])) {
    $id = $_GET['id'];
    $role = $_GET['role'];
    $action = $_GET['action'];

    $message = "";
    $success = false;

    if ($action === 'activate') {
        $status = 'aktif';
        if (updateUserStatus($conn, $id, $role, $status)) {
            $message = "Status pengguna berhasil diaktifkan!";
            $success = true;
        } else {
            $message = "Gagal mengaktifkan status pengguna: " . $conn->error;
        }
    } elseif ($action === 'deactivate') {
        $status = 'nonaktif';
        if (updateUserStatus($conn, $id, $role, $status)) {
            $message = "Status pengguna berhasil dinonaktifkan!";
            $success = true;
        } else {
            $message = "Gagal menonaktifkan status pengguna: " . $conn->error;
        }
    } else {
        $message = "Aksi tidak valid!";
    }

    echo "<script>alert('" . htmlspecialchars($message) . "'); window.location.href='berandaOperator.php';</script>";
    exit(); // Always exit after JavaScript redirect
}

// Function to get users based on role
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
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}

$pembaca = getUsers($conn, 'pembaca');
$penulis = getUsers($conn, 'penulis');

// --- End of User Status Management Logic ---

// --- Begin: Process Payment Verification (from verifikasipembayaran.php logic) ---
// This part would ideally be in verifikasipembayaran.php, but if you want to keep
// all processing in one dashboard file, this is how you'd include it.
if (isset($_GET['payment_id']) && isset($_GET['payment_action'])) {
    $id_pembayaran = $_GET['payment_id'];
    $action = $_GET['payment_action']; // 'verify' or 'reject'

    $message = "";
    $status_update = "";

    if ($action === 'verify') {
        $status_update = 'terverifikasi';
        $message = "Pembayaran berhasil diverifikasi!";
    } elseif ($action === 'reject') {
        $status_update = 'ditolak';
        $message = "Pembayaran berhasil ditolak.";
    } else {
        $message = "Aksi tidak valid untuk pembayaran.";
    }

    if (!empty($status_update)) {
        $stmt_payment = $conn->prepare("UPDATE pembayaran SET status_pembayaran = ? WHERE id_pembayaran = ?");
        $stmt_payment->bind_param("ss", $status_update, $id_pembayaran);

        if ($stmt_payment->execute()) {
            echo "<script>alert('" . htmlspecialchars($message) . "'); window.location.href='berandaOperator.php';</script>";
        } else {
            echo "<script>alert('Error mengupdate pembayaran: " . htmlspecialchars($stmt_payment->error) . "'); window.location.href='berandaOperator.php';</script>";
        }
        $stmt_payment->close();
    } else {
        echo "<script>alert('" . htmlspecialchars($message) . "'); window.location.href='berandaOperator.php';</script>";
    }
    exit();
}
// --- End: Process Payment Verification ---


// --- Begin: Process Book Verification (from prosesVerifikasi.php and reject_book.php logic) ---
// This section assumes operator_id is available (e.g., from session) if needed for logging.
// For simplicity, I'm assuming it's just updating book status here.
// You might need to adjust variable names like $operator_id if your schema requires it.

if (isset($_GET['book_id']) && isset($_GET['book_action'])) {
    $id_buku = $_GET['book_id'];
    $action = $_GET['book_action']; // 'verify' or 'reject'

    $message = "";
    $status_update = "";
    $redirect_page = 'berandaOperator.php'; // Default redirect

    if ($action === 'verify') {
        $status_update = 'terverifikasi';
        $message = "Buku berhasil diverifikasi!";
    } elseif ($action === 'reject') {
        $status_update = 'ditolak';
        $message = "Buku berhasil ditolak.";
    } else {
        $message = "Aksi tidak valid untuk buku.";
    }

    if (!empty($status_update)) {
        // Assuming your 'buku' table has a 'status_verifikasi' column
        $stmt_book = $conn->prepare("UPDATE buku SET status_verifikasi = ? WHERE id_buku = ?");
        $stmt_book->bind_param("ss", $status_update, $id_buku); // Assuming status is string, ID is string/int

        if ($stmt_book->execute()) {
            echo "<script>alert('" . htmlspecialchars($message) . "'); window.location.href='" . $redirect_page . "';</script>";
        } else {
            echo "<script>alert('Error mengupdate buku: " . htmlspecialchars($stmt_book->error) . "'); window.location.href='" . $redirect_page . "';</script>";
        }
        $stmt_book->close();
    } else {
        echo "<script>alert('" . htmlspecialchars($message) . "'); window.location.href='" . $redirect_page . "';</script>";
    }
    exit();
}
// --- End: Process Book Verification ---

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Operator</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="../style.css" />
    <style>
        /* Your existing CSS */
        .scroll-container {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 10px;
        }

        .scroll-container::-webkit-scrollbar {
            height: 8px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            border: 1px solid #eee;
        }

        .scroll-btn.left {
            left: -20px;
        }

        .scroll-btn.right {
            right: -20px;
        }

        .book-card {
            width: 200px;
            flex-shrink: 0;
        }

        .book-card .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            width: 90px;
            text-align: center;
            padding: 6px 12px;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            box-sizing: border-box;
        }

        .verifikasi {
            background-color: green;
        }

        .tolak {
            background-color: red;
        }

        /* --- Dashboard Card Styles --- */
        .dashboard-overview {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background-color: #f8f9fa;
            border: 1px solid #e2e6ea;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            width: 30%;
            min-width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-card h4 {
            margin-top: 0;
            color: #343a40;
            font-size: 1.2em;
        }

        .dashboard-card .count {
            font-size: 2.5em;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }

        .dashboard-card .card-link {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .card-link.inactive {
            color: #6c757d;
            pointer-events: none;
            cursor: default;
        }


        .dashboard-card .card-link:hover {
            text-decoration: underline;
        }

        /* Responsive table for mobile views */
        @media screen and (max-width: 768px) {
            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
                margin-bottom: 10px;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                text-align: right;
            }

            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-label);
                font-weight: bold;
                text-align: left;
            }

            /* Adjust action buttons for smaller screens */
            td:last-child {
                text-align: left;
                padding-left: 6px;
            }
        }

        /* New CSS for User Status */
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

    <main class="container mt-5" style="margin-top: 120px !important;">
        <h2>Dashboard Operator</h2>
        <p>Selamat datang, Operator <strong>[Nama Operator]</strong></p>
        <div class="dashboard-overview">
            <div class="dashboard-card">
                <h4>Pembayaran Menunggu Verifikasi</h4>
                <div class="count"><?php echo $pendingPaymentsCount; ?></div>
                <a href="verifikasipemayaran.php" class="card-link <?php echo ($pendingPaymentsCount == 0) ? 'inactive' : ''; ?>">Lihat Detail Pembayaran</a>
            </div>
            <div class="dashboard-card">
                <h4>Buku Menunggu Verifikasi</h4>
                <div class="count"><?php echo $pendingBooksCount; ?></div>
                <a href="prosesVerifikasi.php" class="card-link <?php echo ($pendingBooksCount == 0) ? 'inactive' : ''; ?>">Lihat Detail Buku</a>
            </div>
            <div class="dashboard-card">
                <h4>Buku Ditolak</h4>
                <div class="count"><?php echo $rejectedBooksCount; ?></div>
                <a href="reject_book.php" class="card-link <?php echo ($rejectedBooksCount == 0) ? 'inactive' : ''; ?>">Lihat Detail Buku Ditolak</a>
            </div>
        </div>

        <h3>Daftar Pembayaran Menunggu Verifikasi</h3>
        <table>
            <tr>
                <th>ID Pembayaran</th>
                <th>Pengguna</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php
            if ($conn) {
                // SQL query to fetch payments with 'pending' status, joining 'sewa' and 'pembaca' tables
                $sqlPayments = "SELECT
                                        p.id_pembayaran,
                                        p.jumlah,
                                        p.tgl_pembayaran,
                                        p.status_pembayaran,
                                        pb.username AS nama_pengguna
                                    FROM
                                        pembayaran p
                                    JOIN
                                        sewa s ON p.id_sewa = s.id_sewa
                                    JOIN
                                        pembaca pb ON s.id_pembaca = pb.id_pembaca
                                    WHERE
                                        p.status_pembayaran = 'pending'
                                    ORDER BY
                                        p.tgl_pembayaran ASC";
                $resultPayments = $conn->query($sqlPayments);

                if (!$resultPayments) {
                    echo "<tr><td colspan='6'>Error kueri: " . $conn->error . "</td></tr>";
                } elseif ($resultPayments->num_rows > 0) {
                    while ($rowPayment = $resultPayments->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='ID Pembayaran'>" . htmlspecialchars($rowPayment["id_pembayaran"]) . "</td>";
                        echo "<td data-label='Pengguna'>" . htmlspecialchars($rowPayment["nama_pengguna"]) . "</td>";
                        echo "<td data-label='Jumlah'>Rp " . number_format($rowPayment["jumlah"], 0, ',', '.') . "</td>";
                        echo "<td data-label='Tanggal'>" . htmlspecialchars($rowPayment["tgl_pembayaran"]) . "</td>";
                        echo "<td data-label='Status'>" . htmlspecialchars(ucfirst($rowPayment["status_pembayaran"])) . "</td>";
                        echo "<td data-label='Aksi'>";
                        // Changed href to use 'payment_id' and 'payment_action' to differentiate from user actions
                        echo "<a href='?payment_id=" . htmlspecialchars($rowPayment["id_pembayaran"]) . "&payment_action=verify' class='button verifikasi' onclick=\"return confirm('Apakah Anda yakin ingin memverifikasi pembayaran ini?');\">Verifikasi</a>";
                        echo "<a href='?payment_id=" . htmlspecialchars($rowPayment["id_pembayaran"]) . "&payment_action=reject' class='button tolak' onclick=\"return confirm('Apakah Anda yakin ingin menolak pembayaran ini?');\">Tolak</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada pembayaran yang menunggu verifikasi saat ini.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Koneksi database gagal.</td></tr>";
            }
            ?>
        </table>

        <h3>Daftar Buku Menunggu Verifikasi</h3>
        <table>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Penulis</th>
                <th>Aksi</th>
            </tr>

            <?php
            // Logic verifikasi buku yang sudah ada
            if ($conn) {
                // Pastikan status_verifikasi untuk buku sudah benar
                $sqlBooks = "SELECT b.id_buku, b.judul, b.deskripsi, p.username AS nama_penulis
                             FROM buku b
                             JOIN penulis p ON b.id_penulis = p.id_penulis
                             WHERE b.status_verifikasi = 'pending'
                             ORDER BY b.tanggal_upload ASC";
                $resultBooks = $conn->query($sqlBooks);

                if (!$resultBooks) {
                    echo "<tr><td colspan='4'>Error kueri buku: " . $conn->error . "</td></tr>";
                } elseif ($resultBooks->num_rows > 0) {
                    while ($rowBook = $resultBooks->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='Judul'>" . htmlspecialchars($rowBook["judul"]) . "</td>";
                        echo "<td data-label='Deskripsi'>" . htmlspecialchars($rowBook["deskripsi"]) . "</td>";
                        echo "<td data-label='Penulis'>" . htmlspecialchars($rowBook["nama_penulis"]) . "</td>";
                        echo "<td data-label='Aksi'>";
                        // Changed href to use 'book_id' and 'book_action'
                        echo "<a href='?book_id=" . htmlspecialchars($rowBook["id_buku"]) . "&book_action=verify' class='button verifikasi' onclick=\"return confirm('Apakah Anda yakin ingin memverifikasi buku ini?');\">Verifikasi</a>";
                        echo "<a href='?book_id=" . htmlspecialchars($rowBook["id_buku"]) . "&book_action=reject' class='button tolak' onclick=\"return confirm('Apakah Anda yakin ingin menolak buku ini?');\">Tolak</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada buku yang menunggu verifikasi.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Koneksi database gagal.</td></tr>";
            }
            ?>
        </table>

        <h2>Status User</h2>

        <?php // The alert div for user status changes is no longer needed since we use JS alert directly ?>
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
                                    <td data-label="ID"><?= htmlspecialchars($user['id_pembaca']) ?></td>
                                    <td data-label="Username"><?= htmlspecialchars($user['username']) ?></td>
                                    <td data-label="Email"><?= htmlspecialchars($user['email']) ?></td>
                                    <td data-label="Status">
                                        <span class="status-badge status-<?= $user['status'] ?>">
                                            <?= ucfirst($user['status']) ?>
                                        </span>
                                    </td>
                                    <td data-label="Tanggal Daftar"><?= htmlspecialchars($user['tanggal_daftar']) ?></td>
                                    <td data-label="Aksi">
                                        <?php if ($user['status'] == 'aktif'): ?>
                                            <a href="?action=deactivate&id=<?= $user['id_pembaca'] ?>&role=pembaca"
                                               class="btn btn-sm btn-danger action-btn"
                                               onclick="return confirm('Apakah Anda yakin ingin menonaktifkan user ini? User tidak akan bisa login.');">Nonaktifkan</a>
                                        <?php else: ?>
                                            <a href="?action=activate&id=<?= $user['id_pembaca'] ?>&role=pembaca" class="btn btn-sm btn-success action-btn" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan user ini?');">Aktifkan</a>
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
                                    <td data-label="ID"><?= htmlspecialchars($user['id_penulis']) ?></td>
                                    <td data-label="Username"><?= htmlspecialchars($user['username']) ?></td>
                                    <td data-label="Email"><?= htmlspecialchars($user['email']) ?></td>
                                    <td data-label="Status">
                                        <span class="status-badge status-<?= $user['status'] ?>">
                                            <?= ucfirst($user['status']) ?>
                                        </span>
                                    </td>
                                    <td data-label="Tanggal Daftar"><?= htmlspecialchars($user['tanggal_daftar']) ?></td>
                                    <td data-label="Aksi">
                                        <?php if ($user['status'] == 'aktif'): ?>
                                            <a href="?action=deactivate&id=<?= $user['id_penulis'] ?>&role=penulis"
                                               class="btn btn-sm btn-danger action-btn"
                                               onclick="return confirm('Apakah Anda yakin ingin menonaktifkan user ini? User tidak akan bisa login.');">Nonaktifkan</a>
                                        <?php else: ?>
                                            <a href="?action=activate&id=<?= $user['id_penulis'] ?>&role=penulis" class="btn btn-sm btn-success action-btn" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan user ini?');">Aktifkan</a>
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

    <br><br><br><br>

    <?php
    // Include the footer
    include("../modular/footerFitur.php");
    ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
    <script>
        // Inisialisasi tooltips (if any are used in the future)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>

</html>

<?php
// Tutup koneksi database setelah semua query selesai
if ($conn) {
    $conn->close();
}
?>