<?php


class Login
{
    private object $db;
    public array $errors = [];
    public $success = false;
    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function login($login, $password)
    {
        $sql = "SELECT * FROM sk_admin WHERE admin_login = :login";
        $query = $this->db->prepare($sql);
        $query->execute([
            'login' => $login
        ]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->success = true;
            } else {
                $this->errors[] = 'Mot de passe incorrect';
            }
        } else {
            $this->errors[] = 'Utilisateur incorrect';
        }
    }
}
