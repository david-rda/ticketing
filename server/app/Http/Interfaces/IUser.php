<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;

    // ინტერფეისი მომხმარებელთა კლასისთვის
    interface IUser {
        public function Insert_Users(Request $request); // მომხმარებლების ატვირთვის მეთოდი

        public function User_List(); // მომხმარებელთა სიის გამოტანის მეტოდი
    }
?>