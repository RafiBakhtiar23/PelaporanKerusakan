<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card-glass col-md-4">
    <h3 class="text-center mb-4">🔐 Login Sistem</h3>

<form method="POST" action="login_process.php">
      <input class="form-control mb-3" name="username" placeholder="Username" required>
      <input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
      <button class="btn btn-main w-100">Login</button>
    </form>
  </div>
</div>

</body>
</html>
