<?php

namespace App\Http\Interfaces;

interface CreateUserInterface
{
    /** creacion de usuarion el la base de datos
     * @param string $nombre
     * @param string $email
     * @param string $password
     * 
     * @return void
     */
    public function createUsers(string $nombre, string $email, string $password): array;
}
