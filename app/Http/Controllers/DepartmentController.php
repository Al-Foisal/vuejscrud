<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller {
    public function index() {
        $data = Department::all();

        return $data;
    }

    public function store(Request $request) {
        Department::create($request->all());

        return response()->json(['status' => true]);
    }

    public function update(Request $request, $id) {
        $data       = Department::find($id);
        $data->name = $request->name;
        $data->save();

        return response()->json(['status' => true]);
    }

    public function delete($id) {
        $data = Department::find($id);
        $data->delete();

        return response()->json(['status' => true]);
    }
}