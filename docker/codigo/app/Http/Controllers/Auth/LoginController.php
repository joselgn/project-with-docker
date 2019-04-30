<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use http\Env\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User as Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }//constructor

    //Implementa a funçao de login
    public function login(Request $request){
        //Valida login de Usuario
        $usuarioModel = new Usuario();
        $userProfile = $usuarioModel->where([
            'email' =>$request->email
        ])->first();

        if(!empty($userProfile)){
            $cryptPassword=$usuarioModel->_criptoSenha($userProfile->salt,$request->password);

            //Validate authentication
             if (Auth::attempt(['email' => $request->email, 'password' => $cryptPassword,'ativo'=>1])){
                 return redirect($this->redirectTo);
             }else {
                 //return $this->sendFailedLoginResponse($request, 'auth.failed_status');
                 Session::flash('msg','Usu&aacute;rio e/ou senha inv&aacute;lido!');
                 return redirect()->route('login')->with('error',1);
             }
         }else{
            Session::flash('msg','Usu&aacute;rio e/ou senha inv&aacute;lido');
            return redirect()->route('login')->with('error',1);
         }//if / else !empty
    }//login

}//class
