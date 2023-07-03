<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', ''); // Get the search query parameter from the request

        // Retrieve employees based on the search query
        $employees = user::where('name', 'like', '%' . $search . '%')->get();

        return view('employees.index', compact('employees', 'search'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'employee_number' => 'required',
            'role' => 'required',
        ]);

        $requestData = $request->all();
        $requestData['password'] = Hash::make($request->password);

        try {
            User::create($requestData);
            $message = 'Medewerker succesvol aangemaakt';
            return redirect()->back()->with('alert', ['type' => 'message', 'message' => $message, 'autoClose' => true]);
        } catch (\Exception $e) {
            $message = 'Medewerker niet aangemaakt';
            return redirect()->with('alert', ['type' => 'error', 'message' => $message, 'autoClose' => true]);
        }
    }

    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'password' => 'nullable|min:6|confirmed',
            'employee_number' => 'required',
            'role' => 'required',
        ]);

        $requestData = $request->all();
        if ($request->password) {
            $requestData['password'] = Hash::make($request->password);
        } else {
            unset($requestData['password']);
        }

        $employee->update($requestData);

        $message = 'Medewerker succesvol aangepast';
        return redirect()->back()->with('alert', ['type' => 'message', 'message' => $message, 'autoClose' => true]);
    }

    // Delete user
    public function destroy(User $employee)
    {
        $employee->delete();

        $message = 'Medewerker succesvol verwijderd';
        return redirect()->back()->with('alert', ['type' => 'message', 'message' => $message, 'autoClose' => true]);
    }

    // Update role status
    public function toggleRole(Request $request, User $employee)
    {
        $enabled = $request->input('enabled', false);
        $employee->role_enabled = $enabled;
        $employee->save();

        // Return a response if needed
        return response()->json(['success' => true]);
    }
}
