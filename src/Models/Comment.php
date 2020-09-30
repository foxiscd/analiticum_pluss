<?php

namespace src\models;

use PDO;

class Comment
{
    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var string
     */
    private $table_name;

//    Инициализируем подключение к базе данных и название таблицы
    public function __construct()
    {
        extract(require __DIR__ . '/../../db.php');
        try {
            $pdo = new PDO("$driver:host=$host;dbname=$db_name;charset=$charset", $db_user, $db_pass);
            $this->pdo = $pdo;
            $this->pdo->exec('SET NAMES UTF8');
            $this->table_name = '`comment`';
        } catch (\PDOException $e) {
            print "Ошибка подключения: " . $e->getMessage();
            die();
        }

    }

    /**
     * @param string $text
     * @return bool
     */
    public function createComment(string $text): bool
    {
        $sql = "INSERT INTO {$this->table_name}(`text`) VALUES (:text)";

        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute([':text' => $text]);

        return $result;
    }

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        $sql = "SELECT * FROM {$this->table_name};";

        $sth = $this->pdo->query($sql);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @param string $text
     * @param int $parent_id
     * @return bool
     */
    public function createCommentWithParent(string $text, int $parent_id): bool
    {
        $sql = "INSERT INTO {$this->table_name}(`text` , `parent_id`) VALUES (:text , :parent_id)";

        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute([':parent_id' => $parent_id, ':text' => $text]);

        return $result;
    }

    /**
     * @param int $parent_id
     * @return array
     */
    public function getByParentId(int $parent_id): array
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE parent_id = :parent_id;";

        $sth = $this->pdo->prepare($sql);
        $sth->execute([':parent_id' => $parent_id]);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}