<?php
    namespace App\Http\Interfaces;

    use App\Http\Requests\AddTaskRequest;
    use App\Http\Requests\EditTaskRequest;

    // ინტერფეისი თასკების კლასისთვის
    interface ITasks {
        public function Add_Task(AddTaskRequest $request); // თასქის დამატების მეთოდი

        public function Task_Delete(int $id); // თასქის წაშლის მეთოდი

        public function Edit_Task(EditTaskRequest $request, int $id); // თასქის რედაქტირების მეთოდი

        public function Task_List(); // დავალებების წამოღების მეთოდი

        public function Mark_Task_As_Done(int $id); //თასქის შესრულებულად მონიშვნის მეთოდი

        public function Get_Task(int $id); // თასქის წამოღების მეთოდი
    }
?>