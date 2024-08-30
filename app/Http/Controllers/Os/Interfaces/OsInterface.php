<?php

namespace App\Http\Controllers\Os\Interfaces;

interface OsInterface 
{
    /** Creacion de una nieva OS
     * @param int $empresa
     * @param string $descripcion
     * 
     * @return array
     */
    public function newOs(int $empresa,int $user,int $estado, string $descripcion): array;

    /** Actualizacion de la descripcion de la OS
     * @param int $id
     * @param string $descripcion
     * 
     * @return array
     */
    public function updateOs(int $id, int $user, int $estado, string $descripcion) : array;

    /** Eliminar OS
     * @param int $id
     * 
     * @return array
     */
    public function deleteOs(int $id) : array;
    
    /** Devuelve todas las os
     * @return array
     */
    public function indexOs(): array;

    /** devuelve os pendientes, os terminadas
     * @return array
     */
    public function getResumen(): array;
}
