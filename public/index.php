<?php
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../config/constants.php';
    require_once __DIR__ . '/../src/lib/session.php';
    require_once __DIR__ . '/../src/lib/helpers.php';

    //fetching datas from the product table as $p
    $stmt = $pdo->query("SELECT id, name, price, image FROM products WHERE is_active = 1 LIMIT 6");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
include 'partials/header.php';
?>

<h1 class="mb-4">Welcome to <?= APP_NAME ?> </h1>

<div class="row">
    <?php foreach($products as $p): ?> 
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img src="<?= BASE_URL ?>/assets/img/default.jpg" alt="<?= htmlspecialchars($p['name']) ?>" class="card-img-top"
              style="height:250px;object-fit:cover;"> 
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                <p class="card-text"><?= priceFormat($p['price']) ?>
                <span style="float:right"><strike>10%</strike></span>
                </p>
                <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-primary mt-auto">View</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include 'partials/footer.php'; ?>