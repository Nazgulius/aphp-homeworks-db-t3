<?php
interface DatabaseWrapper
{
  public function insert(array $tableColumns, array $values): array;
  public function update(int $id, array $values): array;
  public function find(int $id): array;
  public function delete(int $id): bool;
}

class BaseRepository implements DatabaseWrapper
{
  protected $pdo;
  protected $table;

  public function __construct(PDO $pdo, string $table)
  {
    $this->pdo = $pdo;
    $this->table = $table;
  }

  public function insert(array $tableColumns, array $values): array
  {
    $columns = implode(", ", $tableColumns);
    $placeholders = implode(", ", array_fill(0, count($values), '?'));
    $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($values);
    $id = $this->pdo->lastInsertId();

    return $this->find((int)$id);
  }

  public function update(int $id, array $values): array
  {
    $setParts = [];
    $updateValues = [];
    foreach ($values as $column => $value) {
      $setParts[] = "{$column} = ?";
      $updateValues[] = $value;
    }
    $updateValues[] = $id;
    $sql = "UPDATE {$this->table} SET " . implode(", ", $setParts) . " WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($updateValues);
    return $this->find($id);
  }

  public function find(int $id): array
  {
    $sql = "SELECT * FROM {$this->table} WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM {$this->table} WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([$id]);
  }
}
