<?php
namespace App;
require_once 'Infrastructure/sdbh.php';

use sdbh\sdbh;

class Calculate
{

    public function count_days($days_start_rent, $days_end_rent) {
        $d1 = strtotime($days_start_rent);
        $d2 = strtotime($days_end_rent);
        $diff = $d2-$d1;
        $diff = $diff/(60*60*24);
        return $diff;
    }


    public function calculate1()
    {
        $dbh = new sdbh();
        $days_start_rent = isset($_POST['days-start-rent']) ? $_POST['days-start-rent'] : 0;
        $days_end_rent = isset($_POST['days-end-rent']) ? $_POST['days-end-rent'] : 0;
        $days = $this->count_days($days_start_rent, $days_end_rent);
        if($days <= 0 || $days >= 31) {
            echo "Дата окончания не может быть раньше даты начала и количество дней аренды не может превышать 30!";
            return;
        }
        $product_id = isset($_POST['product']) ? $_POST['product'] : 0;
        $selected_services = isset($_POST['services']) ? $_POST['services'] : [];
        $product = $dbh->make_query("SELECT * FROM a25_products WHERE ID = $product_id");
        if ($product) {
            $product = $product[0];
            $price = $product['PRICE'];
            $tarif = $product['TARIFF'];
        } else {
            echo "Ошибка, товар не найден!";
            return;
        }

        if(!$tarif) {
            $total_price = $price * $days;
        }
        else {
        $tarifs = unserialize($tarif);
        if (is_array($tarifs)) {
            $product_price = $price;
            foreach ($tarifs as $day_count => $tarif_price) {
                if ($days >= $day_count) {
                    $product_price = $tarif_price;
                }
            }
            $total_price = $product_price * $days;
        }else{
            $total_price = $price * $days;
        }
    }

        $services_price = 0;
        foreach ($selected_services as $service) {
            $services_price += (float)$service * $days;
        }

        $total_price += $services_price;

        echo $total_price;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instance = new Calculate();
    $instance->calculate1();
}
