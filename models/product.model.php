<?php

    class ProductModel {
        public static function index() {
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM products ORDER BY id");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function show($id) {
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() === 1)
                return $stmt->fetch(PDO::FETCH_ASSOC);
            else
                return [
                    "status" => "error",
                    "message" => "Product does not exist."
                ];
        }

        public static function update($id, $data) {
            global $conn;
            $stmt = $conn->prepare('UPDATE products SET name = :name, description = :description, price = :price, provider = :provider WHERE id = :id');
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $data["name"], PDO::PARAM_STR);
            $stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
            $stmt->bindParam(":price", $data["price"], PDO::PARAM_INT);
            $stmt->bindParam(":provider", $data["provider"], PDO::PARAM_INT);
            if ($stmt->execute())
                return [
                    "status" => "success",
                    "message" => "Product updated successfully."
                ];
            else
                return [
                    "status" => "error",
                    "message" => "Failed to update product."
                ];
        }

        public static function create($data) {
            global $conn;
            $stmt = $conn->prepare('INSERT INTO products (name, description, provider, price) VALUES (:name, :description, :provider, :price)');
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':provider', $data['provider']);
            $stmt->bindParam(':price', $data['price']);
            if ($stmt->execute())
                return [
                    'status' => 'success',
                    'message' => 'Product created!',
                ];
            else
                return [
                    'status' => 'error',
                    'message' => 'Error creating product!',
                ];
        }

        public static function delete($id) {
            global $conn; global $timer;

            $stmt = $conn->prepare('DELETE FROM products WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return [
                    "status" => "success",
                    "message" => "Product deleted!",
                    "timer" => $timer
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => print_r($stmt->errorInfo(), true),
                    "timer" => $timer
                ];
            }
        }
    }