<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;

    // ინტერფეისი სტატუსების კლასისთვის
    interface IStatus {
        public function Status_List(); // სტატუსების სიის მეთოდი

        public function Status_Delete(int $id); // სტატუსის წაშლის მეთოდი
    }
?>