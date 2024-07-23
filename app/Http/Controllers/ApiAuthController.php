<?php
//
//namespace App\Http\Controllers;
//
//use Exception;
//use Illuminate\Http\Request;
//use Kreait\Firebase\Factory;
//use Firebase\Auth\Token\Exception\InvalidToken;
//
//
//class ApiAuthController extends Controller
//{
//
//	public function login(Request $request)
//	{
//
//		try {
//			$http = new \GuzzleHttp\Client;
//
//			$response = $http->post('http://localhost/chatapp/public/oauth/token', [
//				'form_params' => [
//					'grant_type' => 'password',
//					'client_id' => '2',
//					'client_secret' => 'gZ8WOOjfKyvJMI2hZndgDaN0ApQFZU872PygTYtx',
//					'username' => $request->email,
//					'password' => $request->password,
//					'scope' => '*',
//				],
//			]);
//
//			return  $response->getBody();
//		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
//			if ($e->getCode() === 400) {
//                return response()->json(['ok'=>'0', 'error'=> 'Invalid Request. Please enter a username or a password.'], $e->getCode());
//            } else if ($e->getCode() === 401) {
//                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
//            }
//            return response()->json('Something went wrong on the server.', $e->getCode());
//		}
//	}
//
//	function logout(){
//		auth()->user()->tokens->each(function($token){
//			$token->delete();
//		});
//		return response()->json('logout successfully',200);
//	}
//}
