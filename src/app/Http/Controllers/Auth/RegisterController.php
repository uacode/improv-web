<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Orm\Invite;
use App\Rules\ReservedUsername;
use App\User;
use Carbon\Carbon;
use Clarkeash\Doorman\Facades\Doorman;
use Clarkeash\Doorman\Validation\DoormanRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {

        return view('auth.register', [
            'invitationCode' => $request->get('code'),
            'invite' => Invite::where('code', $request->get('code'))->first()
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'min:3', 'max:32', 'unique:users', new ReservedUsername],
            'email' => 'required|string|email|min:5|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed|pwned|different:name|different:username|different:email',
            'code' => ['required', new DoormanRule($data['email'])],
            'tos' => 'required|accepted'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Temporary - set e-mail as manually verified. For as long as we have invitation logic,
        // which already verifies it
        $user->email_verified_at = Carbon::now();
        $user->save();

        return $user;
    }


    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {

        $invite = Invite::where('code', $request->get('code'))->firstOrFail();
        Doorman::redeem($request->get('code'), $request->get('email'));
        Log::info('Redeemed invitation code', ['invitation_id' => $invite->id, 'invited_user_id' => $user->id]);

        // Create new web access token on signup
        $token = $user->createWebToken();
        $request->session()->put('apiToken', $token);

        return redirect($this->redirectPath());
    }
}
