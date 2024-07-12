<?php
// Assuming you're using a PHP framework like Laravel, Symfony, or CodeIgniter
// Import the necessary classes and libraries

// Define the endpoint
Route::post('/api/login', 'AuthController@login');

// AuthController.php
class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Retrieve the authenticated user
        $user = auth()->user();

        // Return the user details and the authentication token
        return response()->json([
            'userId' => $user->id,
            'username' => $user->name,
            'email' => $user->email,
            'role' => $user->role, // Assuming the user model has a 'role' attribute
            'token' => $token,
        ]);
    }
}