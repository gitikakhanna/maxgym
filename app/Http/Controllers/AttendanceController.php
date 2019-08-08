<?php

namespace App\Http\Controllers;

use App\Trainer;
use App\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainers = Trainer::all();
        return view('attendance',compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($trainerid)
    {

        $attendance = Attendance::where('trainerid', $trainerid)->orderBy('attended_date', 'desc')->get();
        return view('view-attendance', compact('attendance', 'trainerid'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'trainer' => 'required|not_in:0',
            // 'attended_date' => 'unique:attendances,attended_date'
        ]);

        $trainer_name = Trainer::where('id', $request->trainer)->value('name');
        Attendance::insert([
            'trainerid' => $request->trainer,
            'name' => $trainer_name,
            'attended_date' => $request->attended_date,
            'marking' => $request->marking,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $request->session()->flash('flashSuccess', 'Attendance marked successfully.');    
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
