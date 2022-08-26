<?php

namespace app;

use app\models\Product;
use PDO;

class Database
{
    # Database Manipulation
    public PDO $pdo;
    public static Database $db;

    public function __construct()
    {
        # connect to database
        $this->pdo = new PDO("mysql:host=localhost;port=3306;dbname=products_crud", "root", "");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    public function getProducts($search = "")
    {
        # search database
        if ($search) {
            $statement = $this->pdo->prepare("select * from products where title like :title order by create_date desc");
            $statement->bindValue("title", "%$search%");
        } else {
            $statement = $this->pdo->prepare("select * from products order by create_date desc");
        }

        # fetch from database
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $statement = $this->pdo->prepare("select * from products where id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct(Product $product)
    {
        $statement = $this->pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                    VALUES (:title, :image, :description, :price, :date)");
        $statement->bindValue(":title", $product->title);
        $statement->bindValue(":image", $product->imagePath);
        $statement->bindValue(":description", $product->description);
        $statement->bindValue(":price", $product->price);
        $statement->bindValue(":date", date("Y-m-d H:i:s"));
        $statement->execute();
    }

    public function updateProduct(Product $product)
    {
        $statement = $this->pdo->prepare("UPDATE products SET title = :title, image = :image, 
                    description = :description, price = :price where id =:id");
        $statement->bindValue(":title", $product->title);
        $statement->bindValue(":image", $product->imagePath);
        $statement->bindValue(":description", $product->description);
        $statement->bindValue(":price", $product->price);
        $statement->bindValue(":id", $product->id);
        $statement->execute();
    }

    public function deleteProduct($id)
    {
        $statement = $this->pdo->prepare("delete from products where id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();
    }
}