<?php

namespace App\Http\Controllers\Api;

use App\Http\Interfaces\IUser; // ინტერფეისი მომხმარებელთა კლასისთვის

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use DB;
use App\Models\User;

class UserController extends Controller implements IUser
{
    /** 
     * მომხმარებელთა ატვირთვის მეთოდი
     * @param Request
     * @method POST
     * @return json
     * 
     * @OA\Post(
     *     path="/api/user/insert",
     *     tags={"მომხმარებლების API"},
     *     security={{"bearerAuth", {}}},
     *     summary="მომხმარებლების ატვირთვის მარშუტი",
     * 
     *     @OA\Response(
     *         description="მომხმარებლები აიტვირთა",
     *         response=200
     *     ),
     *     
     *     @OA\Response(
     *         description="მომხმარებლები ვერ აიტვირთა",
     *         response=422
     *     ),
     * 
     *     @OA\RequestBody(
     *         required = true,
     * 
     *         @OA\JsonContent (
     *             required = {"name", "email", "position", "role", "password"},
     * 
     *             @OA\Property(property="name", type="string", format="string", example="john doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@simple.com"),
     *             @OA\Property(property="position", type="string", format="string"),
     *             @OA\Property(property="role", type="number", format="number"),
     *             @OA\Property(property="password", type="string", format="string", example="****"),
     *         )
     *     )
     * )
    */
    public function Insert_Users(Request $request) {
        DB::transaction(function() use($request) {
            DB::statement("DELETE FROM users DBCC CHECKIDENT ('RDA_TASKS.dbo.users', RESEED, 0)"); // მომხმარებელთა ცხრილის გასუფთავება
            
            // მომხმარებელთა ატვირთვა ციკლის საშუალებით
            foreach($request->all() as $data) {
                User::insert([
                    "name" => $data['displayName'],
                    "email" => strtolower($data['emailAddress']),
                    "position" => $data['positionNameGeo'],
                    "role" => 1,
                    "password" => Hash::make(1234)
                ]);
            }
        });

        try {
            DB::commit(); // ტრანზაქციის გაშვება

            return response()->json([
                "message" => "ატვირთვა განხორციელდა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "message" => "თანამშრომლები ვერ აიტვირთა"
            ], 422);
        }
    }

    /** 
     * მომხმარებელთა სიის გამოტანის მეტოდი
     * @param Request
     * @method GET
     * @return json
     * 
     * @OA\Post(
     *     path="/api/user/list",
     *     tags={"მომხმარებლების API"},
     *     security={{"bearerAuth", {}}},
     *     summary="მომხმარებელთა სიის გამოტანის მარშუტი",
     * 
     *     @OA\Response(
     *         description="სია ჩაიტვირთა",
     *         response=200
     *     ),
     *     
     *     @OA\Response(
     *         description="სია ვერ ჩაიტვირთა",
     *         response=422
     *     )
     * )
    */
    public function User_List() {
        return User::where("role", 2)->get();
    }
}
