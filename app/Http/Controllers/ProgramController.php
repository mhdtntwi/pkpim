<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Program;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProgramParticipantsExport;
use Illuminate\Support\Facades\View;

class ProgramController extends Controller
{
    public function toggleStatus(Request $request, Program $program)
    {
        $program->status = $program->status === 1 ? 0 : 1;
        $program->save();

        return redirect()->back()->with('status', 'Program berjaya dikemaskini');
    }
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Program::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('date', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        $programs = $query->get();

        return view('admin.programs.index', compact('programs', 'search'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        // Validate the input from the form
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'location' => 'required',
            'description' => 'required',
            'status' => 'required',
            // Add validation rules for other program fields
        ]);

        // Create a new program instance and save it
        $program = new Program;
        $program->name = $request->name;
        $program->slug = Str::slug($program->name, "-");
        $program->date = $request->date;
        $program->location = $request->location;
        $program->description = $request->description;
        $program->status = $request->status;
        // Assign values for other program fields
        $program->save();

        // Redirect to the index page with a success message
        return redirect()->route('programs.index')->with('status', 'Program berjaya ditambah');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        // Validate the input from the form
        $validatedData = $request->validate([
            'name' => 'required',
            // Add validation rules for other program fields
        ]);

        // Update the program instance with the new values and save it
        $program->name = $request->name;
        $program->slug = Str::slug($program->name, "-");
        $program->date = $request->date;
        $program->location = $request->location;
        $program->description = $request->description;
        $program->status = $request->status;
        // Update other program fields if needed
        $program->save();

        // Redirect to the index page with a success message
        return redirect()->route('programs.index')->with('status', 'Program berjaya dikemaskini');
    }

    public function destroy(Program $program)
    {
        // Delete the program
        $program->delete();

        // Redirect to the index page with a success message
        return redirect()->route('programs.index')->with('status', 'Program dipadamkan');
    }

    public function showParticipants(Request $request, Program $program)
    {
        $search = $request->input('search');

        $usersQuery = $program->users()->with('userLogs');
        $guestsQuery = $program->guests();

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('ic', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('notes', 'like', '%' . $search . '%')
                    ->orWhere('organization', 'like', '%' . $search . '%');
            });

            $guestsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $participants = $usersQuery->join('user_logs as ul', 'users.id', '=', 'ul.user_id')
        ->select('users.*', 'ul.submitted', 'ul.joined')
        ->get();
        $guests = $guestsQuery->get();

        $totalParticipantCount = $participants->count() + $guests->count();
        // dd($totalParticipantCount);

        $participantCountUser = $participants->where('pivot.attendance', 1)->count();
        // dd($participants);
        $guestCountUser = $guests->count();

        return view('admin.programs.participants', compact('program', 'participants', 'guests', 'totalParticipantCount', 'participantCountUser', 'guestCountUser', 'search'));
    }

    public function exportPDF(Program $program)
    {
        $participants = $program->users;
        $participantCount = $program->users()->wherePivot('attendance', 1)->get();
        $participantCountUser = $participantCount->count();


        $data = [
            'program' => $program,
            'participants' => $participants,
            'participantCount' => $participantCount,
            'participantCountUser' => $participantCountUser
        ];

        $pdf = PDF::loadView('admin.programs.pdf', $data);

        return $pdf->download($program->slug.'.pdf');
        // return View::make('admin.programs.pdf', $data);
    }

    public function exportExcel(Program $program)
    {
        $participantCount = $program->users()->wherePivot('attendance', 1)->get();
        $participantCountUser = $participantCount->count();

        $export = new ProgramParticipantsExport($program, $participantCount);

        return Excel::download($export, 'program_'.$program->slug.'.xlsx');
    }

    public function updateForm(Request $request, Program $program)
    {
        $program->form = $program->form == 0 ? 1 : 0;
        $program->save();

        return redirect()->back()->with('status', 'Borang Kehadiran Berjaya Dikemaskini');
    }
}
