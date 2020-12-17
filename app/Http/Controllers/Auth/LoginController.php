<?php

namespace App\Http\Controllers\Auth;

use App\Enums\LineUrlEnum;
use App\Http\Controllers\Controller;
use App\Traits\LineServiceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    use LineServiceTrait;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect()
    {
        $params = [
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'state' => '12345abcde',
            'scope' => 'profile%20openid%20email',
            'redirect_uri' => $this->callbackUrl,
        ];
        return redirect(LineUrlEnum::LINE_AUTHORIZE_URL.$this->matchUrlWithparams($params));
    }

    /**
     * @param  Request  $request
     * @return array|mixed
     */
    public function callback(Request $request)
    {
        $datas = $this->setOption($request->code);
        $response = Http::asForm()->post(LineUrlEnum::LINE_TOKEN_URL, $datas)->json();
        return $this->profile($response);
    }

}
