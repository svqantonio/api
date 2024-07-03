<?php

    class ProductModel {
        public static function index() {
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM products ORDER BY id");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function show($data, $parameter) { //Arreglar esto
            global $conn;
            if ($parameter == 'provider') {
                $stmt = $conn->prepare('SELECT * FROM products WHERE provider = :provider');
                $stmt->bindParam(":provider", $data, PDO::PARAM_INT);
            } else if ($parameter == 'id') {
                $stmt = $conn->prepare('SELECT * FROM products WHERE ' . $parameter . ' = :data');
                $stmt->bindParam(":data", $data, PDO::PARAM_STR);
            }
            $stmt->execute();
            if ($stmt->rowCount() > 0)
                return $stmt->fetchAll(PDO::FETCH_ASSOC); //Si no le pones al fetch el ALL NO TE VA A DEVOLVER MAS QUE UNO
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
            global $conn;
            $data = ProductModel::show($id, 'id');
            $stmt = $conn->prepare('DELETE FROM products WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return [
                    "status" => "success",
                    "message" => "Product deleted!",
                    "product_deleted" => $data
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => print_r($stmt->errorInfo(), true),
                ];
            }
        }
    }