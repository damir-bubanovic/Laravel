<?php
/**
 * ULTRA - JWT - refresh token
 * >  https://github.com/tymondesigns/jwt-auth/wiki/Authentication
 */


//AuthController
public function token(){
    $token = JWTAuth::getToken();
    if(!$token){
        throw new BadRequestHtttpException('Token not provided');
    }
    try{
        $token = JWTAuth::refresh($token);
    }catch(TokenInvalidException $e){
        throw new AccessDeniedHttpException('The token is invalid');
    }
    return $this->response->withArray(['token'=>$token]);
}