<?php 


require '../Infrastructure/mailer.php';
require '../Application/AdminService.php'; use \App\Application\AdminService;
 


function SendMail() {

$adminService = new AdminService();

$from = 'ai329390@gmail.com';
$to = 'ivanproger97@gmail.com';
$subject = "Новая заявка!";

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);




if(!isset($data['phone_number'])) {
    return "Необходимо ввести номер телефона!";
}

if(!isset($data['product_id'])) {
    return "Продукт не найден!";
}

else {
    $check = $adminService->checkExistsProduct($data['product_id']);
    if(!$check) return "Продукт не найден!";
}


$product = $adminService->get($data['product_id']);

$product_name = $product[0]['NAME'];

$tariff = $product[0]['TARIFF'];

$product_id = $data['product_id'];

$phone_number = $data['phone_number'];

$start_rent = $data['start_rent'];

$end_rent = $data['end_rent'];

$price = $data['price'];

$services = $data['selected_services'];




$services_text = '';

foreach ($services as $k => $v) {
    $services_text .= "<p>".$v['name'].": ".$v['price']."</p>";
}


$message = "
<h1>Новая заявка!</h1>
<div>
    <p>Номер телефона: $phone_number </p>
    <p>ID продукта: $product_id </p>
    <p>Название продукта: $product_name </p>
    <p>Тариф: $tariff </p>
    <p>Начало аренды: $start_rent </p>
    <p>Конец аренды: $end_rent </p>
    <p>Стоимость: $price </p>
    <div><h3>Сервисы:</h3> $services_text</div>
    
</div>
";


$send_mail = mailer($from, $to, $subject, $message);
if(is_bool($send_mail)) {
    if($send_mail) {
        return json_encode(["status" => 'ok', "message" => "Заявка успешно отправлена! Ожидайте обратной связи"]);
    }
    else {
        http_response_code(500);
        return json_encode(["status" => 'error', "message" => "Ошибка сервера! Попробуйте позже..."]);
    }
}
else {
    http_response_code(500);
    return json_encode(["status" => 'error', "message" => $send_mail]);
}

}

echo SendMail();