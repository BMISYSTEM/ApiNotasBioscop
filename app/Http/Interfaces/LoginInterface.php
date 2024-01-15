<?php
namespace App\Http\Interfaces;

interface LoginInterface
{

    
    /** se encarga de dar el login 
     * @param mixed $request
     * devuelve un array con el bearer token
     * @return array
     */
    public function login($request): array;
}