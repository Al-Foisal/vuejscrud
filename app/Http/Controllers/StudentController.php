<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller {
    public function index() {
        $data = Student::with('department', 'results')->get();

        return $data;
    }

    public function departmentList() {
        $data = Department::all();

        return $data;
    }

    public function store(Request $request) {
        $data = Student::create($request->all());

        return response()->json(['status' => true]);
    }

    public function update(Request $request, $id) {
        $data = Student::find($id);
        $data->update($request->all());

        return response()->json(['status' => true]);
    }

    public function delete($id) {
        $data = Student::find($id);
        $data->delete();

        return response()->json(['status' => true]);
    }
}
