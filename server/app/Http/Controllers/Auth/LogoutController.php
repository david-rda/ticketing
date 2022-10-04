<?php

namespace App\Http\Controllers\Auth;

use App\Http\Interfaces\ILogout; // ინტერფეისი სისტემიდან გამოსვლის კლასისთვის

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LogoutController extends Controller implements ILogout
{
    /**
     * სისტემიდან გამოსვლის მეთოდი
     * @method POST
     * @param Request
     * @return json
     * 
     * @OA\Post(
     *     path="/api/logout",
     *     security={{"bearerAuth":{}}},
     *     tags={"სისტემიდან გამოსვლის API"},
     *     summary="სისტემიდან გამოსვლის მარშუტი",
     * 
     *     @OA\Response(
     *         description="Logged out!",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="Error!",
     *         response=422
     *     )
     * )
     */
    public function Logout(Request $request) {
        try {
            if(Auth::check()) {
                Auth::logout();

                $request->session()->invalidate();

                return response()->json([
                    "message" => "Logged out!"
                ], 200);
            }
        }catch(Exception $e) {
            return response()->json([
                "message" => "Error!"
            ], 422);
        }
    }
}
