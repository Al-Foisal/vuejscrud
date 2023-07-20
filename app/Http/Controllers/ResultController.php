<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;

class ResultController extends Controller {
    public function index() {
        $data = Result::with('student.department')->get();

        return $data;
    }

    public function studentList() {
        $data = Student::all();

        return $data;
    }

    public function store(Request $request) {
        $data = Result::create($request->all());

        return response()->json(['status' => true]);
    }

    public function update(Request $request, $id) {
        $data = Result::find($id);
        $data->update($request->all());

        return response()->json(['status' => true]);
    }

    public function delete($id) {
        $data = Result::find($id);
        $data->delete();

        return response()->json(['status' => true]);
    }
}
