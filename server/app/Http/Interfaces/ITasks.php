<?php
    namespace App\Http\Interfaces;

    use App\Http\Requests\AddTaskRequest;

    // ინტერფეისი თასკების კლასისთვის
    interface ITasks {
        public function Add_Task(AddTaskRequest $request); // თასქის დამატების მეთოდი
    }
?>