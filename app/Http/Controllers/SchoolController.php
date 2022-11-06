<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Students;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function addClass(Request $req)
    {
        $class = new Classes;
        $class->title = $req->title;
        $class->save();
        return response()->json($class);
    }

    public function addStudent(Request $req)
    {
        $student = new Students;
        $student->name = $req->name;
        $student->save();
        return response()->json($student);
    }

    public function getStudents(string $id)
    {
        $class = Classes::find($id);
        if (empty($class)) {
            return response()->json([
                'message' => 'class not found'
            ]);
        }
        return response()->json($class->students);
    }

    public function getClasses(string $id)
    {
        $student = Students::find($id);
        if (empty($student)) {
            return response()->json([
                'message' => 'student not found'
            ]);
        }
        return response()->json($student->classes);
    }
}
