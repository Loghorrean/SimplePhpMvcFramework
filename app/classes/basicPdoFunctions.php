<?php
namespace App\Classes;
trait basicPdoFunctions {
    private function prepare(string $sql) : \PDOStatement {
        return $this->pdo->prepare($sql);
    }

    private function query(string $sql) : \PDOStatement {
        return $this->pdo->query($sql);
    }

    public function lastInsertId() : string {
        return $this->pdo->lastInsertId();
    }

    private function beginTransaction() : bool {
        return $this->pdo->beginTransaction();
    }

    private function commit() : bool {
        return $this->pdo->commit();
    }

    private function rollBack() : bool {
        return $this->pdo->rollBack();
    }

    /**
     * Returns the PDO param depending on the type pf the variable passes
     * @param string $value
     * @return string
     */
    private function getDataType(string $value) : string {
        switch(true) {
            case is_int($value) :
                return "\PDO::PARAM_INT";
            case is_bool($value) :
                return "\PDO::PARAM_BOOL";
            case is_null($value) :
                return "\PDO::PARAM_NULL";
            default :
                return "\PDO::PARAM_STR";
        }
    }

    /**
     * Returns the integer representation of the PDO parameter string passed
     * @param string $type
     * @return int
     */
    private function pdoTypeToInteger(string $type) : int {
        switch(true) {
            case $type == "\PDO::PARAM_INT" :
                return 1;
            case $type == "\PDO::PARAM_BOOL" :
                return 5;
            case $type == "\PDO::PARAM_NULL" :
                return 0;
            default :
                return 2;
        }
    }

    protected function run(string $sql, array $values = []) : \PDOStatement {
        try {
            if (!empty($values)) {
                $query = $this->prepare($sql);
                // $key is a mark for the prepare statement (like :id, :name and so on)
                // $v is what you want to insert into the database
                foreach ($values as $key => $v) {
                     $data_type = $this->getDataType($v);
                     $data_type = $this->pdoTypeToInteger($data_type);
                    $query->bindValue($key, $v, $data_type);
                }
                $query->execute();
                return $query;
            }
            else {
                return $this->query($sql);
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function getRow(string $sql, array $values = []) : array {
        return $this->run($sql, $values)->fetch(\PDO::FETCH_ASSOC);
    }

    public function getRows(string $sql, array $values = []) : array {
        return $this->run($sql, $values)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function sql(string $sql, array $values = []) : \PDOStatement {
        return $this->run($sql, $values);
    }
}