<?php
namespace App\Http\Controllers\Users\Interface;
interface userInterface{
   
   
    /** crea un nuevo usuario
     * @param string $nombre
     * @param string $apellido
     * @param string $email
     * @param string $password
     * @param int $id_rol
     * @param int $id_area
     * 
     * @return array
     */
    public function newUser(string $nombre,string $apellido,string $email,string $password,int $id_rol,int $id_area,string $foto,int $cedula,int $telefono,int $administrador):array;

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