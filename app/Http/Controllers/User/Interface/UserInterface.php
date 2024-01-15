<?php
namespace App\Http\Controllers\User\Interface;
interface userInterface{
   
    /** crea un nievo usuario
     * @param string $nombre
     * @param string $email
     * @param string $password
     * 
     * @return array
     */
    public function newUser(string $nombre,string $email,string $password):array;

    /** Actualiza un nuevo usuario
     * @param int $id
     * @param string $nombre
     * @param string $email
     * @param string $password
     * 
     * @return array
     */
    public function updateUser(int $id, string $nombre,string $email):array;

    /** Elimina un usuario
     * @param int $id
     * 
     * @return array
     */
    public function deleteUser(int $id):array;
}