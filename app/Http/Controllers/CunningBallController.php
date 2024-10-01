<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CunningUser;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CunningBallController extends Controller
{
    
    public function updatePlayerInfo(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'nullable|string',
            'email' => 'required|email',
            'coin' => 'nullable|numeric',
            'gem' => 'nullable|integer',
            'match' => 'nullable|integer',
            'win' => 'nullable|integer',
            'death' => 'nullable|integer',
        ]);

        // Retrieve the player by email
        $player = CunningUser::where('email', $validatedData['email'])->first();

        if (!$player) {
            return response()->json(['error' => 'Player not found'], 404);
        }

        // Update player's information with the request data
        $player->name = $validatedData['name'] ?? $player->name;
        $player->coin = $validatedData['coin'] ?? $player->coin;
        $player->gem = $validatedData['gem'] ?? $player->gem;
        $player->match = $validatedData['match'] ?? $player->match;
        $player->win = $validatedData['win'] ?? $player->win;
        $player->death = $validatedData['death'] ?? $player->death;
        // Update other fields similarly

        // Save the updated player information
        $player->save();

        return response()->json(['player' => $player, 'message' => 'Player info updated successfully']);
    }

    public function register(Request $request)
    {
        try {
        // Validate the incoming request data
        $attributes = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'photo' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'coin' => 'nullable|numeric',
            'gem' => 'nullable|integer',
            'match' => 'nullable|integer',
            'win' => 'nullable|integer',
            'death' => 'nullable|integer',
        ]);
        // Set default values for coin and gem if not present in the request
        $attributes['coin'] = $attributes['coin'] ?? 10000;
        $attributes['gem'] = $attributes['gem'] ?? 100;
        $attributes['match'] = $attributes['match'] ?? 0;
        $attributes['win'] = $attributes['win'] ?? 0;
        $attributes['death'] = $attributes['death'] ?? 0;

        $user = CunningUser::create($attributes);
        // If validation passes, proceed with user creation
        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
        ], 201); // 201 status for created resource
        } catch (ValidationException $e) {
            // Return the validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422); // 422 status for unprocessable entity
        }
    }
    
    public function login(Request $request)
    {
        try {
            // Validate the incoming request data
            $attributes = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Check if the 'remember me' option was selected
            $remember = $request->has('remember');

            $user = CunningUser::where('email', $attributes['email'])->first();

            if ($user && Hash::check($attributes['password'], $user->password)) {
                return response()->json([
                    'message' => 'Login successful!',
                    'user' => $user
                ], 200); // 200 status for successful login
            } else {
                // Return error if authentication fails
                return response()->json([
                    'message' => 'Invalid credentials. Please try again.',
                ], 401); // 401 status for unauthorized
            }
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422); // 422 status for unprocessable entity
        }
    }
}
