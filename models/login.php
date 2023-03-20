<?php


class Login
{
    private object $db;
    private $login;
    private $password;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
        $this->db = Database::connect();
    }


    /**
     * Fonction qui vérifie si les identifiants sont corrects
     * @param $login
     * @param $password
     * @return bool
     */

    public function checkCredentials()
    {
        $query = "SELECT * FROM sk_admin WHERE admin_login = ?";
        $query = $this->db->prepare($query);
        $query->execute([$this->login]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
