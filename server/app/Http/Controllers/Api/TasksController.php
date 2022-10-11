<?php

namespace App\Http\Controllers\Api;

use App\Http\Interfaces\ITasks; // ინტერფეისი თასკების კლასისთვის

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\EditTaskRequest;
use DB;
use Auth;
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
     *     security={{"bearerAuth", {}}},
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
            $validated = $request->validated();
            
            if($validated) {
                DB::transaction(function() use($validated, $request) {
                    $create_task = Task::create([
                        "title" => $validated["title"],
                        "description" => $validated["description"],
                        "author_user_id" => Auth::user()->id,
                        "priority_id" => $validated["priority"],
                        "end_date" => $validated["end_date"]
                    ]);

                    $id = $create_task->id; // ახლად დამატებული თასქის აიდი

                    foreach($request->users as $users) {
                        TaskHasPerformer::insert([
                            "performer_id" => $users,
                            "task_id" => $id
                        ]);
                    }
                });

                DB::commit();

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

    /**
     * დავალებების წამოღების მეთოდი
     * @method GET,
     * @return json
     * 
     * @OA\Get(
     *     path="/api/task/list",
     *     security={{ "bearerAuth": {} }},
     *     tags={"თასქების API"},
     *     summary="დავალებების წამოღების მარშუტი",
     *     
     *     @OA\Response(
     *         description="დავალებები ჩაიტვირთა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="დავალებები ვერ ჩაიტვირთა",
     *         response=422
     *     )
     * )
     */
    public function Task_List() {
        $tasks = Task::join("task_has_performers", "tasks.id", "=", "task_has_performers.task_id")
                        ->join("users", "users.id", "=", "task_has_performers.performer_id")
                        ->where("task_has_performers.performer_id", Auth::id())
                        ->orderBy("created_at", "DESC")
                        ->get();

        return $tasks;
    }

    /**
     * თასქის შესრულებულად მონიშვნის მეთოდი
     * @param int $id
     * @return json
     * @method PUT
     * 
     *     path="/api/task/mark/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"თასქების API"},
     *     summary="თასქის შესრულებულად მონიშვნის მარშუტი",
     * 
     *     @OA\Response(
     *         description="მოინიშნა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="ვერ მოინიშნა",
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
     */
    public function Mark_Task_As_Done(int $id) {
        try {
            Task::whereId($id)->update([
                "status_id" => 4
            ]);

            return response()->json([
                "message" => "მოინიშნა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "message" => "ვერ მოინიშნა"
            ], 422);
        }
    }
}
