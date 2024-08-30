<?php

namespace App\Http\Controllers\Project\Interfaces;

interface ProjectInterfaces {
    /** Crea un nuevo proyecto
     * @param string $nombre
     * @param int $horas
     * @param int $id_nombre
     * 
     * @return array
     */
    public function newProject( string $nombre, int $horas , int $id_cliente):array;

    /** Actualiza el nombre y la horas
     * @param int $id
     * @param string $nombre
     * @param int $horas
     * 
     * @return array
     */
    public function updateProject(int $id, string $nombre , int $horas):array;

    /** Elimina un projecto
     * @param int $id
     * 
     * @return array
     */
    public function deleteProject(int $id):array;

    /** consulta todos los projectos
     * @return array
     */
    public function indexProject():array;

    /** Consulta un projecto en particular
     * @param int $id
     * 
     * @return array
     */
    public function  findProject(int $id):array;
}