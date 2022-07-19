<?php
namespace Account;

class User
{

    private int $id;
    private string $name;
    private string $password;

    public function ___construct(string $name, string $password){

        $this->name = $name;
        $this->password = $password;
    }
    /**
     * permet d'inscrire un utilisateur
     * @param string
     * @param string
     * @return User
     */
    public static function register(string $name, string $password): User{

    }

    /**
     * permet de connecter un utilisateur et retourne son id
     * @param string
     * @param string
     * @return int
     */
    public static function login(string $name, string $password, $pdo): int{
        $req = "SELECT id FROM user WHERE username='$name' AND password='$password' ";
        $statement = $pdo->query($req);
        $result = $statement->fetch();
        return empty($result) ? intval(0) : intval($result["id"]) ;
    }

}




?>