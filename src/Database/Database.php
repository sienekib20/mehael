<?php

namespace Sienekib\Mehael\Database;

use PDO;
use PDOException;

class Database
{
	// Store the table name
	private string $table = 'table';

	// Store the select fields
	private string $fields = '*';

	// Store the whres clauses
	private array $wheres = [];

	// Objeto pdo
	private PDO $connection;


	public function __construct(PDO $connection)
	{
		$this->connection = $connection;
	}

	public function table(string $name)
	{
		$this->table = $name;

		return $this;
	}

	public function raw(string $sql, array $bind = [])
	{
		try {
			$stmt = $this->connection->prepare($sql);
			$stmt->execute($bind);
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit;
		}
	}

	public function insert(array $data)
	{
		try {
			$data = is_array(array_values($data)[0]) ? $data : [$data];

			array_map(function ($data) {
				$columns = implode(', ', array_keys($data));
				$wildcards =  implode(', ', array_pad([], count($data), '?'));
				$sql = "INSERT INTO {$this->table}($columns) VALUES($wildcards)";

				$this->connection->beginTransaction();
				$stmt = $this->connection->prepare($sql);
				for ($i = 1; $i <= count($values = array_values($data)); $i++) {
					$stmt->bindValue($i, $values[$i - 1]);
				}
				$stmt->execute();
				$this->connection->commit();
				return $this->connection->lastInsertId();
			}, $data);
		} catch (PDOException $e) {
			$this->connection->rollBack();
			echo $e->getMessage();
			exit;
		}
	}

	public function update(array $data)
	{
		try {
			$data = is_array(array_values($data)[0]) ? $data : [$data];

			array_map(function ($data) {

				$columns = implode(' = ?, ', array_keys($data)) . " = ?";

				$sql = "UPDATE TABLE {$this->table} SET $columns ";
				if (empty($this->wheres)) {
					echo 'Sql update mal formado, falta a cláusula where';
					exit;
				}
				$sql .= " WHERE";
				foreach ($this->wheres as $index => $value) {
					if ($index > 0) {
						$sql .= " {$value['type']}";
					}
					$sql .= " $value[field] $value[operator] ?";
				}

				//$bind = array_column($this->wheres, 'value');

				foreach (array_values($data) as $value) {
					$bind[] = $value;
				}

				foreach (array_column($this->wheres, 'value') as $value) {
					$bind[] = $value;
				}


				$this->connection->beginTransaction();
				$stmt = $this->connection->prepare($sql);
				for ($i = 1; $i <= count($values = array_values($bind)); $i++) {
					$stmt->bindValue($i, $values[$i - 1]);
				}
				$stmt->execute();
				return $this->connection->commit();
			}, $data);
		} catch (PDOException $e) {
			$this->connection->rollBack();
			echo $e->getMessage();
			exit;
		}
	}

	public function delete()
	{
		try {
			$sql = "DELETE FROM {$this->table} ";

			if (empty($this->wheres)) {
				echo 'Sql update mal formado, falta a cláusula where';
				exit;
			}

			$sql .= " WHERE";
			foreach ($this->wheres as $index => $value) {
				if ($index > 0) {
					$sql .= " {$value['type']}";
				}
				$sql .= " $value[field] $value[operator] ?";
			}

			$bind = array_column($this->wheres, 'value');
			$stmt = $this->connection->prepare($sql);
			$stmt->execute($bind);

			return [];
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit;
		}
	}

	public function selet(string $fields)
	{
		$this->fields = $fields;

		return $this;
	}

	public function where(string $field, string $operator, mixed $value)
	{
		$this->wheres[] = [
			'type' => 'AND',
			'field' => $field,
			'operator' => $operator,
			'value' => $value
		];

		return $this;
	}

	public function orwhere(string $field, string $operator, mixed $value)
	{
		$this->wheres[] = [
			'type' => 'OR',
			'field' => $field,
			'operator' => $operator,
			'value' => $value
		];

		return $this;
	}

	public function get()
	{
		$query = "SELECT {$this->fields} FROM {$this->table}";
		if (!empty($this->wheres)) {
			$query .= " WHERE";
			foreach ($this->wheres as $index => $value) {
				if ($index > 0) {
					$query .= " {$value['type']}";
				}
				$query .= " $value[field] $value[operator] ?";
			}
		}
		$binds = array_column($this->wheres, 'value');


		try {

			$stmt = $this->connection->prepare($query);
			$stmt->execute($binds);
		} catch (PDOException $e) {
			echo $e->getMessage();
			exit;
		}

		return $stmt->fetchAll();
	}
}
