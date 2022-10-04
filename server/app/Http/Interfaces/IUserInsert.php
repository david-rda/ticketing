<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;

    // ინტერფეისი მომხმარებელთა კლასისთვის
    interface IUserInsert {
        public function Insert_Users(Request $request); // მომხმარებლების ატვირთვის მეთოდი
    }
?>