<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;
    use App\Http\Requests\PriorityAddRequest;
    use App\Http\Requests\EditPriorityRequest;

    // ინტერფეისი პრიორიტეტების კლასისთვის
    interface IPriority {
        public function Priority_List(); // პრიორიტეტების სიის მეთოდი

        public function Priority_Delete(int $id); // პრიორიტეტის წაშლის მეთოდი

        public function Priority_Add(PriorityAddRequest $request); // პრიორიტეტის დამატების მეთოდი

        public function Edit_Priority(EditPriorityRequest $request, int $id); // პრიორიტეტის რედაქტირების მეთოდი
    }
?>