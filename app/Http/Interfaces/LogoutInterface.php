<?php

namespace App\Http\Interfaces;

use PhpParser\Node\Expr\Cast\Object_;

interface LogoutInterface
{

    /** Se encarga de eliminar el token generado en el inicio de session
     * @return array
     */
    public function logout():array;
}