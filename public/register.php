<?php include '/../config/db.php' ?>
<?php include '/../config/constants.php' ?>
<?php include '/../src/lib/session.php' ?>
<?php include '/../src/lib/helpers.php' ?>

<?php 

$errors = [];

if ($_SERVER[REQUEST_METHOD] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password1 = $_POST['password'];
    $password2 = $_POST['password_confirm'];

    //basic validation
    if ($name === '') $errors[] = 'Name is required!'; 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required';
    if ($password1 !== $password2) $errors[] = 'Password do not match!';
    if (strlen(trim($password1)) < 6 || strlen(trim($password2)) > 255) $errors[] = 'Password must be at least 6 characters';

    // errors handle
    if (empty($errors)) {
        // check duplicate email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email already used";
        }else {
            $hash = password_hash($password1, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user (name, email, password_hash, role) VALUES (?,?,?, 'user')");

            $stmt->execute([$name, $email, $hash]);
            flash("success","Registration successful! You can now login", 'alert alert-success');
            redirect('/login.php');
        }
    }
}

?>

<?php include 'partials/header.php' ?>


<h2>Register</h2>

<form action="" method="POST" class="col-md-6">

    <div class="mb-3">
        <label class="form-label" for="name">Name</label>
        <input type="name" name="name" id="name" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label" for="password_confirm">Password_confirm</label>
        <input type="password_confirm" name="password_confirm" id="password_confirm" class="form-control" required autofocus>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>

</form>

<hr>

<p class="mt-3">Already have an account? <a href="login.php">Login here</a> </p>


<?php include 'partials/footer.php' ?>