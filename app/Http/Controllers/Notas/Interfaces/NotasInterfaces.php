<?php

namespace App\Http\Controllers\Notas\interfaces;
/**
 * notas interfaz, se utiliza en el momento que se genrar las notas y demas..
 */
interface NotasInterfaces
{
    /** creacion de nueva nota en la tabla de notas
     * @param string $text
     * @param string $data
     * 
     * @return array
     */
    public function NewNote(string $text, string $datai,string $dataf,string $horai,string $horaf,int $reunion, int $apuntamiento): array;
    
    /** Consulta todas las notas de un usuario
     * @param string $dataMin
     * @param string $dataMax
     * 
     * @return array
     */
    public function index(string $dataMin):array;
  
    /**
     * @param int $mes
     * 
     * @return array
     */
    public function indexGantt(int $mes):array;

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

    /** devuelve un resumen de datos de las os 
     * @return array
     */
    public function getResumen():array;
    /** Confirma la nota y coloca el comentario en la os asignada 
     * @param string $comentario
     * @param string $data
     * @param string $horai
     * @param string $horaf
     * @param int $os
     * 
     * @return array
     */
    public function confirmaNota(string $comentario,string $data,string $horai,string $horaf,int $os,int $id_nota, int $id_estado):array;

}