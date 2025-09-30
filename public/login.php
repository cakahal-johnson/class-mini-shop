<?php include '/../config/db.php' ?>
<?php include '/../config/constants.php' ?>
<?php include '/../src/lib/session.php' ?>
<?php include '/../src/lib/helpers.php' ?>

<?php 

$errors = [];

// Handle login submission
if ($_SERVER[REQUEST_METHOD] === 'POST') {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    //basic validation
    if (empty($email) || empty($pass)) {
     $errors[] = 'Email and Password are required!';   
    }else{
        $stmt = $pdo->prepare("SELECT id, name, email, password_hash, role, is_active FROM users WHERE email = ? LIMIT 1");

        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['is_active'] == 1 && password_verify($pass, $user['password_hash'])) {
            // Prevent session fixattion
            session_regenerate_id(true);

            // Store only safe values in session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email'=> $user['email'],
                'role' => $user['role'],
            ];

          flash('success', 'Welcome back, ' . htmlspecialchars($user['name']), 'alert alert-success');
            redirect('/index.php');
        } else {
            $errors[] = 'Invalid email or password, or account is inactive.';
        }
    }
}

?>

<?php include 'partials/header.php' ?>



<h2>Login</h2>

<form action="" method="POST" class="col-md-6">

    <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required autofocus>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>

</form>

<p class="mt-3">No Account? <a href="register.php">Register here</a> </p>


<?php include 'partials/footer.php' ?>