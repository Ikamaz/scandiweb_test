<?php
include '../Product.php';


$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['productType'];

    switch ($type) {
        case 'DVD':
            $size = $_POST['size'];
            $product = new DVD($sku, $name, $price, $size);
            break;
        case 'Book':
            $weight = $_POST['weight'];
            $product = new Book($sku, $name, $price, $weight);
            break;
        case 'Furniture':
            $height = $_POST['height'];
            $width = $_POST['width'];
            $length = $_POST['length'];
            $dimensions = "$height x $width x $length";
            $product = new Furniture($sku, $name, $price, $height, $width, $length);
            break;
    }

    if (!empty($sku) && !empty($name) && !empty($price)) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE sku = ?");
        $stmt->execute([$sku]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "SKU exists!";
        } else {
            switch ($type) {
                case 'DVD':
                    $stmt = $pdo->prepare("INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$sku, $name, $price, $type, $size]);
                    break;
                case 'Book':
                    $stmt = $pdo->prepare("INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$sku, $name, $price, $type, $weight]);
                    break;
                case 'Furniture':
                    $stmt = $pdo->prepare("INSERT INTO products (sku, name, price, type, dimensions) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$sku, $name, $price, $type, $dimensions]);
                    break;
            }
            header("Location: ../index.php");
            exit();
        }
    } else {
        $errors[] = "Please fill all required fields!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/styles.css">

</head>
<body>
    <div class="container">
        <h1>Add Product</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="product_form">
            <label for="sku">SKU:</label>
            <input type="text" id="sku" name="sku" required>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="price">Price ($):</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>
            
            <label for="productType">Product Type:</label>
            <select id="productType" name="productType" onchange="toggleAttributes()">
                <option cla></option>
                <option value="DVD">DVD</option>
                <option value="Book">Book</option>
                <option value="Furniture">Furniture</option>
            </select>
            
            <div id="size_section" class="display: none;">
                <label for="size">Size (MB):</label>
                <input type="number" id="size" name="size" min="0" step="1">
            </div>
            
            <div id="weight_section" class="display:none">
                <label for="weight">Weight (Kg):</label>
                <input type="number" id="weight" name="weight" min="0" step="0.1">
            </div>
            
            <div id="dimensions_section" class="display:none">
                <label for="height">Height (cm):</label>
                <input type="number" id="height" name="height" min="0" step="1">
                <label for="width">Width (cm):</label>
                <input type="number" id="width" name="width" min="0" step="1">
                <label for="length">Length (cm):</label>
                <input type="number" id="length" name="length" min="0" step="1">
            </div>
            
            <input type="submit" value="Save">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($errors)) {
            echo "<div class='error'>";
            foreach ($errors as $error) {
                echo "<p>{$error}</p>";
            }
            echo "</div>";
        }
        ?>
    </div>

    <script>
        function toggleAttributes() {
            var type = document.getElementById("productType").value;
            var size_section = document.getElementById("size_section");
            var weight_section = document.getElementById("weight_section");
            var dimensions_section = document.getElementById("dimensions_section");
            if (type === "DVD") {
                size_section.style.display = "block";
                weight_section.style.display = "none";
                dimensions_section.style.display = "none";
            } else if (type === "Book") {
                size_section.style.display = "none";
                weight_section.style.display = "block";
                dimensions_section.style.display = "none";
            } else if (type === "Furniture") {
                size_section.style.display = "none";
                weight_section.style.display = "none";
                dimensions_section.style.display = "block";
            }
        }
    </script>
</body>
</html>
