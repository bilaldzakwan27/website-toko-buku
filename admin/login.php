<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #212529;">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img class="logo-big" src="../img/book-fill.png" alt="Logo">bukuKami
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Login Admin</h2>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="gmail" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button class="btn btn-primary btn-block" name="login">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    session_start();
    $koneksi = new mysqli("localhost", "root", "", "pembelianBuku");

    if (isset($_POST["login"])) {
        $gmail = $_POST['gmail'];
        $password = $_POST['password'];

        $query = "SELECT * FROM admin WHERE username='$gmail' AND password='$password'";
        $result = $koneksi->query($query);

        if ($result->num_rows == 1) {
            $_SESSION['admin'] = $result->fetch_assoc();
            echo "<script> alert('Login Berhasil'); </script>";
            header("Location: index.php"); // Redirect to index.php
            exit(); // Ensure no more output is sent
        } else {
            echo "<script> alert('Login Gagal, Tekan Ok Untuk Coba Lagi'); </script>";
        }
    }
    ?>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
