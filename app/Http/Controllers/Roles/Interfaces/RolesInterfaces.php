<?php
namespace App\Http\Controllers\Roles\Interfaces;

interface RolesInterfaces {

    /** Crea un nuevo rol
     * @param string $nombre
     * 
     * @return array
     */
    function newRol(string $nombre):array;

    /**Actualiza un rol
     * @param int $id
     * @param string $nombre
     * 
     * @return array
     */
    function updateRol(int $id,string $nombre):array;

    /** Elimina un rol
     * @param int $id
     * 
     * @return array
     */
    function deleteRol(int $id):array;

    /** Devuelve todos los roles
     * @return array
     */
    function indexRol():array;
}