<?php

namespace App\Http\Controllers\Users\Interface;
interface LogoutInterface
{

    /** Se encarga de eliminar el token generado en el inicio de session
     * @return array
     */
    public function logout():array;
}