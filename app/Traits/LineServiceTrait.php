<?php


namespace App\Traits;


use App\Enums\LineUrlEnum;
use Illuminate\Support\Facades\Http;

trait LineServiceTrait
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $clientId;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $clientSecret;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $callbackUrl;


    /**
     * LineServiceTrait constructor.
     */
    public function __construct()
    {
        $this->clientId = config('services.line.client_id');
        $this->clientSecret = config('services.line.client_secret');
        $this->callbackUrl = config('services.line.redirect');
    }

    /**
     * @param $token
     * @return array|mixed
     */
    public function profile($token)
    {
        $arrHeader = [
            'Authorization' => 'Bearer '.$token['access_token'],
        ];
        return Http::withHeaders($arrHeader)->get(LineUrlEnum::LINE_PROFILE_URL)->json();
    }

    /**
     * @param $code
     * @return array
     */
    public function setOption($code){
        $option = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->callbackUrl,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];
        return $option;
    }

    /**
     * @param  array  $params
     * @return string
     */
    private function matchUrlWithparams($params = [])
    {
        $redirect_uri = '&redirect_uri='.$params['redirect_uri'].'&scope='.$params['scope'];
        unset($params['redirect_uri'], $params['scope']);
        $urlParams = '?'.http_build_query($params).$redirect_uri;
        return $urlParams;
    }
}
