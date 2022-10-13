<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;
    use App\Http\Requests\PasswordChangeRequest;

    // ინტერფეისი მომხმარებელთა კლასისთვის
    interface IUser {
        public function Insert_Users(Request $request); // მომხმარებლების ატვირთვის მეთოდი

        public function User_Search(Request $request); // მომხმარებელთა ძებნის მეტოდი

        public function Change_Password(PasswordChangeRequest $request); // პაროლის ცვლილების მეთოდი

        public function User_Get(int $id); // მომხმარებლის ინფოს წამოღების მეთოდი
    }
?>