<?php

namespace App\Http\Controllers\Auth;

use App\Http\Interfaces\IAuth; // ინტერფეისი ავტორიზაციის კლასისთვის

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller implements IAuth
{
    /**
     * მომხმარებლის მიერ შეყვანილი მონაცემების ვალიდაცია ავტორიზაციის დროს
     * @method POST
     * @param Request
     * @return true||false
     */
    public function ValidateData(Request $request) {
        try {
            $this->validate($request, [
                "email" => "required|email",
                "password" => "required"
            ]);

            return true;
        }catch(Exception $e) {
            return false;
        }
    }

    /**
     * ავტორიზაციის მეთოდი
     * @method Login
     * @param Request
     * @return json authorization data with status code
     * 
     * @OA\Post(
     *     path="/api/login",
     *     tags={"ავტორიზაციის API"},
     *     security={{ "bearerAuth" : {} }},
     *     summary="ავტორიზაციის მარშუტი",
     * 
     *     @OA\Response(
     *         description="ავტორიზაცია წარმატებით დასრულდა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="ავტორიზაცია ვერ განხორციელდა",
     *         response=422
     *     ),
     *     
     *     @OA\RequestBody(
     *         required = true,
     * 
     *         @OA\JsonContent(
     *             required = {"email", "password"},
     * 
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="string")
     *         )
     *     )
     * )
     */
    public function Login(Request $request) {
        $validated = $this->ValidateData($request);

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if($validated) {
            if(Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $token = Auth::user()->createToken("ACCESS_TOKEN")->accessToken;


                return response()->json([
                    "token" => $token,
                    "logged_in" => true
                ], 200);
            }else {
                return response()->json([
                    "logged_in" => false
                ], 422);
            }
        }
    }
}
