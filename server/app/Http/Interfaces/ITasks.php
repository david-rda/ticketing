<?php
    namespace App\Http\Interfaces;

    use App\Http\Requests\AddTaskRequest;

    // ინტერფეისი თასკების კლასისთვის
    interface ITasks {
        public function Add_Task(AddTaskRequest $request); // თასქის დამატების მეთოდი

        public function Task_Delete(int $id); // თასქის წაშლის მეთოდი

        public function Task_By_Status(int $status_id); // თასქის სია სტატუსების მიხედვით
    }
?>