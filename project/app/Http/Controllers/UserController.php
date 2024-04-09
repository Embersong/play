<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    public function index(): JsonResponse
    {
        $users = User::with('lotteryGameMatches')->paginate(10);
        $success['users'] = $users;
        return $this->sendResponse($success, 'Users');
    }


    public function update(Request $request, $id): JsonResponse
    {

        $user = User::find($id);
        if (!$user) {
            return $this->sendError('User not found');
        }

        if ($user->id !== Auth::id()) {
            return $this->sendError('Unauthorized');
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:3',

        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];

        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return $this->sendResponse([], 'User updated.');
    }

    public function destroy($id): JsonResponse
    {

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->id !== Auth::id()) {
            return $this->sendError('Unauthorized');
        }

        $user->delete();

        return $this->sendResponse([], 'User deleted successfully');
    }
}
