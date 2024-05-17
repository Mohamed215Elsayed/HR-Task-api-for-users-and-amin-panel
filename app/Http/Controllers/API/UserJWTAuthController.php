<?php


namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class UserJWTAuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use ApiResponsetrait;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /*=====================Register======================*/
    public function register(UserRequest $request)
    {
        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'mobile_number' => $request->input('mobile_number'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user = new UserResource($user);
        $response = $this->apiResponse($user, 'Successfully registered', 201);
        return $response;
    }
    /************************************************** */
    protected function createNewToken($token)
    {
        // $user = new UserResource($user);
        return response()->json([
            'token' => $token,
            // 'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            // 'user' => auth()->user()
            'user' => new UserResource(auth()->user())
        ]);
    }
    /*=====================login======================*/
    public function login(Request $request)
    {
        $credentials = $request->only('mobile_number', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->apiResponse(null, 'Invalid credentials', Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return $this->apiResponse(null, 'Failed to generate token', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $cookie = cookie('jwt', $token, 60 * 24);
        return $this->apiResponse(['token' => $this->createNewToken($token)], 'Successfully logged in', Response::HTTP_OK)->withCookie($cookie);
    }
    /*=================profile==========================*/
    public function profile()
    {
        // return response()->json(auth()->user());
        $user = auth()->user();
        return response()->json(new UserResource($user));
    }
    /*=====================logout======================*/
    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        auth()->logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    /**********************refresh****************** */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /*************************************************/
}
/************************** */
// public function register(UserRequest $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required|between:2,100',
    //         'email' => 'required|email|unique:users|max:50',
    //         'mobile_number' => 'required|unique:users,mobile_number|digits:11',
    //         'password' => 'required|string|min:6' //confirmed
    //     ]);
    //     $user = User::create(array_merge(
    //         $validator->validated(),
    //         ['password' => bcrypt($request->password)]
    //     ));
    //     return response()->json([
    //         'message' => 'Successfully registered',
    //         'user' => $user
    //     ], 201);
    //     // $response = $this->apiRespone($user, 'Successfully registered', 201);
    //     // return $response;
    // }
 //  public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'mobile_number' => 'required|mobile_number',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     if (! $token = auth()->attempt($validator->validated())) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }
    //     return $this->createNewToken($token);
    // }

        //     public function logout()
    // {
    //     auth()->logout();
    //     return response()->json(['message' => 'Successfully logged out']);
    // }
