<?php
require_once __DIR__ . '/../../config/constants.php'
  ?>
<!doctype html>
<html lang="en">

<head>
  <title><?= APP_NAME ?></title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="assets/css/app.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <!-- app logo -->
        <a href="<?= BASE_URL ?>/index.php" class="navbar-brand"><?= APP_NAME ?></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

        <!-- nav bar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="<?= BASE_URL ?>/cart.php" class="nav-link">Cart</a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_URL ?>/favourites.php" class="nav-link">My Favourites</a>
            </li>
            <?php if (!empty($_SESSION['user'])): ?>
              <li class="nav-item"><a class="nav-link"
                  href="<?= BASE_URL ?>/profile.php"><?= htmlspecialchars($_SESSION['user']['name']) ?></a></li>
              <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/logout.php">Logout</a></li>
            <?php else: ?>
              <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/login.php">Login</a></li>
            <?php endif; ?>
          </ul>
        </div>

      </div>

    </nav>
  </header>
  <!-- opening div -->
  <div class="container my-4"> <!-- closing in our footer -->