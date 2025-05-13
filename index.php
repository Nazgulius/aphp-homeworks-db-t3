<?php

include "./createClassSql.php";

try {
  $pdo = new PDO("mysql:host=localhost;dbname=testBase", 'root', '12345');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Создаем экземпляры репозиториев
  $shopRepo = new Shop($pdo);
  $clientRepo = new Client($pdo);
  $orderRepo = new Order2($pdo);
  $productRepo = new Product($pdo);
  $orderProductRepo = new OrderProduct($pdo);

  // Вставка новых записей, для работы нужно указывать новые значения name
  $shop = $shopRepo->insert(['name', 'address'], ['MyShop7', '123 Main St']);
  $client = $clientRepo->insert(['name', 'phone'], ['Ivan6', '+79991234567']);
  $product = $productRepo->insert(['name', 'price', 'count'], ['apple golden 2', 20, 100]);
  $order = $orderRepo->insert(['created_at', 'seller', 'buyer'], ['2025-05-10', 'Da', 'Thomas']);
  $orderProduct = $orderProductRepo->insert(['name', 'price', 'count', 'created_at', 'seller', 'buyer'],
    ['apple red', 30, 110, '2025-05-11', 'Streat', 'Thomas']);


  echo "--- После вставки ---\n";
  print_r($shop);
  print_r($client);
  print_r($order);
  print_r($product);
  print_r($orderProduct);

  // Обновление
  $shopUpdated1 = $shopRepo->update((int)$shop['id'], ['address' => '456 New St']);
  $shopUpdated2 = $productRepo->update((int)$product['id'], ['count' => '300']);
  echo "--- После обновления магазина ---\n";
  print_r($shopUpdated1);
  print_r($shopUpdated2);

  // Поиск
  $foundClient = $clientRepo->find((int)$client['id']);
  echo "--- Поиск клиента по id ---\n";
  print_r($foundClient);

  // Удаление
  $deleted = $clientRepo->delete((int)$client['id']);
  echo "Удален клиент? " . ($deleted ? "Да" : "Нет") . "\n";
} catch (Exception $e) {
  echo "Ошибка: " . $e->getMessage();
}
