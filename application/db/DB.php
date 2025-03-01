<?php
class DB {
    function __construct()  {
        $host = 'localhost';
        $port = '3306';
        $name = 'cs2d'; // db name
        $user = 'root'; // user name
        $pass = ''; // user password
        try {
            $this->db = new PDO(
                'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $name,
                $user,
                $pass
            );
        } catch(Exception $e) { 
            die();
        }
    }

    function __destruct() {
        $this->db = null;
    }

    private function getArray($query) {
        $count = 0;
        $stmt = $this->db->query($query);
        $result = array();
         while($row = $stmt->fetchObject()) {
            $result[] = $row;
            $count++;
        }
        /*if($count >= 5)
        {
        $query = 'DELETE FROM `message` WHERE id='.$result[0][2];
        $this->db->query($query);
        $query = 'ALTER TABLE `message` AUTO_INCREMENT = 0';
        $this->db->query($query);
        }*/

        return $result;
    }

    public function getUser($login) {
        $query = 'SELECT * FROM users WHERE login="' . $login . '"';
        return $this->db->query($query)->fetchObject();
    }

    public function getUserByToken($token) {
        $query = 'SELECT * FROM users WHERE token="' . $token . '"';
        return $this->db->query($query)->fetchObject();
    }

    public function updateToken($id, $token) {
        $query = 'UPDATE users SET token="' . $token . '" WHERE id=' . $id;
        $this->db->query($query);
        return true;
    }

    public function sendMessage($userId, $name, $message){
        $query = "INSERT INTO `message`(`id`, `message`, `userName`) VALUES(" ."null".  ",'" .  $message .  "','" . $name."')";
        $this->db->query($query);
        return true;
    }

    public function getMessages() {
        $query = 'SELECT * FROM `message` ';
        return $this->getArray($query);
    }

    public function getChatHash() {
        $query = 'SELECT chat_hash FROM statuses';
        return $this->db->query($query)->fetchObject();
    }

    public function setChatHash($hash) {
        $query = 'UPDATE statuses SET chat_hash="' . $hash . '"';
        $this->db->query($query);
        return true;
    }

    public function getUsers() {
        $query = 'SELECT * FROM users';
        return $this->getArray($query);
    }

    public function registration($userName, $password, $login){
        $query = "INSERT INTO `users`(`id`, `login`, `password`, `token`, `name`) VALUES(" . "null" . ",'" . $login . "','" . $password . "'," . "null" . ",'" . $userName ."')";
        $this->db->query($query);
        return true;
        }
}
