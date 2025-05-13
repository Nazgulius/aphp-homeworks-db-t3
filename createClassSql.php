<?php

include "./BaseRepository.php";

class Shop extends BaseRepository
{
  public function __construct(PDO $pdo)
  {
    parent::__construct($pdo, 'shop');
  }
}

class Client extends BaseRepository
{
  public function __construct(PDO $pdo)
  {
    parent::__construct($pdo, 'client');
  }
}

class Product extends BaseRepository
{
  public function __construct(PDO $pdo)
  {
    parent::__construct($pdo, 'product');
  }
}

class Order2 extends BaseRepository
{
  public function __construct(PDO $pdo)
  {
    parent::__construct($pdo, 'order2');
  }
}

class OrderProduct extends BaseRepository
{
  public function __construct(PDO $pdo)
  {
    parent::__construct($pdo, 'order_product');
  }
}
