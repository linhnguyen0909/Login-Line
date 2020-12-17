<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirect()
    {
        $url = 'https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=1655378791&redirect_uri=http://loginline.test/api/callback&state=12345abcde&scope=profile%20openid%20email';
        return redirect($url);
    }

    public function callback(Request $request)
    {
        $url = 'https://api.line.me/oauth2/v2.1/token';
        $code = $request->code;
        $data = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => 'http://loginline.test/api/callback',
            'client_id' => '1655378791',
            'client_secret' => '626df65a903548aa0a06b6b54a8ccda8',
        ];
        $response = Http::asForm()->post($url, $data)->json();
        $profile = $this->profile($response);
        dd($profile);
        return $profile;
    }

    public function profile($token)
    {
        $urlProfile = 'https://api.line.me/v2/profile';
        $arrHeader = [
            'Authorization' => 'Bearer '.$token['access_token'],
        ];
        return Http::withHeaders($arrHeader)->get($urlProfile)->json();
    }
}
