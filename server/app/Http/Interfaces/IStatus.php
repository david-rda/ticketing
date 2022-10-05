<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;
    use App\Http\Requests\StatusAddRequest;

    // ინტერფეისი სტატუსების კლასისთვის
    interface IStatus {
        public function Status_List(); // სტატუსების სიის მეთოდი

        public function Status_Delete(int $id); // სტატუსის წაშლის მეთოდი

        public function Status_Add(StatusAddRequest $request); // სტატუსის დამატების მეთოდი
    }
?>