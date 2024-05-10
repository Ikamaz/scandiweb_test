<?php
include 'Product.php';

$products = getProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="product-list-container">
        <h1>Product List</h1>
        <button class="add-button" onclick="location.href='crd/add-product.php'">ADD</button>
        <button onclick="deleteProducts()" class="mass-delete-button">MASS DELETE</button>
        <div class="responsive-table">
            <?php foreach ($products as $product) { ?>
            <div class="product-box">
                <input type="checkbox" name="delete[]" class="delete-checkbox" value="<?php echo $product->sku; ?>">
                <div class="product-details">
                    <strong>SKU:</strong> <?php echo $product->sku; ?><br>
                    <strong>Name:</strong> <?php echo $product->name; ?><br>
                    <strong>Price ($):</strong> <?php echo $product->price; ?><br>
                    <strong>Attribute:</strong> <?php echo $product->getAttribute(); ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script>
        function deleteProducts() {
            var checkboxes = document.querySelectorAll('.delete-checkbox:checked');
            if (checkboxes.length === 0) {
                alert("Please select at least one product to delete.");
            } else {
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = false;
                });

                var form = document.createElement('form');
                form.setAttribute('method', 'post');
                form.setAttribute('action', 'crd/delete-products.php');
                checkboxes.forEach(function (checkbox) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', 'delete[]');
                    input.setAttribute('value', checkbox.value);
                    form.appendChild(input);
                });
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

</body>

</html>