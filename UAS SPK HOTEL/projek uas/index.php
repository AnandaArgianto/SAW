<?php
session_start();
if (isset($_GET['aksi']) && $_GET['aksi'] == 'login') {
    include 'asset/conn/config.php';

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $stmt = $con->prepare("SELECT * FROM akun WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $cek = $result->num_rows;

    if ($cek > 0) {
        $data = $result->fetch_assoc();
        if ($data['level'] == 'Admin') {
            $_SESSION['username'] = $data['username'];
            header("Location: admin/index.php");
            exit();
        } elseif ($data['level'] == 'Pengguna') {
            $_SESSION['username'] = $data['username'];
            header("Location: pengguna/index.php");
            exit();
        }
    } else {
        header("Location: index.php?pesan=gagal");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PENERAPAN METODE SAW</title>
    <link rel="stylesheet" type="text/css" href="asset/css/cosmo.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #007bff, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            padding: 15px;
        }

        .form-wrapper {
            display: flex;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Adjust width as needed */
            width: 100%;
        }

        .form-wrapper .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .form-wrapper .image-container img {
            max-width: 100%;
            border-radius: 10px;
        }

        .form-container {
            flex: 1;
            padding: 30px;
            text-align: center;
        }

        .form-container h2 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-group .fa {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .footer {
            margin-top: 20px;
            color: #666;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <div class="image-container">
                <!-- Ensure the path to your image is correct -->
                <img src="asset/image/login.jpg" alt="Login Image">
            </div>
            <div class="form-container">
                <?php
                if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
                    echo "<div class='alert alert-danger' role='alert'>Maaf, login Anda gagal.</div>";
                }
                ?>
                <h2>Login</h2>
                <form action="index.php?aksi=login" method="post">
                    <div class="form-group">
                        <label for="username"><i class="fas fa-user"></i> Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn btn-primary btn-block">
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</body>
</html>
