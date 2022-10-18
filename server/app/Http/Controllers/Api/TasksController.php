<?php

namespace App\Http\Controllers\Api;

use App\Http\Interfaces\ITasks; // ინტერფეისი თასკების კლასისთვის

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\EditTaskRequest;
use DB;
use Auth;
use Str;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\TaskHasPerformer;
use App\Models\TaskFile;
use App\Models\Comment;

class TasksController extends Controller implements ITasks
{
    /**
     * დავალების დამატების მეთოდი
     * @method POST
     * @param AddTaskRequest
     * @return json
     * 
     * @OA\Post(
     *     path="/api/task/add",
     *     tags={"დავალებების API"},
     *     security={{"bearerAuth", {}}},
     *     summary="დავალების დამატების მარსუტი",
     * 
     *     @OA\Response(
     *         description="თქვენი დავალება წარმატებით გაიგზავნა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="დავალება ვერ გაიგზავნა",
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
                        "end_date" => date("Y-m-d H:i:s", strtotime($validated["end_date"]))
                    ]);

                    $id = $create_task->id; // ახლად დამატებული დავალების აიდი

                    foreach($request->file("files") as $data) {
                        $filename = Str::random(4) . "_" . $data->getClientOriginalName();

                        $data->move(public_path("documents"), $filename);

                        TaskFile::insert([
                            "file" => $filename,
                            "task_id" => $id,
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ]);
                    }

                    foreach($request->users as $users) {
                        TaskHasPerformer::insert([
                            "performer_id" => $users,
                            "task_id" => $id
                        ]);
                    }
                });

                DB::commit();

                return response()->json([
                    "message" => "თქვენი დავალება წარმატებით გაიგზავნა"
                ], 200);
            }
        }catch(Exception $e) {
            return response()->json([
                "message" => "თქვენი დავალება ვერ გაიგზავნა"
            ], 422);
        }
    }

    /**
     * თასქზე მიმაგრებული ფაილის წაშლის მეთოდი
     * @method DELETE
     * @return json
     * @param int id
     * 
     * @OA\Delete(
     *     path="/api/task/file/delete/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"დავალებების API"},
     *     summary="დავალებაზე მიმაგრებული ფაილის წაშლის მარშუტი",
     * 
     *     @OA\Response(
     *         description="ფაილი წაიშალა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="ფაილი ვერ წაიშალა",
     *         response=422
     *     ),
     * 
     *     @OA\Parameter(
     *         name="id",
     *         description="ფაილი აიდი",
     *         required=true,
     *         in="path",
     *         
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     )
     * )
     */
    public function Delete_Task_File(int $id) {
        try {
            $filename = TaskFile::whereId($id)->first()->file; // ბაზიდან წამოღებული ფაილის სახელი
            $delete_file = TaskFile::whereId($id)->delete(); // ბაზიდან ფაილის ამოშლა
            unlink(public_path("documents/") . $filename); // ფიზიკურად ფაილის წაშლა ფოლდერიდან

            return response()->json([
                "message" => "ფაილი წაიშალა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "message" => "ფაილი ვერ წაიშალა"
            ], 422);
        }
    }

    /**
     * დავალების წაშლის მეთოდი
     * @param int<id>
     * @method DELETE
     * @return json
     * 
     * @OA\Delete(
     *     path="/api/task/delete/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"დავალებების API"},
     *     summary="დავალების წაშლის მარშუტი",
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
     *         description="დავალების აიდი",
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
            TaskHasPerformer::where("task_id", $id)->delete();

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
     * დავალების რედაქტირების მეთოდი
     * @param int<id>,EditTaskRequest $request
     * @method POST
     * @return json
     * 
     * @OA\Post(
     *     path="/api/task/edit/{id}",
     *     security={{"bearerAuth":{}}},
     *     tags={"დავალებების API"},
     *     summary="დავალების რედაქტირების მარშუტი",
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
     *         description="დავალების აიდი",
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
                DB::transaction(function() use($validated, $request, $id) {
                    Task::whereId($id)->update([
                        "title" => $validated["title"],
                        "description" => $validated["description"],
                        "priority_id" => $validated["priority"],
                        "end_date" => date("Y-m-d H:i:s", strtotime($validated["end_date"]))
                    ]);

                    if($request->hasFile("files")) {
                        foreach($request->file("files") as $file) {
                            $filename = Str::random(4) . "_" . $file->getClientOriginalName();
    
                            $file->move(public_path("documents"), $filename);
    
                            TaskFile::insert([
                                "file" => $filename,
                                "task_id" => $id,
                                "created_at" => Carbon::now(),
                                "updated_at" => Carbon::now()
                            ]);
                        }
                    }

                    foreach($request->users as $users) {
                        TaskHasPerformer::updateOrCreate([
                            "performer_id" => $users,
                            "task_id" => $id
                        ]);
                    }
                });

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
     *     tags={"დავალებების API"},
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

        return response()->json([
            "tasks" => $tasks,
            "count" => $tasks->count()
        ], 200);
    }

    /**
     * დავალების შესრულებულად მონიშვნის მეთოდი
     * @param int $id
     * @return json
     * @method PUT
     * 
     * path="/api/task/mark/{id}",
     * security={{"bearerAuth":{}}},
     * tags={"დავალებების API"},
     * summary="დავალების შესრულებულად მონიშვნის მარშუტი",
     * 
     * @OA\GPut
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
     *         description="დავალების აიდი",
     *         required=true,
     *         in="path",
     *         
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     )
     * )
     */
    public function Mark_Task_As_Done(int $id) {
        try {

            $task = Task::whereId($id)->first();
            $task->status_id = ($task->status_id == 4) ? null : 4;
            $task->save();

            return response()->json([
                "message" => "მოინიშნა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "message" => "ვერ მოინიშნა"
            ], 422);
        }
    }

    /**
     * დავალების წამოღების მეთოდი აიდის მიხედვით
     * @method GET,
     * @param int $id თასქის აიდი
     * @return json
     * 
     * @OA\Get(
     *     path="/api/task/get/{id}",
     *     security={{ "bearerAuth": {} }},
     *     tags={"დავალებების API"},
     *     summary="დავალების წამოღების მარშუტი",
     *     
     *     @OA\Response(
     *         description="დავალება ჩაიტვირთა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="დავალება ვერ ჩაიტვირთა",
     *         response=422
     *     )
     * )
     */
    public function Get_Task(int $id) {
        return Task::whereId($id)->first();
    }

    /**
     * დავალებების წამოღება სტატუსის მიხედვით
     * @method GET
     * @param int status_id
     * @return json
     * 
     * @OA\Get(
     *     path="/api/task/by/status/{status_id}",
     *     security={{ "bearerAuth": {} }},
     *     tags={"დავალებების API"},
     *     summary="დავალების სტატუსის მიხედვით წამოღების მარშუტი",
     *     
     *     @OA\Response(
     *         description="დავალება ჩაიტვირთა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="დავალება ვერ ჩაიტვირთა",
     *         response=422
     *     )
     * )
     */
    public function Task_By_Status(int $status_id) {
        return Task::join("task_has_performers", "tasks.id", "=", "task_has_performers.task_id")
                    ->join("users", "users.id", "=", "task_has_performers.performer_id")
                    ->where("task_has_performers.performer_id", Auth::id())
                    ->where("tasks.status_id", $status_id)
                    ->orderBy("created_at", "DESC")
                    ->get(); 
    }

    /**
     * კომენტარის დამატების მეთოდი
     * @method POST
     * @param Request
     * @return json
     * 
     * @OA\Post(
     *     path="/api/task/add/comment",
     *     security={{ "bearerAuth": {} }},
     *     tags={"დავალებების API"},
     *     summary="დავალებაზე კომენტარის დამატების მარშუტი",
     * 
     *     @OA\Response(
     *         description="კომენტარი გაიგზავნა",
     *         response=200
     *     ),
     * 
     *     @OA\Response(
     *         description="კომენტარი ვერ გაიგზავნა",
     *         response=422
     *     )
     * )
     */
    public function Add_Comment(Request $request) {
        try {
            Comment::create([
                "task_id" => $request->task_id,
                "comment" => $request->comment,
                "author_id" => Auth::id()
            ]);

            return response()->json([
                "message" => "კომენტარი გაიგზავნა"
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                "message" => "კომენტარი ვერ გაიგზავნა"
            ], 422);
        }
    }
}
