<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;
    use App\Http\Requests\StatusAddRequest;
    use App\Http\Requests\EditStatusRequest;

    // ინტერფეისი სტატუსების კლასისთვის
    interface IStatus {
        public function Status_List(); // სტატუსების სიის მეთოდი

        public function Status_Delete(int $id); // სტატუსის წაშლის მეთოდი

        public function Status_Add(StatusAddRequest $request); // სტატუსის დამატების მეთოდი

        public function Task_By_Status(int $status_id); // თასქების წამოღება სტატუსის მიხედვით

        public function Edit_Status(EditStatusRequest $request, $id); // სტატუსის რედაქტირების მეთოდი
    }
?>