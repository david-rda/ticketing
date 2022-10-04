<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;

    // ინტერფეისი ავტორიზაციის კლასისთვის
    interface IAuth {
        public function ValidateData(Request $request); // მონაცემთა ვალიდაციის მეთოდი

        public function Login(Request $request); // ავტორიზაციის მეთოდი
    }
?>