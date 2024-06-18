<?php
    $url = explode("/", $_SERVER['REQUEST_URI']);
    //print_r($url);
    $error = array(
        "status" => "error",
        "message" => "Error al buscar la página"
    );

    if (count(array_filter($url)) == 2) {
        echo json_encode($error, true);
        return;
    } else {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            if (array_filter($url)[3] == 'products') {
                $products = new ProductController();
                if (!isset(array_filter($url)[4])) {
                    if ($_SERVER['REQUEST_METHOD'] == "GET")
                        $products->index();
                } else if (is_numeric(array_filter($url)[4])) {
                    if ($_SERVER['REQUEST_METHOD'] == "GET") {
                        $products->show(array_filter($url)[4]);
                    } else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
                        $data = array();
                        parse_str(file_get_contents('php://input'), $data);
                        $products->update(array_filter($url)[4], $data);
                    }
                } else if (array_filter($url)[4] == 'register') {
                    $data = array('name' => $_POST['name'], 'description' => $_POST['description'], 'provider' => $_POST['provider'], 'price' => $_POST['price']);
                    $products->create($data);
                } else if (array_filter($url)[4] == 'delete' && isset(array_filter($url)[5]) && is_numeric(array_filter($url)[5]) && $_SERVER['REQUEST_METHOD'] == "DELETE") {
                    $products->delete(array_filter($url)[5]);
                }
            } else if (array_filter($url)[3] == 'register') {
                $provider = new ProviderController();
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $data = array('name' => $_POST['name'], 'surnames' => $_POST['surnames'], 'email' => $_POST['email']);
                    $provider->register($data);
                }
            } else if (array_filter($url)[3] == 'auth') { //Para pruebas
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $provider = new ProviderController();
                    $provider->auth();
                }
            }
        } else {
            echo json_encode($error, true);
            return;
        }
    }