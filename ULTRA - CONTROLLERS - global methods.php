<?php
/**
 * Global Methods
 * > access method from any controller
 * > create Repository folder inside app folder & create new class
 * > use method in controller (single / multiple use)
 */


// Repository
<?php

namespace App\Repositories;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRefreshRepository
{
    public function refreshToken() {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);

        return $newToken;
    }

}


// Controller
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
...
use App\Repositories\AuthRefreshRepository;

class QuotesController extends Controller
{

    /**
     * Multiple Usess indide class - construct method
     */
    private $repository;

    public function __construct(AuthRefreshRepository $repository) {
        $this->repository = $repository;
    }

    public function newQuotes(Request $request) {
        $token = $this->repository->refreshToken();

        return response()->json([
            'token'     =>  $token,
        ], 200);

    }



    /**
     * Single Use inside Class
     */
    public function newQuotes(Request $request, AuthRefreshRepository $repository) {
        $token = $repository->refreshToken();

        return response()->json([
            'token'     =>  $token,
        ], 200);

    }

}