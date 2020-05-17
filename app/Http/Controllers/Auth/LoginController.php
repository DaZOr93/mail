<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    public function redirect()
    {
        $query = http_build_query([
            'client_id' => 14,
            'redirect_uri' => 'http://cu66460.tmweb.ru/auth/callback',
            'response_type' => 'code',
            'scope' => ''
        ]);

        return redirect('https://team1-group-project.azurewebsites.net/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $http = new Client();

        $response = $http->post('http://team1-group-project.azurewebsites.net/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => 14, //данные которые выдаст Богдан. вынести в конфиг
                'client_secret' => 'ECsqw5TAz7zf1T2STbQ7srU53iCTlkqdt3AAJnzB',//данные которые выдаст Богдан. вынести в конфиг
                'redirect_uri' => 'http://cu66460.tmweb.ru/auth/callback',
                'code' => $request->code,
            ],
        ]);

        $access = json_decode((string)$response->getBody());//данные с токеном. придет сам токен и время его жизни


        if (isset($access->access_token) && $access->access_token) {
            // you would like to store the access_token in the session though...
            $access_token = $access->access_token;

            // получение данных пользователя
            $ch = curl_init();
            $url = 'http://team1-group-project.azurewebsites.net/api/user';
            $header = array(
                'Authorization: Bearer ' . $access_token
            );

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($result, true);//данные о user пришедшие от Богдана


            //нужно сохранить пользователя на вашем преокте, если уже есть пользователь с таким email тогда обновить токен
            $dbuser = User::query()->where('email', $response['email'])->first();

            if (!$dbuser) {
                $user = User::firstOrCreate([
                    'email' => $response['email'],
                    'name' => $response['name'],
                    'surname' => $response['surname'],
                    'avatar_url' => $response['avatar_url'],
                    'password' => Hash::make('gfhjkm'),
                    'token' => $access->access_token
                ]);
                $Rres = Auth::login($user);

                return response()->redirectTo('/');
            }

            $dbuser->update(['token' => $access->access_token]);
            $Rres = Auth::login($dbuser);
        }

         return response()->redirectTo('/');
    }


    public function logout(Request $request)
    {

        $this->guard()->logout();
        Auth::logout();

        return response()->json('ok' , 200);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
