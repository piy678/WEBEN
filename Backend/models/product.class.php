<?php
class Product {
    public $id, $name, $description, $rating, $price, $image;

    public function __construct($id, $name, $description, $rating, $price, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->rating = $rating;
        $this->price = $price;
        $this->image = $image;
    }
}
