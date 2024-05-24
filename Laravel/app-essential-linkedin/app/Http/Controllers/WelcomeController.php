<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index() {
        // 1. Using raw SQL queries
            // $users = DB::select('select * from user');
            // dd($users);

        // 2. Using Query Builder
            // $users = DB::table('user')
            //     ->select(['name', 'email'])
            //     ->whereNotNull('email')
            //     ->orderBy('name')
            //     ->get();
            // dd($users);

        // 3. Using Eloquent ORM
            // $students = Student::all();
            // $students = Student::select(['name', 'email'])->whereNotNull('email')->orderBy('name')->get();
            // dd($students);

            // foreach($students as $student) {
            //     echo $student->name . "<br />";
            // }

            // Add new Student
            // $student = new Student();
            // $student->name = "New Name";
            // $student->email = "new_name@gmail.com";
            // $student->save();

        //return view('welcome');
    }
}
