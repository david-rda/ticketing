<?php
    namespace App\Http\Interfaces;

    use App\Http\Requests\AddTaskRequest;
    use App\Http\Requests\EditTaskRequest;

    // ინტერფეისი თასკების კლასისთვის
    interface ITasks {
        public function Add_Task(AddTaskRequest $request); // დავალების დამატების მეთოდი

        public function Task_Delete(int $id); // დავალების წაშლის მეთოდი

        public function Edit_Task(EditTaskRequest $request, int $id); // დავალების რედაქტირების მეთოდი

        public function Task_List(); // დავალებების წამოღების მეთოდი

        public function Mark_Task_As_Done(int $id); //დავალების შესრულებულად მონიშვნის მეთოდი

        public function Get_Task(int $id); // დავალების წამოღების მეთოდი

        public function Task_By_Status(int $status_id); // თასქის წამოღების მეთოდი სტატუსის მიხედვით

        public function Delete_Task_File(int $id); // თასქზე მიმაგრებული ფაილის წაშლის მეთოდი
    }
?>