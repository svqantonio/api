<?php
    class ProviderController{

        public function auth() { //Funcion que sirve para comprobar que estés usando autorizacion para usar las funciones de la api
            if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
                $provider_id = $_SERVER['PHP_AUTH_USER'];
                $secret_key = $_SERVER['PHP_AUTH_PW'];
                $providers = ProviderModel::index();
                foreach($providers as $key => $provider) {
                    if ($provider_id === $provider['provider_id'] && $secret_key === $provider['secret_key'])
                        return true;
                }
                return false;
            } else {
                $error = [
                    "status" => "error",
                    "message" => "Credentials not provided"
                ];
                echo json_encode($error, true);
            }
        }

        public function index() {
            $product = ProviderModel::index();
            echo json_encode($product);
            return;
        }

        public function register($data) {
            if (isset($data['email']) && !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $data['email'])) {
                $errorReturned = fieldError('email', 'notValid');
                echo json_encode($errorReturned);
                return;
            }
            foreach ($data as $key => $field) {
                if ($field == '') {
                    $errorReturned = fieldError($key, 'empty');
                    echo json_encode($errorReturned, true);
                    return;
                }
            }
            $providers = ProviderModel::index();
            foreach ($providers as $keyy => $provider) {
                if ($provider['email'] == $data['email']) {
                    $errorReturned = fieldError($keyy, 'repeated');
                    echo json_encode($errorReturned, true);
                    return;
                }
            }
            $provider_id = str_replace('$', 'c', crypt($data['name'].$data['surnames'].$data['email'],'$2a$07$afartwetsdAD52356FEDGsfhsd$'));
            $secret_key = str_replace('$', 'a', crypt($data['email'].$data['surnames'].$data['name'],'$2a$07$afartwetsdAD52356FEDGsfhsd$'));
            $data = array('name' => $data['name'], 'surnames' => $data['surnames'], 'email' => $data['email'], 'provider_id' => $provider_id, 'secret_key' => $secret_key);
            $provider = ProviderModel::create($data);
            echo json_encode($provider, true);
            return;
        }

        public function destroy($id) {
            $prov_products = ProductModel::show($id, 'provider');
            //print_r($prov_products);
            if (count($prov_products) > 0) {
                foreach ($prov_products as $key => $product) {
                    $destroy = ProductModel::delete($product['id']);
                    echo json_encode($destroy, true);
                }
            } else {
                $error = array(
                    "status" => "error",
                    "message" => "Provider without products"
                );
                echo json_encode($error, true);
                return;
            }
            $provider = ProviderModel::destroy($id);
            echo json_encode($provider, true);
            return;
        }
    }