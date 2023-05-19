<?php

class User extends Model
{

    public function __construct()
    {
        parent::__construct("users");
    }

    public function getByCredentials(string $username, string $password): array
    {
        return [];
    }

    public function getByToken(string $token): array
    {
        return [];
    }
}
