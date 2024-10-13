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




if(!isset($data['phone-number'])) {
    echo "Необходимо ввести номер телефона!";
    exit;
}

if(!isset($data['product_id'])) {
    return "Продукт не найден!";
}

else {
    $check = $adminService->checkExistsProduct($data['product_id']);
    if(!$check) return "Продукт не найден!";
}


$product_id = $data['product_id'];

$phone_number = $data['phone_number'];

$product_name = $data['product_name'];

$tariff = $data['tariff'];

$start_rent = $data['start_rent'];

$end_rent = $data['end_rent'];

$price = $data['price'];

$services = $data['services'];




$services_text = '';

foreach ($services as $k => $v) {
    $services_text += "<p>$k : $v</p>";
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

return  mailer($from, $to, $subject, $message);

}

echo SendMail();