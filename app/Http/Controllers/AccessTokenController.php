<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Passport\Http\Controllers\AccessTokenController as ATC;
use League\Flysystem\Exception;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;

class AccessTokenController extends ATC
{
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            //get username (default is :email)
            $username = $request->getParsedBody()['username'];

            //get user change to 'email' if you want
            $users = User::where('email', '=', $username)->first();

            //generate token
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array
            $data = json_decode($content, true);

            if (isset($data["error"]))
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);

            // add access token to user
            $user = collect();
            $user->put('expires_in', $data['expires_in']);
            $user->put('access_token', $data['access_token']);
            $user->put('refresh_token', $data['refresh_token']);
            // 使用者設備資料
            $user->put('Device', $users->device);
            return response()->json(array($user));
        } catch (ModelNotFoundException $e) { // email not found
            //  return error message
            return response(["message" => "User not found"], 500);
        } catch (OAuthServerException $e) { //password not correct..token not granted
            //  return error message
            return response(["message" => "The user credentials were incorrect.', 6, 'invalid_credentials"], 500);
        } catch (Exception $e) {
            // return error message
            return response(["message" => "Internal server error"], 500);
        }
    }
}
