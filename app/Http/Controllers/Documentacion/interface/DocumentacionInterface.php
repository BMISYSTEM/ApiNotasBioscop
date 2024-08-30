<?php


interface DocumentacionInterface{

    public function createModulo($nombre,$sistema);

    public function findModulo($id_modulo);

    public function updateModulo($nombre,$sistema,$id_modulo);

    public function deleteModulo($id_modulo);

    public function addDocumentacion(   $posicion,
                                        $tipo,
                                        $title,
                                        $image,
                                        $text,
                                        $id_modulo);
    public function updateDocumentacion(    $posicion,
                                            $tipo,
                                            $title,
                                            $image,
                                            $text,
                                            $id_modulo,
                                            $id_documentacion);
    public function deleteDocumentacion($id_documentacion);
}