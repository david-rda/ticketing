<?php

namespace App\Http\Controllers\Api;

use App\Http\Interfaces\IStatus; //სტატუსების ინტერფეისი

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StatusAddRequest;
use App\Models\Status;

class StatusController extends Controller
{
    /**
     * @param null
     * @method GET
     * @return array
     * 
     * @OA\Get(
     *     path="/api/status/list",
     *     security={{"bearerAuth":{}}},
     *     tags={"სტატუსების API"},
     *     summary="პრიორიტეტების წამოღების მარშუტი",
     * 
     *     @OA\Response(
     *         description="პრიორიტეტები წამოღებულია",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="პრიორიტეტები არ არსებობს",
     *         response=422
     *     )
     * )
     */
    public function Status_List() {
        return Status::all();
    }

    /**
     * @param int<id>
     * @method DELETE
     * @return json
     * 
     * @OA\Delete(
     *     path="/api/status/delete/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"სტატუსების API"},
     *     summary="სტატუსის წაშლის მარშუტი",
     * 
     *     @OA\Response(
     *         description="სტატუსი წაიშალა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="სტატუსი ვერ წაიშალა",
     *         response=422
     *     ),
     * 
     *     @OA\Parameter(
     *         name="id",
     *         description="სტატუსის აიდი",
     *         required=true,
     *         in="path",
     *         
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     )
     * )
     */
    public function Status_Delete(int $id) {
        try {
            $status_delete = Status::whereId($id)->forceDelete();

            return response()->json([
                "message" => "სტატუსი წაიშალა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "message" => "სტატუსი ვერ წაიშალა"
            ], 422);
        }
    }

    /**
     * სტატუსების დამატების მეთოდი
     * @method POST
     * @param AddTaskRequest
     * @return json
     * 
     * @OA\Post(
     *     path="/api/status/add",
     *     tags={"სტატუსების API"},
     *     summary="სტატუსების დამატების მარშუტი",
     * 
     *     @OA\Response(
     *         description="სტატუსი დაემატა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="სტატუსი ვერ დაემატა",
     *         response=422
     *     ),
     * 
     *     @OA\RequestBody(
     *         required = true,
     * 
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", format="string")
     *         )
     *     )
     * )
     */
    public function Status_Add(StatusAddRequest $request) {
        $validated = $request->validated();

        if($validated) {
            try {
                Status::create([
                    "name" => $validated["name"]
                ]);

                return response()->json([
                    "message" => "სტატუსი დაემატა"
                ], 200);

            }catch(Exception $e) {
                return response()->json([
                    "message" => "სტატუსი ვერ დაემატა"
                ], 422);
            }
        }
    }
}
