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

                    foreach($validated()["performers"] as $performer_id) {
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
}
