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

    // public function showParticipants(Request $request, Program $program)
    // {
    //     $search = $request->input('search');

    //     $participants = $program->users()->with(['userLogs' => function ($query) use ($program) {
    //         $query->where('program_id', $program->id);
    //         }])
    //         ->when($search, function ($query) use ($search) {
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('name', 'like', '%' . $search . '%')
    //                     ->orWhere('email', 'like', '%' . $search . '%')
    //                     ->orWhere('ic', 'like', '%' . $search . '%')
    //                     ->orWhere('phone', 'like', '%' . $search . '%')
    //                     ->orWhere('address', 'like', '%' . $search . '%')
    //                     ->orWhere('notes', 'like', '%' . $search . '%')
    //                     ->orWhere('organization', 'like', '%' . $search . '%');
    //             });
    //         })
    //         ->get();

    //     $guests = $program->guests()
    //         ->when($search, function ($query) use ($search) {
    //             $query->where(function ($q) use ($search) {
    //                 $q->where('name', 'like', '%' . $search . '%')
    //                     ->orWhere('email', 'like', '%' . $search . '%')
    //                     ->orWhere('phone', 'like', '%' . $search . '%');
    //             });
    //         })
    //         ->get();

    //     $totalParticipantCount = $participants->count() + $guests->count(); // kira total participant
    //     $guest = $guests->count();
    //     $member = $participants->count();
    //     $participantCountUser = $participants->where('pivot.attendance', 1)->count(); // kira total attendance participant
    //     $attendanceUser = $participants->filter(function ($participant) {
    //         return $participant->pivot->attendance === 1;
    //     });

    //     // dd($attendanceUser);

    //     return view('admin.programs.participants', compact(
    //         'program',
    //         'attendanceUser',
    //         'participants',
    //         'guests',
    //         'totalParticipantCount',
    //         'participantCountUser',
    //         'search',
    //         'guest',
    //         'member'
    //     ));
    // }

    public function showParticipants(Request $request, Program $program)
    {
        $search = $request->input('search');

        // Participants who submitted (Tab 1)
        $participantsSubmitted = $program->users()
            ->whereHas('userLogs', function ($query) use ($program) {
                $query->where('program_id', $program->id)->whereNotNull('submitted');
            })
            ->when($search, function ($query) use ($search) {
                // ... Your existing search query for submitted participants table ...
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('ic', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%')
                        ->orWhere('notes', 'like', '%' . $search . '%')
                        ->orWhere('organization', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        // All participants (Tab 2)
        $participantsAll = $program->users()
            ->with(['userLogs' => function ($query) use ($program) {
                $query->where('program_id', $program->id);
            }])
            ->when($search, function ($query) use ($search) {
                // ... Your existing search query for all participants table ...
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('ic', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%')
                        ->orWhere('notes', 'like', '%' . $search . '%')
                        ->orWhere('organization', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        // Guests (Tab 3)
        $guests = $program->guests()
            ->when($search, function ($query) use ($search) {
                // ... Your existing search query for guests table ...
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        // Count of Participants who submitted
        $participantCountSubmitted = $participantsSubmitted->total();
        // Count of Guests
        $guestCount = $guests->total();
        // Count of All Participants
        $participantCountAll = $participantsAll->total();
        // Count of All Participants + Guest
        $TotalParticipants = $participantCountAll + $guestCount;
        // dd($TotalParticipants);

        // Pass the paginated data to the view
        return view('admin.programs.participants', compact(
            'program',
            'participantsSubmitted',
            'participantsAll',
            'guests',
            'participantCountSubmitted',
            'participantCountAll',
            'guestCount',
            'TotalParticipants',
            'search'
        ));
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
