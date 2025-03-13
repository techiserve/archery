<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Archer;
use App\Models\Event;
use App\Models\Eventcategory;
use App\Models\Round1;
use App\Models\Round2;
use App\Models\Round3;
use App\Models\Round4;
use App\Models\Round5;
use App\Models\Round6;
use App\Models\Round7;
use App\Models\Round8;
use App\Models\Round9;
use App\Models\Eventscore;
use App\Models\Archergrading;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AcheryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Archer::all();

        return view('archers.index', compact('all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('archers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
      //  dd($request->all());

        $archer = new Archer();
        $archer->name = $request->name;
        $archer->surname = $request->surname;
        $archer->dob = $request->dob;
        $archer->ageCategory = $request->category;
        $archer->currentGrading = $request->grading;
        $archer->createdBy = $user;    
        $archer->save();
      
        if($archer){

          return redirect()->back()->with('success', 'Archer created successfully!');
        }
          return back()->with('error', 'Failed to create Archer!');
       
    }

    /**
     * Display the specified resource.
     */
    public function viewmore(string $id)
    {
       $all = Archergrading::where('archer_id', $id)->get();
       $events = Event::all();

       return view('archers.history', compact('all','events'));

    }


    public function historydetails(string $id)
    {
       // dd($id);

       $grading = Archergrading::where('id', $id)->first();
       $Round1 = Round1::where('archergrading_id', $id)->first();
       $Round2 = Round2::where('archergrading_id', $id)->first();
       $Round3 = Round3::where('archergrading_id', $id)->first();
       $Round4 = Round4::where('archergrading_id', $id)->first();
       $Round5 = Round5::where('archergrading_id', $id)->first();
       $Round6 = Round6::where('archergrading_id', $id)->first();
       $Round7 = Round7::where('archergrading_id', $id)->first();
       $Round8 = Round8::where('archergrading_id', $id)->first();
       $Round9 = Round9::where('archergrading_id', $id)->first();

       //dd($grading);

       return view('archers.historydetails', compact('grading','Round1','Round2','Round3','Round4','Round5','Round6','Round7','Round8','Round9'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
