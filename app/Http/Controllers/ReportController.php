<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class ReportController extends Controller
{
    public function index()
    {
        $programs = Program::with(['users', 'guests'])->get();


        $chartData = [];

        foreach ($programs as $program) {
            $userCount = $program->users()->count();
            $guestCount = $program->guests()->count();
            $attendance = UserLog::where('program_id', $program->id)->where('attendance', '=', 0)->count();
            // dd($attendance);

            $genderCounts = [
                'male' => 0,
                'female' => 0,
                // Add more genders if needed
            ];

            foreach ($program->users as $user) {
                if ($user->gender) {
                    $genderCounts[$user->gender]++;
                }
            }

            foreach ($program->guests as $guest) {
                if ($guest->gender) {
                    $genderCounts[$guest->gender]++;
                }
            }

            $userGenderCounts = [
                'male' => $program->users()->where('gender', 'male')->count(),
                'female' => $program->users()->where('gender', 'female')->count(),
            ];

            $guestGenderCounts = [
                'male' => $program->guests()->where('gender', 'male')->count(),
                'female' => $program->guests()->where('gender', 'female')->count(),
            ];

            // Retrieve user and guest states
            $userStates = $this->getUserStates($program);
            $guestStates = $this->getGuestStates($program);

            $chartData[$program->id] = [
                'program_name' => $program->name,
                'user_count' => $userCount,
                'guest_count' => $guestCount,
                'totalpeserta' => $userCount + $guestCount,
                'user_gender_counts' => $userGenderCounts,
                'guest_gender_counts' => $guestGenderCounts,
                'gender_counts' => $genderCounts,
                'user_states' => $userStates,
                'guest_states' => $guestStates,
                'submitted_attendance_count' => UserLog::where('program_id', $program->id)->where('attendance', 1)->count(),
                'not_submitted_attendance_count' => UserLog::where('program_id', $program->id)->where('attendance', '=', 0)->count(),
            ];
        }

        return view('admin.reports.index', compact('chartData'));
    }

    private function getUserStates(Program $program)
    {
        $userStates = [
            'Johor' => $program->users()->where('state', 'Johor')->count(),
            'Kedah' => $program->users()->where('state', 'Kedah')->count(),
            'Kelantan' => $program->users()->where('state', 'Kelantan')->count(),
            'Melaka' => $program->users()->where('state', 'Melaka')->count(),
            'Negeri Sembilan' => $program->users()->where('state', 'Negeri Sembilan')->count(),
            'Pahang' => $program->users()->where('state', 'Pahang')->count(),
            'Perak' => $program->users()->where('state', 'Perak')->count(),
            'Perlis' => $program->users()->where('state', 'Perlis')->count(),
            'Pulau Pinang' => $program->users()->where('state', 'Pulau Pinang')->count(),
            'Sabah' => $program->users()->where('state', 'Sabah')->count(),
            'Sarawak' => $program->users()->where('state', 'Sarawak')->count(),
            'Selangor' => $program->users()->where('state', 'Selangor')->count(),
            'Terengganu' => $program->users()->where('state', 'Terengganu')->count(),
            'Kuala Lumpur' => $program->users()->where('state', 'Kuala Lumpur')->count(),
            'Labuan' => $program->users()->where('state', 'Labuan')->count(),
            'Putrajaya' => $program->users()->where('state', 'Putrajaya')->count(),
        ];

        return $userStates;
    }

    private function getGuestStates(Program $program)
    {
        $guestStates = [
            'Johor' => $program->guests()->where('state', 'Johor')->count(),
            'Kedah' => $program->guests()->where('state', 'Kedah')->count(),
            'Kelantan' => $program->guests()->where('state', 'Kelantan')->count(),
            'Melaka' => $program->guests()->where('state', 'Melaka')->count(),
            'Negeri Sembilan' => $program->guests()->where('state', 'Negeri Sembilan')->count(),
            'Pahang' => $program->guests()->where('state', 'Pahang')->count(),
            'Perak' => $program->guests()->where('state', 'Perak')->count(),
            'Perlis' => $program->guests()->where('state', 'Perlis')->count(),
            'Pulau Pinang' => $program->guests()->where('state', 'Pulau Pinang')->count(),
            'Sabah' => $program->guests()->where('state', 'Sabah')->count(),
            'Sarawak' => $program->guests()->where('state', 'Sarawak')->count(),
            'Selangor' => $program->guests()->where('state', 'Selangor')->count(),
            'Terengganu' => $program->guests()->where('state', 'Terengganu')->count(),
            'Kuala Lumpur' => $program->guests()->where('state', 'Kuala Lumpur')->count(),
            'Labuan' => $program->guests()->where('state', 'Labuan')->count(),
            'Putrajaya' => $program->guests()->where('state', 'Putrajaya')->count(),
        ];

        return $guestStates;
    }
}
