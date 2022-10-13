<?php

namespace App\Http\Controllers\Api;

use App\Http\Interfaces\IUser; // ინტერფეისი მომხმარებელთა კლასისთვის

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PasswordChangeRequest;
use Hash;
use DB;
use Auth;
use App\Models\User;
use App\Helpers\CharTranslator;

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
     * // მომხმარებელთა ძებნის მეთოდი
     * @method GET
     * @param Request fullname
     * @return json
     * 
     * @OA\Post(
     *     path="/api/user/search",
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
     *     ),
     * 
     *     @OA\RequestBody(
     * 
     *         @OA\JsonContent (
     *             required = {"fullname"},
     * 
     *             @OA\Property(property="fullname", type="string", format="string", example="john doe"),
     *         )
     *     )
     * )
    */
    public function User_Search(Request $request) {
        @$translator = new CharTranslator();
        @$fullname = @$translator->english_to_georgian($request->fullname);

        return User::where("name", "like", "%" . $fullname . "%")->get();
    }

    /**
     * პაროლის ცვლილების მეთოდი
     * @param PasswordChangeRequest $request
     * @method PUT
     * @return json
     * 
     * @OA\Put(
     *     path="/api/user/password/change",
     *     tags={"მომხმარებლების API"},
     *     security={{"bearerAuth", {}}},
     *     summary="პაროლის ცვლილების მარშუტი",
     * 
     *     @OA\Response(
     *         description="პაროლი შეიცვალა",
     *         response=200
     *     ),
     *     
     *     @OA\Response(
     *         description="პაროლი ვერ შეიცვალა",
     *         response=422
     *     ),
     * 
     *     @OA\RequestBody(
     *         required = true,
     * 
     *         @OA\JsonContent(
     *             required = {"current_password", "new_password"},
     *             
     *             @OA\Property(property="current_password", type="string", format="string"),
     *             @OA\Property(property="new_password", type="string", format="string"),
     *         )
     *     )
     * )
     */
    public function Change_Password(PasswordChangeRequest $request) {
        $validated = $request->validated();
        $current_password = Auth::user()->password;

        if($validated) {
            if(Hash::check($validated["current_password"], $current_password)) {
                $user = Auth::user();
                $user->password = Hash::make($validated["new_password"]);
                $user->save();

                return response()->json([
                    "message" => "პაროლი შეიცვალა"
                ], 200);
            }else {
                return response()->json([
                    "message" => "პაროლი ვერ შეიცვალა"
                ], 422);
            }
        }
    }

    /** 
     * მომხმარებლის ინფოს წამოღების მეთოდი
     * @method GET
     * @return json
     * 
     * @OA\Post(
     *     path="/api/user/get/{id}",
     *     tags={"მომხმარებლების API"},
     *     security={{"bearerAuth", {}}},
     *     summary="მომხმარებლის ინფოს გამოტანის მარშუტი",
     * 
     *     @OA\Response(
     *         description="მომხმარებელი ჩაიტვირთა",
     *         response=200
     *     ),
     *     
     *     @OA\Response(
     *         description="მომხმარებელი ვერ ჩაიტვირთა",
     *         response=422
     *     )
     * )
    */
    public function User_Get(int $id) {
        return User::whereId($id)->first();
    }
}
