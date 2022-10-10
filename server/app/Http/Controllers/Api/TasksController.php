<?php

namespace App\Http\Controllers\Api;

use App\Http\Interfaces\ITasks; // ინტერფეისი თასკების კლასისთვის

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddTaskRequest;
use DB;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\TaskHasPerformer;

class TasksController extends Controller implements ITasks
{
    /**
     * თასქის დამატების მეთოდი
     * @method POST
     * @param AddTaskRequest
     * @return json
     * 
     * @OA\Post(
     *     path="/api/task/add",
     *     tags={"თასქების API"},
     *     summary="თასქის დამატების მარსუტი",
     * 
     *     @OA\Response(
     *         description="თასქი დაემატა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="თასქი ვერ დაემატა",
     *         response=422
     *     ),
     * 
     *     @OA\RequestBody(
     *         required = true,
     * 
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", format="string"),
     *             @OA\Property(property="description", type="string", format="string"),
     *             @OA\Property(property="priority", type="number", format="number"),
     *             @OA\Property(property="end_date", type="datetime", format="date-time"),
     *         )
     *     )
     * )
     */
    public function Add_Task(AddTaskRequest $request) {
        try {
            if($request->validated()) {
                $validated = $request->validated();

                DB::transaction(function() use($request) {
                    $created = Task::create([
                        "title" => $validated["title"],
                        "description" => $validated["description"],
                        "author_user_id" => Auth::user()->id,
                        "priority_id" => $validated["priority"],
                        "end_date" => $validated["end_date"]
                    ]);

                    $created_id = $created->id;

                    foreach($validated["performers"] as $performer_id) {
                        TaskHasPerformer::insert([
                            "task_id" => $created_id,
                            "performer_id" => $performer_id,
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ]);
                    }
                });

                return response()->json([
                    "message" => "თასქი დამეტა"
                ], 200);
            }
        }catch(Exception $e) {
            return response()->json([
                "message" => "თასქი ვერ დამეტა"
            ], 422);
        }
    }

    /**
     * თასქის წაშლის მეთოდი
     * @param int<id>
     * @method DELETE
     * @return json
     * 
     * @OA\Delete(
     *     path="/api/task/delete/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"თასქების API"},
     *     summary="თასქის წაშლის მარშუტი",
     * 
     *     @OA\Response(
     *         description="თასქი წაიშალა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="თასქი ვერ წაიშალა",
     *         response=422
     *     ),
     * 
     *     @OA\Parameter(
     *         name="id",
     *         description="თასქის აიდი",
     *         required=true,
     *         in="path",
     *         
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     )
     * )
     */
    public function Task_Delete(int $id) {
        try {
            $delete_task = Task::whereId($id)->delete();

            return response()->json([
                "message" => "თასქი წაიშალა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "message" => "თასქი ვერ წაიშალა"
            ], 422);
        }
    }

    /**
     * @param int<id>
     * @method GET
     * @return json
     * 
     * @OA\Get(
     *     path="/api/task/by_status/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"თასქების API"},
     *     summary="თასქის წამოღების მარშუტი სტატუსის აიდის მიხედვით",
     * 
     *     @OA\Response(
     *         description="OK",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="Unprocessable content",
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
    public function Task_By_Status(int $status_id) {
        return Status::where("status_id", $status_id)->get();
    }

    /**
     * თასქის რედაქტირების მეთოდი
     * @param int<id>, Request
     * @method PUT
     * @return json
     * 
     * @OA\Put(
     *     path="/api/task/edit/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"თასქების API"},
     *     summary="თასქის რედაქტირების მარშუტი",
     * 
     *     @OA\Response(
     *         description="თასქი დარედაქტირდა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="თასქი ვერ დარედაქტირდა",
     *         response=422
     *     ),
     * 
     *     @OA\RequestBody(
     *         required = true,
     * 
     *         @OA\JsonContent(
     *             required = {"title", "description", "priority", "end_date"},
     * 
     *             @OA\Property(property="title", type="string", format="string"),
     *             @OA\Property(property="description", type="string", format="string"),
     *             @OA\Property(property="priority", type="number", format="number"),
     *             @OA\Property(property="end_date", type="datetime", format="date-time"),
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         name="id",
     *         description="თასქის აიდი",
     *         required=true,
     *         in="path",
     *         
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     )
     * )
     */
    public function Edit_Task(EditTaskRequest $request, int $id) {
        $validated = $request->validated();

        if($validated) {
            try {
                Task::whereId($id)->update([
                    "title" => $validated["title"],
                    "description" => $validated["description"],
                    "priority" => $validated["priority"],
                    "end_date" => $validated["end_date"]
                ]);

                return response()->json([
                    "message" => "თასქი დარედაქტირდა"
                ], 200);
            }catch(Exception $e) {
                return response()->json([
                    "message" => "თასქი ვერ დარედაქტირდა"
                ], 422);
            }
        }
    }
}
