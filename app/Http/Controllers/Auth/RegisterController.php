<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Setor;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $setores = Setor::all();
        return view('auth.register', ['setores'=> $setores]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome' => ['required', 'max:80'],
            'email' => ['required', 'email', 'max:80', 'unique:tb_usuario'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], 
        [
            'nome.required' => 'O campo nome é obrigatório!',
            'nome.max'=>'O campo nome deve conter no máximo 80 caracteres!',
            'email.required'=>'O campo email é obrigatório!',
            'email.email'=>'Informe um email válido!',
            'email.max'=>'O campo email deve conter no máximo 80 caracteres!',
            'email.unique'=>"O email informado já existe no sistema!",
            'password.required'=>'O campo senha é obrigatório!',
            'password.min'=>'O campo senha deve conter no mínimo 8 caracteres!',
            'password.confirmed'=>'As senhas informadas não conferem!'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'cpf' => $data['cpf'],
            'password' => Hash::make($data['password']),
            'tipo_usuario'=> $data['tipo_usuario'],
            'setor_id'=>$data['setor_id']
        ]);
    }
}
