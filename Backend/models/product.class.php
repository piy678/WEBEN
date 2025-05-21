<?php
class Product {
    //Variablen für die Produktklasse
    public $id, $name, $description, $rating, $price, $image;
//Konstruktor für die Produktklasse
    public function __construct($id, $name, $description, $rating, $price, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->rating = $rating;
        $this->price = $price;
        $this->image = $image;
    }
}
