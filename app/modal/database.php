<?php

class Database
{

    private $pdo;
    private $host = 'localhost';
    private $dbname = 'routing';
    private $user = 'root';
    private $password = 'root';

    function _connect(){
        // init connection to database
        // Connect to a database using PDO
        try {
            $this->pdo = new PDO(
                "mysql:host=$this->host;port=3306;dbname=$this->dbname",
                $this->user,
                $this->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $th) {
            echo "Connection failed: " . $th->getMessage();
        } catch (Error $e){
            throw new Exception("Error: " . $e->getMessage());
        }
    }    

    /**
     * Execute a prepared query (against SQL injection)
     * Manage query SCRUD : SELECT UPDATE INSERT DELETE
     * 
     * @param statement prepared query SQL
     * @param attributes params of SQL query
     * @param fetch_mode fetch mode of SQL query (by default FETCH_CLASS)
     * @return req result of query SQL : 
     *      SELECT : return data
     *      INSERT : return lastId (need auto-increment and primary key! else 0)
     *      UPDATE, DELETE : return how many
     * 
     */
    public function prepare($statement, $attributes = array(), $fetch_mode = PDO::FETCH_CLASS)
    {
        if (!isset($this->pdo)){
            $this->_connect();
        }
        $query = explode(" ", $statement);
        $opt = strtolower(array_shift($query));
        
        $req = $this->pdo->prepare($statement);
        $req->bindValue('limit', (int) 10, PDO::PARAM_INT);

        try {
            $req->execute($attributes);
        } catch (\Throwable $th) {
            return $th;
        }

        // Types de requetes : SELECT & SHOW
        if ($opt == "select" || $opt == "show") {
            if ($req->rowCount() > 0) {
                $data = $req->fetchAll($fetch_mode);
                return $data;
            }
            // Types de requetes : INSERT & UPDATE & DELETE
        } elseif ($opt == "insert" || $opt == "update" || $opt == "delete") {
            if ($opt == "insert") return $this->pdo->lastInsertId();
            else return $req->rowCount();
        }
    }
}
