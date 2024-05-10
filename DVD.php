<?php

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function displayProduct() {
        echo "<tr>";
        echo "<td>{$this->sku}</td>";
        echo "<td>{$this->name}</td>";
        echo "<td>{$this->price}</td>";
        echo "<td>{$this->size} MB</td>";
        echo "</tr>";
    }
}
?>
