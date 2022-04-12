<?php

namespace App\Core\Database;

use PDO;
use PDOException;

abstract class BaseModel
{
    /**
     * Variable that contains PDO Object
     * 
     * @var \PDO $db
     */
    private $db;

    /**
     * Query buider
     * 
     * @var string $query
     */
    private $query;

    /**
     * Query Columns
     * 
     * @var array $columns
     */
    private $columns = [];

    /**
     * Query params
     * 
     * @var array $params
     */
    private $params = [];

    /**
     * PDO Statement
     * 
     * @var \PDOStatement
     */
    private $stmt;

    /**
     * Constructor method with PDO driver
     * that returns PDO Object
     */
    public function __construct()
    {
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
        try {
            $this->db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $this->db;
    }

    /**
     * Create table
     */
    protected function createTable(string $table, array $columns = []): self
    {
        $fields = '';
        $keys = array_keys($columns);
        $values = array_values($columns);
        for ($i = 0; $i < count($columns); $i++) {
            $fields .= "{$keys[$i]} {$values[$i]}, ";
        }
        $fields = rtrim($fields, ', ');
        $this->query .= "CREATE TABLE IF NOT EXISTS {$table} ({$fields})";
        return $this;
    }

    /**
     * Drop table
     */
    protected function dropTable(string $table): self
    {
        $this->query .= "DROP TABLE IF EXISTS {$table}";
        return $this;
    }

    /**
     * Add INSERT INTO statement to the query
     */
    protected function insert(string $table, array $data = []): self
    {
        $this->columns = implode(', ', array_keys($data));
        $this->params = array_values($data);

        $positionalParams = '';
        for ($i = 0; $i < count($data); $i++) {
            $positionalParams .= '?, ';
        }
        $positionalParams = rtrim($positionalParams, ', ');

        $this->query = "INSERT INTO {$table} ({$this->columns}) VALUES ({$positionalParams})";
        return $this;
    }

    /**
     * Add UPDATE statement to the query
     */
    protected function update(string $table, array $data = []): self
    {
        $this->columns = array_keys($data);
        $this->params = array_values($data);

        $setData = '';
        for ($i = 0; $i < count($data); $i++) {
            $setData .= "{$this->columns[$i]} = ?, ";
        }
        $setData = rtrim($setData, ', ');

        $this->query .= "UPDATE {$table} SET {$setData}";
        return $this;
    }

    /**
     * Add DELETE statement to the query
     */
    protected function delete(): self
    {
        $this->query .= "DELETE";
        return $this;
    }

    /**
     * Add SELECT statement to the query
     */
    protected function select(array $columns = ['*']): self
    {
        $columns = rtrim(implode(', ', $columns), ',');
        $this->query .= "SELECT {$columns}";
        return $this;
    }

    /**
     * Add FROM clause to the query
     */
    protected function from(array $tables = []): self
    {
        $tables = implode(', ', $tables);
        $this->query .= " FROM {$tables}";
        return $this;
    }

    /**
     * Add WHERE clause to the query
     */
    protected function where(string $key, mixed $value): self
    {
        $this->query .= " WHERE {$key} = ?";
        array_push($this->params, $value);
        return $this;
    }

    /**
     * Add AND clause to the query
     */
    protected function and(string $key, mixed $value): self
    {
        $this->query .= " AND {$key} = ?";
        array_push($this->params, $value);
        return $this;
    }

    /**
     * Add OR clause to the query
     */
    protected function or(string $key, mixed $value): self
    {
        $this->query .= " OR {$key} = ?";
        array_push($this->params, $value);
        return $this;
    }

    /**
     * Run the query
     */
    protected function run(): self
    {
        $this->stmt = $this->db->prepare($this->query);
        $this->stmt->execute($this->params);
        return $this;
    }

    /**
     * Execute the query
     */
    protected function exec(): bool
    {
        $this->stmt = $this->db->prepare($this->query);
        return $this->stmt->execute($this->params);
    }

    /**
     * Custom query
     */
    protected function query(string $query): self
    {
        $this->query .= $query;
        return $this;
    }

    /**
     * Fetch all data from given table
     */
    protected function all(string $table): array
    {
        $query = "SELECT * FROM {$table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Fetch many data
     */
    protected function getMany(): array
    {
        return $this->stmt->fetchAll();
    }

    /**
     * Fetch one data
     */
    protected function getOne(): array
    {
        return $this->stmt->fetch();
    }
}
