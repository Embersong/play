<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * The request instance.
     *
     * @var Request
     */
    private Request $request;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Create a new token.
     *
     * @param User $user
     * @return string
     */
    protected function jwt(User $user): string
    {
        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(): JsonResponse
    {
        $this->validate($this->request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //$user = User::where('email', $this->request->input('email'))->firstOrFail();
        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            return $this->sendError('Unauthorised.', ['error' => 'Email does not exist'], 400);

        }

        if (Hash::check($this->request->input('password'), $user->password)) {
            $success['token'] = $this->jwt($user);
            $success['name'] = $user->first_name;

            return $this->sendResponse($success, 'User signed in');
        }
        return $this->sendError('Unauthorised.', ['error' => 'Email or password is wrong.'], 400);

    }


    public function register(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:3',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        $success['token'] = $this->jwt($user);
        return $this->sendResponse($success, 'User registered successfully');

    }
}
