<?php

namespace App\Http\Controllers\Areas\Interface;

interface AreasInterfaces 
{
    /** Crea una nueva area
     * @param string $nombre
     * 
     * @return array
     */
    function newArea(string $nombre):array;

    /** Actualiza la area
     * @param int $id
     * @param string $nombre
     * 
     * @return array
     */
    function updateArea(int $id,string $nombre):array;

    /** Elimina el area
     * @param int $id
     * 
     * @return array
     */
    function deleteArea(int $id):array;

    /** Devuelve todas las areas
     * @return array
     */
    function indexArea():array;

}