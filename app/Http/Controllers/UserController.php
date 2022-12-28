<?php

namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth; 
    use App\models\User;
    use Validator;
    use Illuminate\Http\Request;
 
    class UserController extends Controller
    {
        public $successStatus = 200;


        public function index()  // displays all user with orders
        {
        $id=auth()->guard('user')->user()->id;    
        return view()->with(User::find($id)->with(['orders'])->get());
        }
 
        public function login(Request $request)  // authenticates the user
        {
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('nimisHair')-> accessToken; 
                $success['userId'] = $user->id;
                return response()->json(['success' => $success], $this-> successStatus); 
            } 
            else{ 
                return response()->json(['error'=>'Unauthorised'], 401); 
            } 
        }
 
        public function register(Request $request)  //create user account
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'c_password' => 'required|same:password',
            ]);
 
            if ($validator->fails()) {
                return redirect()->back()->withErrors();
            }
 
            $data = $request->only(['name', 'email', 'password']);
            $data['password'] = bcrypt($data['password']);
 
            $user = User::create($data);
            $user->is_admin = 0;
 
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('nimishair')->accessToken,
            ]);
        }
 
        public function show(User $user)  // fetch details of users
        {
            return response()->json($user);
        }
 
        public function showOrders(User $user)  // fetch the orders of the users
        {
            return response()->json($user->orders()->with(['product'])->get());
        }
 
    }
