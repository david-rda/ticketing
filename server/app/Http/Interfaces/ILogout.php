<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;

    // ინტერფეისი სისტემიდან გამოსვლის კლასისთვის
    interface ILogout {
        public function Logout(Request $request); // სისტემიდან გამოსვლის მეთოდი
    }
?>