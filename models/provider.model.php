<?php

    class ProviderModel {

        public static function index() { //Funcion para mostrar todos los providers
            global $conn;
            $stmt = $conn->prepare('SELECT * FROM providers');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function destroy($id) {
            global $conn;
            $stmt = $conn->prepare('DELETE FROM providers WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute())
                return [
                    "status" => "success",
                    "message" => "Provider deleted successfully"
                ];
            else
                return [
                    "status" => "error",
                    "message" => print_r($stmt->errorInfo(), true)
                ];
        }

        public static function create($data) {
            global $conn;
            $stmt = $conn->prepare('INSERT INTO providers (name, surnames, email, provider_id, secret_key) VALUES (:name, :surnames, :email, :provider_id, :secret_key)');
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':surnames', $data['surnames'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':provider_id', $data['provider_id'], PDO::PARAM_STR);
            $stmt->bindParam(':secret_key', $data['secret_key'], PDO::PARAM_STR);
            if ($stmt->execute())
                return [
                    "status" => "success",
                    "message" => "Provider has been created"
                ];
            else
                return [
                    "status" => "error",
                    "message" => "Failed to create provider"
                ];
        }
    }