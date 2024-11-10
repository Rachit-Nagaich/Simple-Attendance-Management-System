<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Schedule;
use App\Http\Requests\EmployeeRec;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('admin.employee')->with(['employees'=> Employee::all(), 'schedules'=>Schedule::all()]);
    }

    public function store(EmployeeRec $request)
    {
        // Validate the request
        $request->validated();

        // Create a new employee instance
        $employee = new Employee;
        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->pin_code = bcrypt($request->pin_code);
        $employee->save();

        // Attach the schedule if provided
        if ($request->schedule) {
            $schedule = Schedule::whereSlug($request->schedule)->first();
            $employee->schedules()->attach($schedule);
        }

        flash()->success('Success', 'Employee Record has been created successfully !');
        return redirect()->route('employees.index')->with('success');
    }



    public function update(EmployeeRec $request, Employee $employee)
    {
        $request->validated();

        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;

        // If pin_code is updated, hash it
        if ($request->pin_code) {
            $employee->pin_code = bcrypt($request->pin_code);
        }

        $employee->save();

        // Handle schedule update
        if ($request->schedule) {
            $employee->schedules()->detach();

            $schedule = Schedule::whereSlug($request->schedule)->first();

            if ($schedule) {
                $employee->schedules()->attach($schedule);
            } else {
                // Add a proper message if schedule does not exist
                flash()->error('Error', 'Invalid schedule selected!');
                return redirect()->route('employees.index');
            }
        }

        flash()->success('Success', 'Employee record has been updated successfully!');
        return redirect()->route('employees.index')->with('success');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        flash()->success('Success', 'Employee record has been deleted successfully!');
        return redirect()->route('employees.index')->with('success');
    }
}

