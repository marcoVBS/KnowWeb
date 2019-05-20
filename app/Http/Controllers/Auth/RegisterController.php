<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Auth\Events\Registered;
use App\Models\Sector\Setor;

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
            'cpf' => ['unique:tb_usuario'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], 
        [
            'nome.required' => 'O campo nome é obrigatório!',
            'nome.max'=>'O campo nome deve conter no máximo 80 caracteres!',
            'email.required'=>'O campo email é obrigatório!',
            'email.email'=>'Informe um email válido!',
            'email.max'=>'O campo email deve conter no máximo 80 caracteres!',
            'email.unique'=>"O email informado já existe no sistema!",
            'cpf.unique'=>"O CPF informado já existe no sistema!",
            'password.required'=>'O campo senha é obrigatório!',
            'password.min'=>'O campo senha deve conter no mínimo 8 caracteres!',
            'password.confirmed'=>'As senhas informadas não conferem!'
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        if($request->file('foto')){
            $extension = $request->file('foto')->getClientOriginalExtension();
            $name = $request->cpf.'.'.$extension;
            $path = '/KnowWeb/public/storage/usuarios/' . $name;

            if($request->hasFile('foto') && $request->file('foto')->isValid()){
                $request->file('foto')->storeAs('/usuarios/', $name);
                event(new Registered($user = $this->create($request->all(), $path)));
            }
        }else{
            event(new Registered($user = $this->create($request->all())));
        }

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data, $foto = null)
    {   

        return User::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'cpf' => $data['cpf'],
            'foto' => $foto,
            'password' => Hash::make($data['password']),
            'tipo_usuario'=> $data['tipo_usuario'],
            'setor_id'=>$data['setor_id']
        ]);
    }
}
