<?php
namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends Controller
{
    
    public function index()
    {
        try {
            $user = User::all();
            return response()->json($user,200);
        }catch (QueryException $e) {
            return response()->json([
                'message'=>'An error occured',
                'error'=> $e->getmessage()
            ],500);
        }catch (\Exception $e) {
            return response()->json([
                'message'=>'An error occured',
                'error'=> $e->getmessage()
            ],500);
        }
    }

    
    public function show(string$id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user,200);
        }catch(ModelNotFoundException){
            return response()->json(
                [
                    "message"=>"User not found",
                ],404);
        }catch (QueryException $e) {
            return response()->json([
                'message'=>'Database  error',
                'error'=> $e->getmessage()
            ],500);
        }catch (Exception $e) {
            return response()->json([
                'message'=>'An error occured',
                'error'=> $e->getmessage()
            ],500);
        }
    }

    
    public function store(Request $request)
    {
        try {
            $user = new User();
            $user->id = Str:: uuid();
            $user->username = $request->input ('username');
            $user->email = $request->input ('email');
            $user->password = Hash::make($request->input ('password'));
            $user->phoneNumber = $request->input ('phoneNumber');
            $user->role = $request->input ('role');
            $user->save();
            $token = $user->createToken("auth_token",["*"],now()->addHour(2))->plainTextToken;
            $response = [
                "message"=>"user saved successfully",
                "access_token"=>$token,
                "token_type"=>"Barrer",
                "user_id"=>$user->id,
            ];
        
            return response()->json($response, 201);
           
     
        }catch (ValidationException $e) {
            $response = [
                "message"=>"Validation error",
                "error"=>$e->errors(),
        ];
            return response()->json($response,201);
        }catch (QueryException $e) {
            return response()->json([
                'message'=>'Database  error',
                'error'=> $e->getmessage()
            ],500);
        }catch (\Exception $e) {
            return response()->json([
                'message'=>'An error occured',
                'error'=> $e->getmessage()],500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->username = $request->input("username");
            $user->email = $request->input("email");
            $user->phoneNumber = $request->input("phoneNumber");
            $user->password = Hash::make($request->input('password'));
            $user->save();
            $response = [
                "message"=>"user updated successfully",
            ];
            return response()->json($response,201);
        }catch(ModelNotFoundException){
            return response()->json(
                [
                    "message"=>"User not found",
                ],404);
        }catch (QueryException $e) {
            return response()->json([
                'message'=>'Database  error',
                'error'=> $e->getmessage()
            ],500);
        }catch (Exception $e) {
            return response()->json([
                'message'=>'An error occured',
                'error'=> $e->getmessage()
            ],500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            $response = [
                "message"=>"user deleted successfully",
            ];
            return response()->json($response,201);
        }catch(ModelNotFoundException){
            return response()->json(
                [
                    "message"=>"User not found",
                ],404);
        }catch (QueryException $e) {
            return response()->json([
                'message'=>'Database  error',
                'error'=> $e->getmessage()
            ],500);
        }catch (Exception $e) {
            return response()->json([
                'message'=>'An error occured',
                'error'=> $e->getmessage()
            ],500);
        }
    }
}

