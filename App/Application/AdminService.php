<?php
namespace App\Application;
require_once '../Domain/Users/UserEntity.php'; use App\Domain\Users\UserEntity;
require_once '../Infrastructure/sdbh.php'; use sdbh\sdbh;

class AdminService {

    /** @var UserEntity */
    public $user;

    public $sdbh;

    public function __construct()
    {
        $this->user = new UserEntity();
        $this->sdbh = new sdbh();
    }

    public function addNewProduct($name, $price, $tariff)
    {
        if (!$this->user->isAdmin) return;
        $query = "INSERT INTO `a25_products` (`name`, `price`, `tariff`) VALUES('$name', '$price', '$tariff')";
        $this->sdbh->make_query($query);
        $this->sdbh->commit();
        
    }
}