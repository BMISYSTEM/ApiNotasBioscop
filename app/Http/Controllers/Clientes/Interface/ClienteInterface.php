<?php
namespace App\Http\Controllers\Clientes\Interface;

interface ClienteInterface
{
    /** Crea una nueva empresa
     * @param string $nombre
     * 
     * @return array
     */
    public function newCliente(string $nombre):array;

    /** Actualiza el nombre de la empresa
     * @param int $id
     * @param string $nombre
     * 
     * @return array
     */
    public function updateCliente(int $id,string $nombre):array;

    /** Elimina una empresa
     * @param int $id
     * 
     * @return array
     */
    public function deleteCliente(int $id):array;

    /** Consulta todas las empresas
     * @return array
     */
    public function indexCliente():array;
}