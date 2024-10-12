<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        // return $next($request);         //ambil data user yang login
        //                                 //fungsi user() diambil dari Usermodel.php
        // if($user->$hasRole($role)){     //cek apakah user punya role yang diinginkan

        //Praktiku 3 JS7
        $user_role = $request->user()->getRole(); //ambil data level_kode dari user yang login
        if(in_array($user_role, $roles)){ //cek apakah level_kode user ada didalam array roles
            return $next($request); //jika ada, maka lanjutkan request
        }
                // jika tidak punya role, maka ditampilkam error 403
                abort(403, 'Forbiddan. Kamu tidak punya akses ke halaman ini');
        }
}
