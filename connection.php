<?php

date_default_timezone_set('UTC');


class Connection {

    private $connection;
    public function __construct()
    {
        try {

            $this->connection = new PDO('sqlite:database.sqlite');

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->create();
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    public function create() {
        $this->connection->exec("CREATE TABLE IF NOT EXISTS addresses (
            id INTEGER PRIMARY KEY,
            url TEXT NULL,
            address TEXT NULL,
            office_phone VARCHAR(250) NULL,
            cell_phone VARCHAR(250) NULL,
            website VARCHAR(250) NULL,
            email VARCHAR(250) NULL, 
            )");
    }

    public function add($data) {
        $sql = 'INSERT INTO addresses (url,address,office_phone,cell_phone,email,website) VALUES (:url,:address,:office_phone,:cell_phone,:email,:website)';

        foreach ($data as $address) {
            $result = $data_sql = $this->connection->query('SELECT id FROM WHERE url='.$address['url']);
            if (count($result) >= 0) {
                continue;
            }
            $statement = $this->connection->prepare($sql);
            if ($address['name']) {
                $statement->bindParam(':url', $address['name']);
            }
            if ($address['address']) {
                $statement->bindParam(':address', $address['address']);
            }
            if ($address['office_phone']) {
                $statement->bindParam(':office_phone', $address['office_phone']);
            }
            if ($address['cell_phone']) {
                $statement->bindParam(':cell_phone', $address['cell_phone']);
            }
            if ($address['email']) {
                $statement->bindParam(':email', $address['email']);
            }
            if ($address['website']) {
                $statement->bindParam(':website', $address['website']);
            }
        }
    }
}