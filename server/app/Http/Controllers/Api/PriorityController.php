<?php

namespace App\Http\Controllers\Api;

use App\Http\Interfaces\IPriority; //პრიორიტეტების ინტერფეისი

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PriorityAddRequest;
use App\Http\Requests\EditPriorityRequest;
use App\Models\Priority;

class PriorityController extends Controller implements IPriority
{
    /**
     * @param null
     * @method GET
     * @return array
     * 
     * @OA\Get(
     *     path="/api/priority/list",
     *     security={{"bearerAuth":{}}},
     *     tags={"პრიორიტეტების API"},
     *     summary="პრიორიტეტების წამოღების მარსუტი",
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
    public function Priority_List() {
        return Priority::all();
    }

    /**
     * @param int<id>
     * @method DELETE
     * @return json
     * 
     * @OA\Delete(
     *     path="/api/priority/delete/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"პრიორიტეტების API"},
     *     summary="პრიორიტეტების წაშლის მარსუტი",
     * 
     *     @OA\Response(
     *         description="პრიორიტეტეი წაიშალა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="პრიორიტეტი ვერ წაიშალა",
     *         response=422
     *     ),
     *     
     *     @OA\Parameter(
     *         name="id",
     *         description="პრიორიტეტის აიდი",
     *         required=true,
     *         in="path",
     *         
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     )
     * )
     */
    public function Priority_Delete(int $id) {
        try {
            $priority_delete = Priority::whereId($id)->forceDelete();

            return response()->json([
                "message" => "პრიორიტეტეი წაიშალა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "message" => "პრიორიტეტეი ვერ წაიშალა"
            ], 422);
        }
    }

    /**
     * პრიორიტეტის დამატების მეთოდი
     * @method POST
     * @param AddTaskRequest
     * @return json
     * 
     * @OA\Post(
     *     path="/api/priority/add",
     *     tags={"პრიორიტეტების API"},
     *     security={{"bearerAuth", {}}},
     *     summary="პრიორიტეტის დამატების მარსუტი",
     * 
     *     @OA\Response(
     *         description="პრიორიტეტი დაემატა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="პრიორიტეტი ვერ დაემატა",
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
    public function Priority_Add(PriorityAddRequest $request) {
        $validated = $request->validated();

        if($validated) {
            try {
                Priority::create([
                    "name" => $validated["name"]
                ]);

                return response()->json([
                    "message" => "პრიორიტეტი დაემატა"
                ], 200);

            }catch(Exception $e) {
                return response()->json([
                    "message" => "პრიორიტეტი ვერ დაემატა"
                ], 422);
            }
        }
    }

    /**
     * პრიორიტეტების დარედაქტირების მეთოდი
     * @method PUT
     * @param int $id, EditPriorityRequest $request
     * @return json
     * 
     * @OA\Put(
     *     path="/api/priority/edit/{id}",
     *     tags={"პრიორიტეტების API"},
     *     summary="პრიორიტეტის დარედაქტირების მარშუტი",
     * 
     *     @OA\Response(
     *         description="პრიორიტეტი დარედაქტირდა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="პრიორიტეტი ვერ დარედაქტირდა",
     *         response=422
     *     ),
     * 
     *     @OA\RequestBody(
     *         required = true,
     * 
     *         @OA\JsonContent(
     *             required = {"name"},
     * 
     *             @OA\Property(property="name", type="string", format="string")
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="id",
     *         description="priority id",
     *         in="path",
     *         required=true,
     * 
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     )
     * )
     */
    public function Edit_Priority(EditPriorityRequest $request, int $id) {
        $validated = $request->validated();

        if($validated) {
            try {
                Priority::whereId($id)->update([
                    "name" => $validated["name"]
                ]);

                return response()->json([
                    "message" => "პრიორიტეტი დარედაქტირდა"
                ], 200);
            }catch(Exception $e) {
                return response()->json([
                    "message" => "პრიორიტეტი ვერ დარედაქტირდა"
                ], 422);
            }
        }
    }
}
