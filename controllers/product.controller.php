<?php
class ProductController {
    public function index() {
        $providerController = new ProviderController();
        if ($providerController->auth()) {
            $product = ProductModel::index();
            $products = array(
                "status" => 500,
                "countProducts" => count($product),
                "data" => $product
            );
            echo json_encode($products, true);
            return;
        }
    }

    public function show($id) {
        $providerController = new ProviderController();
        if ($providerController->auth()) {
            $product = ProductModel::show($id, 'id');
            echo json_encode($product, true);
            return;
        }
    }

    public function update($id, $data) {
        $providerController = new ProviderController();
        if ($providerController->auth()) {
            foreach ($data as $key => $field) {
                if ($field == '') {
                    $errorReturned = fieldError($key, 'empty');
                    echo json_encode($errorReturned, true);
                    return;
                }
            }
            $products = ProductModel::index();
            foreach ($products as $keyy => $product) {
                if ($product['name'] == $data['name']) {
                    $errorReturned = fieldError('name', 'repeated');
                    echo json_encode($errorReturned, true);
                    return;
                }
                if ($product['description'] == $data['description']) {
                    $errorReturned = fieldError('description', 'repeated');
                    echo json_encode($errorReturned, true);
                    return;
                }
            }
            $product = ProductModel::update($id, $data);
            echo json_encode($product, true);
            return;
        }
    }

    public function create($data) {
        $providerController = new ProviderController();
        if ($providerController->auth()) {
            //Primero hacemos las validaciones
            foreach ($data as $key => $field) { //Recorremos el array de los datos
                if ($field == '') { // Si hay algún campo vacío, salta el error
                    $errorReturned = fieldError($key, 'empty'); // Pasando $key en lugar de $field[$key]
                    echo json_encode($errorReturned, true);
                    return;
                }
            }
            $products = ProductModel::index(); //Si no hay campos vacíos pasamos la lista de productos para ver algun campo esta repetido
            foreach ($products as $keyy => $product) {
                if ($product['name'] == $data['name']) {
                    $errorReturned = fieldError('name', 'repeated');
                    echo json_encode($errorReturned, true);
                    return;
                }
                if ($product['description'] == $data['description']) {
                    $errorReturned = fieldError('description', 'repeated');
                    echo json_encode($errorReturned, true);
                    return;
                }
            }
            $create = ProductModel::create($data);
            echo json_encode($create, true);
            return;
        }
    }

    public function delete($id) {
        $providerController = new ProviderController();
        if ($providerController->auth()) {
            $product = ProductModel::delete($id);
            echo json_encode($product, true);
            return;
        }
    }
}