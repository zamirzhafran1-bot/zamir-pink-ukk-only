<?php
session_start();
if (isset($_SESSION['role'])) {
    header("Location: ../".$_SESSION['role']."/dashboard.php");
    exit;
}
?>
<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success text-center">
    Registrasi berhasil, silakan login
</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | UKK Peminjaman</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme -->
    <link rel="stylesheet" href="../assets/style.css">

    <style>
        .animate {
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 38px;
            font-size: 18px;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center vh-100">

<div class="col-md-4 col-sm-10">

    <div class="card shadow-lg border-0 rounded-4 p-4 animate">

        <div class="text-center mb-3">
            <img src="../assets/smk.png" width="70">
            <h4 class="mt-2 fw-bold">SIPINJAM SMK </h4>
            <small>Silakan login untuk melanjutkan</small>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert text-center">
                Username atau Password salah
            </div>
        <?php endif; ?>

        <form method="post" action="proses_login.php">

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3 position-relative">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

            <button class="btn btn-primary w-100 rounded-pill">
                Login
            </button>
<a href="register.php" class="btn btn-outline-secondary w-100 mt-2 rounded-pill">
Register Akun Baru
</a>

        </form>
    </div>
</div>

<script>
function togglePassword() {
    let pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
