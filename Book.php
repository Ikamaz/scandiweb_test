<?php

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function displayProduct() {
        echo "<tr>";
        echo "<td>{$this->sku}</td>";
        echo "<td>{$this->name}</td>";
        echo "<td>{$this->price}</td>";
        echo "<td>{$this->weight} Kg</td>";
        echo "</tr>";
    }
}
?>
