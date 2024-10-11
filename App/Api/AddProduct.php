<?php

require '../Application/AdminService.php'; use \App\Application\AdminService;


function AddProduct() {
    if(!isset($_POST['name'])) {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "Поле название не должно быть пустым!"
        ]);
        exit;
    }
    
    if(!isset($_POST['price']) || !is_numeric($_POST['price'])) {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "Поле цена должно иметь только цифры и не должно быть пустым"
        ]);
        exit;
    }
    
    
    if (isset($_POST['name']) && isset($_POST['price'])) {
        try {
            $adminService = new AdminService();
            $adminService->addNewProduct($_POST['name'], $_POST['price'], $_POST['tariff']);
            echo json_encode([
                "status" => 'ok',
                "message" => "Продукт успешно добавлен!"
            ]);
            exit;
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => $th->getMessage()
            ]);
            exit;
        }
         
    }
    else {
        http_response_code(500);
        echo json_encode(
            [
            "status" => "error", 
            "message" => "Internal error"
            ]
            );
        exit;
    }
}


AddProduct();