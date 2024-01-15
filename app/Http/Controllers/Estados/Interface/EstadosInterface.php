<?php

namespace App\Http\Controllers\Estados\Interface;

interface EstadosInterface 
{
    /** Crea un nuevo estado
     * @param string $nombre
     * @param string $color
     * 
     * @return array
     */
    public function newEstado(string $nombre, string $color):array;
    /** Actualiza el nombre y el color del estado
     * @param int $id
     * @param string $nombre
     * @param string $color
     * 
     * @return array
     */
    public function updateEstado(int $id,string $nombre, string $color):array;
    /** Elimina el estado
     * @param int $id
     * 
     * @return array
     */
    public function deleteEstado(int $id):array;

    /** Consulta todas los estados
     * @return array
     */
    public function index():array;
}
