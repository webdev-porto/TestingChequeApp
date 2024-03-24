<?php
//$username = "u984891553_admin_2024", $password = "@u8PhfKJA"
class Database
{

    public function __construct($config, $username = "root", $password = "")
    {
        $dsn = "mysql:host={$config['host']};
              port={$config['port']};                   
              dbname={$config['dbname']};
              charset={$config['charset']}";

        try {
            $this->pdo = new PDO(
                $dsn,
                $username,
                $password,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

                ]
            );
            // echo "Working Live";
        } catch (PDOException $e) {
            echo "Connection Failed" . $e->getMessage();
        }


    }
}
