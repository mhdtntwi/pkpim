<?php

namespace App\Exports;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class ProgramParticipantsExport implements FromView, ShouldAutoSize
{
    protected $program;
    protected $participantCount;

    public function __construct(Program $program, $participantCount)
    {
        $this->program = $program;
        $this->participantCount = $participantCount;
    }

    public function view(): View
    {
        $participants = $this->program->users;
        $participantCount = $this->program->users()->wherePivot('attendance', 1)->get();

        $totalParticipantsCount = $this->program->users->count();
        $submittedParticipantsCount = $this->participantCount->count();

        return view('admin.programs.export', [
            'program' => $this->program,
            'participants' => $participants,
            'participantCount' => $participantCount,
            'totalParticipantsCount' => $totalParticipantsCount,
            'submittedParticipantsCount' => $submittedParticipantsCount
        ]);
    }
}