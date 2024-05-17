<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\API\ApiResponsetrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Log;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ApiResponsetrait;
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /*********************get all users*******/
    public function index()
    {
        /*****users+admin that is logins */
        // $users = User::all();
        // return response()->json($users);
        /*******users only 1***** */
        // $users = User::whereNot('id', Auth::user()->id)->get();
        // return response()->json($users);
        /*******users only 2***** */
        $users = User::where('is_admin', '!=', true)->get();
        // return response()->json($users);
        /********users only 3 */
        // $users = User::when(Auth::user()->is_admin, function ($query) {
        // $query->where('id', '!=', Auth::user()->id);
        // })->get();
        // return response()->json($users);
        /*************users only 4 */
        // $users = User::excludeAdmin()->get();
    //     $users = UserResource::collection($users);
        $response = $this->apiResponse($users, 'All Users Authenticated', 200);
        return $response;
    }
    /*==========================================*/
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:8|confirmed',
    //         'is_admin' => 'required|boolean',
    //     ]);

    //     $user = User::create([
    //         'name' => $validatedData['name'],
    //         'email' => $validatedData['email'],
    //         'password' => Hash::make($validatedData['password']),
    //         'is_admin' => $validatedData['is_admin'],
    //     ]);

    //     return response()->json($user, 201);
    // }
    /*****************admin delete users**************/
//     public function destroy($userId)
// {
//     $user = User::find($userId);

//     if (!$user) {
//         return $this->apiResponse(null, 'User not found', 404);
//     }

//     $user->delete();

//     return $this->apiResponse(null, 'User deleted successfully', 200);
// }
// public function update(Request $request, $userId)
// {
//     $user = User::find($userId);
//     if(!$user)
//     {
        
//     }
// }

    /**************show user by id************ */
    // public function show($userId)
    // {
    //     if (!Auth::user()->is_admin) {
    //         return $this->apiResponse(null, 'Unauthorized to view users', 403);
    //     }

    //     try {
    //         $user = User::findOrFail($userId);
    //         return $this->apiResponse($user, 'User found', 200);
    //     } catch (\Exception $e) {
    //         \Log::error('Error retrieving user: ' . $e->getMessage());
    //         return $this->apiResponse(null, 'Error retrieving user', 500);
    //     }
    // }
    /************* */
    public function addUser(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required',
            'password' => 'required|min:8',
        ]);

        // Create a new user
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'mobile_number' => $validatedData['mobile_number'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json(['message' => 'User added successfully', 'user' => $user]);
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function updateUser(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_number' => 'required',
            'password' => 'nullable|min:8',
        ]);

        $user = User::findOrFail($id);
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];

        if (!empty($validatedData['mobile_number'])) {
            $user->mobile_number = $validatedData['mobile_number'];
        }

        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();

        return response()->json('User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json('User deleted successfully');
    }

}
