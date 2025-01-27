<?php

namespace App\Model;

use App\Model\Database;
use PDO;

class User
{
    public function __construct(private ?int $id = null, private ?string $login = null, private ?string $fullname = null, private ?string $email = null, private ?string $password = null, private ?array $role = null)
    {
        $this->id = $id;
        $this->login = $login;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of login
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */
    public function setLogin($login): User
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of fullname
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * Set the value of fullname
     *
     * @return  self
     */
    public function setFullname($fullname): User
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole(): ?array
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role): User
    {
        $this->role = $role;

        return $this;
    }

    public function findOneById(int $id): bool|User
    {
        $query = "SELECT * FROM user WHERE id = :id";
        $statement = Database::dbConnexion()->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User(
                $result['id'],
                $result['login'],
                $result['fullname'],
                $result['email'],
                $result['password'],
                $result['role'],
            );
            return $user;
        }
        return false;
    }

    public function findOneByEmail(string $email): bool|User
    {
        $query = "SELECT * FROM user WHERE email = :email";
        $statement = Database::dbConnexion()->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User(
                $result['id'],
                $result['login'],
                $result['fullname'],
                $result['email'],
                $result['password'],
                [$result['role']],
            );
            return $user;
        }
        return false;
    }

    public function findAll(): array|bool
    {
        $query = "SELECT * FROM user";
        $statement = Database::dbConnexion()->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $users = [];

        foreach ($results as $result) {

            $user = new User(
                $result['id'],
                $result['login'],
                $result['fullname'],
                $result['email'],
                $result['password'],
                [$result['role']],
            );
            $users[] = $user;
        }
        if ($users) {
            return $users;
        }
        return false;
    }

    public function create(): User|bool
    {
        $dbConn = Database::dbConnexion();

        $query = "INSERT INTO user (login, fullname, email, password, role) VALUES (:login, :fullname, :email, :password, :role) ";
        $statement = $dbConn->prepare($query);

        $newUser = $statement->execute([
            ':login' => $this->getLogin(),
            ':fullname' => $this->getfullname(),
            ':email' => $this->getEmail(),
            ':password' => $this->getPassword(),
            ':role' => json_encode(['role' => 'ROLE_USER']),
        ]);

        if ($newUser) {
            $lastInsertId = $dbConn->lastInsertId();
            $this->setId($lastInsertId);
            return $this;
        } else {
            return false;
        }
    }

    public function update($id, $login, $fullname, $password): User|bool
    {

        var_dump($_SESSION);
        var_dump($this->getLogin());
        var_dump($this->getId());

        $query = "UPDATE user SET 
        login = :login, fullname = :fullname, password = :password 
        WHERE id = :id";

        $statement = Database::dbConnexion()->prepare($query);

        $updatedUser = $statement->execute([
            ':id' => $id,
            ':login' => $login,
            ':fullname' => $fullname,
            ':password' => $password
        ]);

        if ($updatedUser) {
            return $this;
        }
        return false;
    }
}
