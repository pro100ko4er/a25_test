<?php
require_once 'App/Domain/Users/UserEntity.php'; use App\Domain\Users\UserEntity;

$user = new UserEntity();
if (!$user->isAdmin) die('Доступ закрыт');
?>
<html>
<head>
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<h1>Админка</h1>
    <div class="container"> 
    <div class="container-form">
        <h3>Добавить продукт</h3>
        <div class="form">
        <div class="mb-3">
  <label for="name-form-input" class="form-label">Название</label>
  <input type="text" class="form-control" id="name-form-input" placeholder="Тарелочка 4345">
  <div class="error-field" id="error-field-name">

  </div>
</div>
<div class="mb-3">
  <label for="price-form-input" class="form-label">Цена</label>
  <input type="number" class="form-control" id="price-form-input" placeholder="1500">
  <div class="error-field" id="error-field-price">
    
    </div>
</div>
<div class="mb-3">
  <label for="tariff-form-input" class="form-label">Тариф</label>
  <input type="text" class="form-control" id="tariff-form-input" placeholder="a:4:{i:0;i:1000;i:10;i:900;i:15;i:800;i:30;i:700;}">
  <div class="error-field" id="error-field-tariff">
    
    </div>
</div>
<div class="btn btn-success">Сохранить</div>
<div class="result"></div>
<div class="lds-ring hidden"><div></div><div></div><div></div><div></div></div>
        </div>
    </div>
    </div>
</body>
<script src="assets/js/utils.js"></script>
<script src="assets/js/add-product.js"></script>
</html>