<?php
require_once 'App/Infrastructure/sdbh.php'; use sdbh\sdbh;
$dbh = new sdbh();
?>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Оставить заявку</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Номер телефона</label>
  <input type="text" class="form-control" id="form-phone-number" placeholder="+ (7) (000) 000-00-00">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-send-request">Оставить</button>
      </div>
    </div>
  </div>
</div>

    <div class="row row-header">
        <div class="col-12" id="count">
            <img src="assets/img/logo.png" alt="logo" style="max-height:50px"/>
            <h1>Прокат Y</h1>
        </div>
    </div>

    <div class="row row-form">
        <div class="col-12">
            <form action="App/calculate.php" method="POST" id="form">

                <?php $products = $dbh->make_query('SELECT * FROM a25_products');
                if (is_array($products)) { ?>
                    <label class="form-label" for="product">Выберите продукт:</label>
                    <select class="form-select" name="product" id="product">
                        <?php foreach ($products as $product) {
                            $name = $product['NAME'];
                            $price = $product['PRICE'];
                            $tarif = $product['TARIFF'];
                            ?>
                            <option data-tarif-product="<?= $tarif ?>" data-name-product="<?= $name ?>" value="<?= $product['ID']; ?>"><?= $name; ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>

                <label for="customRange1" class="form-label" id="count">Начало аренды:</label>
                <input type="date" name="days-start-rent" class="form-control form-days-start-rent" id="customRange1">
                <label for="customRange2" class="form-label" id="count">Конец аренды:</label>
                <input type="date" name="days-end-rent" class="form-control form-days-end-rent" id="customRange2">
                
                <?php $services = unserialize($dbh->mselect_rows('a25_settings', ['set_key' => 'services'], 0, 1, 'id')[0]['set_value']);
                if (is_array($services)) {
                    ?>
                    <label for="customRange1" class="form-label">Дополнительно:</label>
                    <?php
                    $index = 0;
                    foreach ($services as $k => $s) {
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" data-name-service="<?= $k ?>" value="<?= $s; ?>" id="flexCheck<?= $index; ?>">
                            <label class="form-check-label" for="flexCheck<?= $index; ?>">
                                <?= $k ?>: <?= $s ?>
                            </label>
                        </div>
                    <?php $index++; } ?>
                <?php } ?>

                <button type="submit" class="btn btn-primary">Рассчитать</button>
            </form>

            <h5>Итоговая стоимость: <span id="total-price"></span></h5>
            <button type="button" class="btn btn-success btn-leave-request" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Оставить заявку
</button>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const leaveRequest = $('.btn-leave-request')
    $(document).ready(function() {
    const phone_number = $('#form-phone-number')
    phone_number.mask('+ (7) (000) 000-00-00')
    const product_name = $('.form-select')
    const product_id = $('.form-select')
    const tarif = $('.form-select').attr('data-tarif-product')
    const start_rent = $('.form-days-start-rent')
    const end_rent = $('.form-days-end-rent')
    const services = $('.form-check-input')
    const price = $('#total-price')
    const selected_services = []
    for(let i = 0; i < services.length; i++) {
        const service = $(services[i])
        if(service.attr('checked')) {
            selected_services.push({name: service.attr('data-name-service'), price: service.val()})
        }
    }

        $('.btn-send-request').click(e => {
            const data = {
                phone_number: phone_number.val(),
                product_name: product_name.attr('data-name-product'),
                product_id: product_id.val(),
                tarif: tarif.attr('data-tarif-product'),
                start_rent: start_rent.val(),
                end_rent: end_rent.val(),
                price: price.text(),
                selected_services
            }
            $.ajax({
                url: 'App/Api/SendMail.php',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(data),
                success: (data, textStatus, jqXHR) => {

                },
                error: (jqXHR, textStatus, errorThrown) => {
                    
                }
            })
        })

        $("#form").submit(function(event) {
            event.preventDefault();
            
            $.ajax({
                url: 'App/calculate.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $("#total-price").text(response);
                    leaveRequest.removeClass('hidden')
                },
                error: function() {
                    leaveRequest.addClass('hidden')
                    $("#total-price").text('Ошибка при расчете');
                }
            });
        });
    });
</script>
</body>
</html>