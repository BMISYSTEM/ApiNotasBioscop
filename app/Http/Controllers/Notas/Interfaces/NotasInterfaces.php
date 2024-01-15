<?php

namespace App\Http\Controllers\Notas\interfaces;

interface NotasInterfaces
{
    /** creacion de nueva nota en la tabla de notas
     * @param string $text
     * @param string $data
     * 
     * @return array
     */
    public function NewNote(string $text,string $data): array;
    
    /** Consulta todas las notas de un usuario
     * @param string $dataMin
     * @param string $dataMax
     * 
     * @return array
     */
    public function index(string $dataMin):array;

    /** Actualiza una nota
     * @param Int $id
     * @param string $text
     * @param string $data
     * 
     * @return array
     */
    public function update(Int $id, string $text, string $data):array;

    /**
     * @param Int $id
     * 
     * @return array
     */
    public function delete(Int $id):array;
}