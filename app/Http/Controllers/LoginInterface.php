<?php
namespace App\Http\Controllers;

interface LoginInterface
{

    
    /** se encarga de dar el login 
     * @param mixed $request
     * devuelve un array con el bearer token
     * @return array
     */
    public function login($request): array;
    /**
     * devuelve la informacion del usuario logueado
     */
    public function index():array;

    public function userPermisos():array;
}