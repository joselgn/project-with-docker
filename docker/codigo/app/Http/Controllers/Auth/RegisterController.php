<?php

namespace App\Http\Controllers\Auth;

use App\Models\User as Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        return Validator::make($data, [
            //Rules
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ],
        [
            //Messages
            //input Name
            'name.required' => '- O campo <b>NOME</b> &eacute; de preenchimento obrigat&oacute;rio',
            'name.min' => '- O campo <b>NOME</b> deve possuir o M&Iacute;NIMO de 3 caracteres',
            'name.max' => '- O campo <b>NOME</b> n&atilde;o deve exceder o M&Aacute;XIMO de 50 caracteres',

            //Input Senha
            'password.required' => '- O campo <b>SENHA</b> &eacute; de preenchimento obrigat&oacute;rio',
            'password.min' => '- O campo <b>SENHA</b> deve possuir o M&Iacute;NIMO de 6 caracteres',
            'password.max' => '- O campo <b>SENHA</b> n&atilde;o deve exceder o M&Aacute;XIMO de 200 caracteres',//Input Senha
            'password.confirmed' => '- O campo <b>SENHA</b> deve possuir o mesmo valor do campo Confirmaçao de senha',//Input Senha

            //Input emai
            'email.required' => '- O campo <b>EMAIL</b> &eacute; de preenchimento obrigat&oacute;rio',
            'email.email' => '- O campo <b>EMAIL</b> n&atilde;o parece ser valido',
            'email.min' => '- O campo <b>EMAIL</b> deve possuir o M&Iacute;NIMO de 6 caracteres',
            'email.max' => '- O campo <b>EMAIL</b> n&atilde;o deve exceder o M&Aacute;XIMO de 200 caracteres',
            'email.unique' => '- Esse <b>EMAIL</b> j&aacute; est&aacute; cadastrado em nossa base, por favor, informe outro email',
        ]);
    }

    //Update the register function
    public function register(Request $request) {
        $this->validator($request->all())->validate();

        //instancia a model
        $usuarioModel = new Usuario();

        //Create new user
        $user =  $usuarioModel->saveNew($request->all());//Save new user data

        if(empty($user) && !$user) { // Failed to register user
           return redirect('/registro'); // Wherever you want to redirect
        }//if something wrong!!!

        //$this->guard()->login($user);

        // Success redirection - which will be attribute `$redirectTo`
        Session::flash('msg','Registro efetuado com sucesso');
        return redirect($this->redirectTo)->with('error',0);
    }//register function

}//class
