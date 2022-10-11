<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;
    use App\Http\Requests\PasswordChangeRequest;

    // ინტერფეისი მომხმარებელთა კლასისთვის
    interface IUser {
        public function Insert_Users(Request $request); // მომხმარებლების ატვირთვის მეთოდი

        public function User_List(); // მომხმარებელთა სიის გამოტანის მეტოდი

        public function Change_Password(PasswordChangeRequest $request); // პაროლის ცვლილების მეთოდი
    }
?>