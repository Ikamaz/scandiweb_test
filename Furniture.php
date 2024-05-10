<?php

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length) {
        parent::__construct($sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function displayProduct() {
        echo "<tr>";
        echo "<td>{$this->sku}</td>";
        echo "<td>{$this->name}</td>";
        echo "<td>{$this->price}</td>";
        echo "<td>{$this->height}x{$this->width}x{$this->length}</td>";
        echo "</tr>";
    }
}
?>
