<?php
    $url = explode("/", $_SERVER['REQUEST_URI']);
    $error = array(
        "status" => "error",
        "message" => "Error al buscar la página"
    );

    if (count(array_filter($url)) == 2) {
        echo json_encode($error, true);
        return;
    } else {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            if (array_filter($url)[3] == 'products') { //En caso de esta en la sección de productos
                $products = new ProductController(); //Instauramos un objeto productos nuevo asi no tenemos que hacerlo en cada método
                if (!isset(array_filter($url)[4])) { //Si no existe mas url aparte de products es porque quieres todos los productos
                    if ($_SERVER['REQUEST_METHOD'] == "GET")
                        $products->index(); //Si estás usando el método Get, te da todos los productos
                } else if (is_numeric(array_filter($url)[4])) { //Si aparte de products en la url tienes un número en la siguiente parte, se mete en esta parte
                    if ($_SERVER['REQUEST_METHOD'] == "GET") {
                        $products->show(array_filter($url)[4]); //Con método Get y un número, te devuelve el producto
                    } else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
                        $data = array();
                        parse_str(file_get_contents('php://input'), $data);
                        $products->update(array_filter($url)[4], $data); //Con método Put y teniendo el array de datos, lo actualiza
                    }
                } else if (array_filter($url)[4] == 'register') { //Si aparte de products tienes un register y un array de datos los mete
                    $data = array('name' => $_POST['name'], 'description' => $_POST['description'], 'provider' => $_POST['provider'], 'price' => $_POST['price']);
                    $products->create($data);
                } else if (array_filter($url)[4] == 'delete' && isset(array_filter($url)[5]) && is_numeric(array_filter($url)[5]) && $_SERVER['REQUEST_METHOD'] == "DELETE") {
                    $products->delete(array_filter($url)[5]); //Si despues de products tienes delete y luego un numero, lo borra
                }
            } else if (array_filter($url)[3] == 'providers') { //En caso de estar en la sección de proveedores
                $provider = new ProviderController();
                if (array_filter($url)[4] == 'register') { //Si lo siguientes que tienes aparte de providers es register y el array, lo añadimos
                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        $data = array('name' => $_POST['name'], 'surnames' => $_POST['surnames'], 'email' => $_POST['email']);
                        $provider->register($data);
                    }
                } else if (array_filter($url)[4] == 'delete') { // Si queremos borrar providers
                    if (isset(array_filter($url)[5]) && is_numeric(array_filter($url)[5]) && $_SERVER['REQUEST_METHOD'] == "DELETE") {
                        $provider->destroy(array_filter($url)[5]);
                    }
                } else if (array_filter($url)[3] == 'auth') { //Para pruebas
                    if ($_SERVER['REQUEST_METHOD'] == "POST") {
                        $provider->auth();
                    }
                }
            }
        } else {
            echo json_encode($error, true);
            return;
        }
    }