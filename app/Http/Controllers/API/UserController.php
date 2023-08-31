<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function index()
    {

        $user = User::with([
            'task' => fn (Relation $query) => $query->select(Task::$VISIBLE)
        ]);
        // On récupère tous les utilisateurs
        $user = User::paginate(10);

        // On retourne les informations des utilisateurs en JSON
        return UserResource::collection($user);
    }

    public function store(UserStoreRequest $request)
    {
        // On crée un nouvel utilisateur
        $user = User::create([
            'first_name' => $request->first_name,
            "last_name" => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        // On récupère l'utilisateur connecté avec les tâches associées
        $user = Auth::user();

        // On retourne les informations de l'utilisateur avec les tâches associées
        return new UserResource($user);
    }

    public function update(UserStoreRequest $request, User $user)
    {
        // On modifie les informations de l'utilisateur
        $user->update([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" =>  Hash::make($request->password)
        ]);

        // On retourne la réponse JSON
        return response()->json();
    }

    public function destroy(User $user)
    {
        // On supprime l'utilisateur
        $user->delete();

        // On retourne la réponse JSON
        return response()->json();
    }


    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password do not match our records.',
                ], 401);
            }

            $token = JWTAuth::fromUser(Auth::user());

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $token
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to generate token.',
            ], 500);
        }
    }
}
