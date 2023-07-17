<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Program;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $joinedPrograms = UserLog::where('user_id', Auth::user()->id)->get();
        $availablePrograms = Program::where('status', 1)->get();

        return view('dashboard', compact('joinedPrograms', 'availablePrograms'));
    }

    public function submitAttendance(Request $request)
    {
        $user = Auth::user();
        $programId = $request->input('program_id');
        $userLog = UserLog::where('user_id', $user->id)->where('program_id', $programId)->first();

        // Check if the program form is open
        $program = Program::find($programId);
        if ($program && $program->form == 1) {
            // Update the attendance and submitted date
            if ($userLog) {
                $userLog->attendance = 1;
                $userLog->submitted = now(); // Set the submitted date to the current date and time
                $userLog->save();
            } else {
                UserLog::create([
                    'user_id' => $user->id,
                    'program_id' => $programId,
                    'attendance' => 1,
                    'submitted' => now(), // Set the submitted date to the current date and time
                ]);
            }

            // Format the submitted value using Carbon
        $submitted = Carbon::parse($userLog->submitted)->format('Y-m-d h:i:s A');

        return redirect()->route('dashboard')->with('status', 'Attendance submitted successfully. Submitted at: ' . $submitted);
        }
    }

    // applyProgram function
    public function applyProgram(Program $program)
    {
        // $user = Auth::user();
        // $user->programs()->attach($program->id);

        $userLog = UserLog::create([
            'user_id' => $user->id,
            'program_id' => $program->id,
            'attendance' => 0,
        ]);

        $userLog->update(['joined' => now()]); // Set the joined date to the current date and time

        return redirect()->back()->with('status', 'Applied for the program successfully.');
    }
}
