<?php

namespace toubilib\core\domain\entities;

class Auth{

    private string $id;
    private string $email;
    private string $password; // hashed password
    private int $role; // 0 = patient, 1 = praticien, 2 = admin

    public function __construct(string $id, string $email, string $password, int $role){
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getId(): string{
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }
}