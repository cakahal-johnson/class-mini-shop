<?php
session_start();
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../config/constants.php';
    require_once __DIR__ . '/../src/lib/session.php';
    require_once __DIR__ . '/../src/lib/helpers.php';

    // validate product ID
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        die("Invalid product ID.");
    }
    $product_id = (int)$_GET['id'];

    // Fetching product details (With PDO fetch mode for associative array)
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);

    // passing the product into assoc_array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // what happens if the product is not in the database
    if(!$product){
        die("Product not found.");
    }

    // initialize the messages 
    $message = null;

    // add to cart handle
    if(isset($_POST['add_to_cart'])){
        // making sure that the user is registered 
        if(!isset($_SESSION['user_id'])){
            header("Location: login.php");
            exit;
        }

        $user_id = $_SESSION['user_id'];

        // use a transaction to ensure integrity
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
            INSERT INTO cart (user_id, product_id, quantity) VALUES (?,?,? ) ON DUPLICATE KEY UPDATE quantity = quantity + 1
            ");

            $stmt->execute([$user_id, $product_id]);
            $pdo->commit();

            $message = "Product Added to cart";


        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "Failed to add to cart, Please try again";
        }


    }




include 'partials/header.php';
?>

<div class="container mt-4">
    <h2>Product name: <?= htmlspecialchars($product['name'])  ?></h2>

    <!-- image section starts -->
    <img src="assets/img/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product["name"])  ?>" class="img-fluid mb-3">
    <!-- image section ends -->

    <!-- product desc -->
     <p>Product Details: <?= nl2br(htmlspecialchars($product['description'])) ?> </p>
    <!-- product desc ends-->

    <!-- product price -->
     <p><strong>Price:</strong> <?= priceFormat($product['price']) ?> </p>
     <!-- product price ends -->
     
     <!-- product qty or stock -->
     <p><strong>Stock:</strong> <?= (int)$product['stock'] ?> </p>
    <!-- product qty or stock ends-->

    <!-- display message -->
     <?php if(!empty($message)): ?>
        <div class="alert alert-info"> <?= htmlspecialchars($message) ?></div>
     <?php endif; ?>

    <form method="POST" class="mb-3">
         <!-- add cart -->
         <button type="submit" name="add_to_cart" class="btn btn-primary"> <i class="bi bi-cart"></i> Add to Cart </button>
         <!-- add cart ends -->

         <!-- add fav -->
         <button type="submit" name="add_to_favourites" class="btn btn-warning"> <i class="bi bi-star"></i> Add to Favourites </button>
         <!-- add fav -->

     </form>
</div>

<!-- 
prepare(string $query, array $options = []): bool|PDOStatement
$query: This must be a valid SQL statement template for the target database server.


Prepares a statement for execution and returns a statement object
Prepares an SQL statement to be executed by the PDOStatement::execute() method. The statement template can contain zero or more named (:name) or question mark (?) parameter markers for which real values will be substituted when the statement is executed. Both named and question mark parameter markers cannot be used within the same statement template; only one or the other parameter style. Use these parameters to bind any user-input

-->

<!-- 
execute(array|null $params = null): bool
$params: An array of values with as many elements as there are bound parameters in the SQL statement being executed. All values are treated as PDO::PARAM_STR . Multiple values cannot be bound to a single parameter; for example, it is not allowed to bind two values to a single named parameter in an IN() clause. Binding more values than specified is not possible; if more keys exist in params than in the SQL specified in the PDO::prepare(), then the statement will fail and an error is emitted.


Executes a prepared statement

-->

<!-- 
fetch(int $mode = PDO::FETCH_DEFAULT, int $cursorOrientation = PDO::FETCH_ORI_NEXT, int $cursorOffset = 0): mixed
$mode: Controls how the next row will be returned to the caller. This value must be one of the PDO::FETCH_* constants, defaulting to value of PDO::ATTR_DEFAULT_FETCH_MODE (which defaults to PDO::FETCH_BOTH).

PDO::FETCH_ASSOC: returns an array indexed by column name as returned in your result set

PDO::FETCH_BOTH (default): returns an array indexed by both column name and 0-indexed column number as returned in your result set

PDO::FETCH_BOUND: returns true and assigns the values of the columns in your result set to the PHP variables to which they were bound with the PDOStatement::bindColumn() method

PDO::FETCH_CLASS: returns a new instance of the requested class. The object is initialized by mapping the columns of the result set to properties in the class. This occurs before the constructor is called, allowing properties to be populated regardless of their visibility or whether they are marked as readonly. If a property does not exist in the class, the magic __set() method will be invoked if it exists; otherwise, a dynamic public property will be created. However, when PDO::FETCH_PROPS_LATE is also given, the constructor is called before the properties are populated. If mode includes PDO::FETCH_CLASSTYPE (e.g. PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE), the name of the class is determined from the value of the first column.

PDO::FETCH_INTO: updates an existing instance of the requested class, mapping the columns of the result set to named properties in the class

PDO::FETCH_LAZY: combines PDO::FETCH_BOTH and PDO::FETCH_OBJ, and is returning a PDORow object which is creating the object property names as they are accessed.

PDO::FETCH_NAMED: returns an array with the same form as PDO::FETCH_ASSOC, except that if there are multiple columns with the same name, the value referred to by that key will be an array of all the values in the row that had that column name

PDO::FETCH_NUM: returns an array indexed by column number as returned in your result set, starting at column 0

PDO::FETCH_OBJ: returns an anonymous object with property names that correspond to the column names returned in your result set

PDO::FETCH_PROPS_LATE: when used with PDO::FETCH_CLASS, the constructor of the class is called before the properties are assigned from the respective column values.


Fetches the next row from a result set
Fetches a row from a result set associated with a PDOStatement object. The `mode` parameter determines how PDO returns the row.

-->

<?php include 'partials/footer.php'; ?>