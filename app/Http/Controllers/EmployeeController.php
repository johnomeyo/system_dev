<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
        /**
     * Display a listing of the employees.
     */
    public function index()
    {
        $employees = Employee::all(); // Fetch all employees from the database
        return view('employees.index', compact('employees'));
    }

    /**
     * Store a newly created employee in the database.
     */
    public function store(Request $request)
    {
        // 1. Validate the form data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'id_number' => 'required|string|max:255|unique:employees',
            'nssf_number' => 'nullable|string|max:255|unique:employees',
            'payroll_number' => 'nullable|string|max:255|unique:employees',
            'salary' => 'required|numeric|min:0',
            'phone_number' => 'nullable|string|max:255',
            'date_of_joining' => 'nullable|date',
        ]);

        // 2. Create the employee
        Employee::create($validatedData);

        // 3. Redirect back with a success message
        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }
}
