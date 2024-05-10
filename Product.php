<?php
include 'config.php';

abstract class Product {
    public $sku;
    public $name;
    public $price;

    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    abstract public function getAttribute();

    public function displayProduct() {
        echo "<tr>";
        echo "<td>{$this->sku}</td>";
        echo "<td>{$this->name}</td>";
        echo "<td>{$this->price}</td>";
        echo "<td>{$this->getAttribute()}</td>";
        echo "</tr>";
    }
}

class DVD extends Product {
    public $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function getAttribute() {
        return "Size: {$this->size} MB";
    }
}

class Book extends Product {
    public $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function getAttribute() {
        return "Weight: {$this->weight} Kg";
    }
}

class Furniture extends Product {
    public $height;
    public $width;
    public $length;

    public function __construct($sku, $name, $price, $height, $width, $length) {
        parent::__construct($sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getAttribute() {
        return "Dimensions: {$this->height}x{$this->width}x{$this->length} cm";
    }
}

function getProducts() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM products");
    $products = [];
    while ($row = $stmt->fetch()) {
        switch ($row['type']) {
            case 'DVD':
                $products[] = new DVD($row['sku'], $row['name'], $row['price'], $row['size']);
                break;
            case 'Book':
                $products[] = new Book($row['sku'], $row['name'], $row['price'], $row['weight']);
                break;
            case 'Furniture':
                list($height, $width, $length) = explode('x', $row['dimensions']);
                $products[] = new Furniture($row['sku'], $row['name'], $row['price'], $height, $width, $length);
                break;
        }
    }
    return $products;
}


?>
