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
use DB;
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
       // dd($request->all());


       $prefix = strtolower(substr($request->name, 0, 3) . substr($request->surname, 0, 3));

        // Count how many users already have an identifier that starts with this prefix
        $count = Archer::whereRaw("LOWER(LEFT(name, 3)) = ?", [strtolower(substr($request->name, 0, 3))])
            ->whereRaw("LOWER(LEFT(surname, 3)) = ?", [strtolower(substr($request->surname, 0, 3))])
            ->count();

        // Increment the count to generate the new suffix (01, 02, 03...)
        $suffix = str_pad($count + 1, 2, '0', STR_PAD_LEFT);

        // Final ID: e.g., johdoe01
        $archerId = $prefix . $suffix;

       // dd($archerId);

        $archer = new Archer();
        $archer->name = $request->name;
        $archer->generatedId =  $archerId;
        $archer->surname = $request->surname;
        $archer->dob = $request->dob;
        $archer->ageCategory = $request->ag;
        $archer->currentGradingWeak = $request->cgw;
        $archer->currentGradingDominant = $request->cgd;
        $archer->hand = $request->hand;
        $archer->email = $request->email;
        $archer->currentProficiency = $request->cp;
        $archer->agegroupProficiency = $request->agp;
        $archer->hand = $request->dh;
        $archer->createdBy = $user;  
        $archer->clubMember = $request->clubMember;  
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
       $scorecards = DB::table('scorecards')
                    ->where('archergrading_id', $id)
                    ->orderBy('round')
                    //->orderBy('arrow')
                    ->get()
                    ->groupBy('round');
   //dd( $scorecards );


       return view('archers.historydetails', compact('grading','Round1','scorecards'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $archer = Archer::where('id',$id)->first();

        return view('archers.edit', compact('archer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
       $user = Auth::user()->id;
    
 
         $archer =  Archer::where('id', $id)->update([

         'name' => $request->name,
         'surname' => $request->surname,
         'dob' => $request->dob,
         'ageCategory' => $request->ag,
         'currentGradingWeak' => $request->cgw,
         'currentGradingDominant' => $request->cgd,
         'hand' => $request->hand,
         'email' => $request->email,
         'currentProficiency' => $request->cp,
         'agegroupProficiency' => $request->agp,
         'hand' => $request->dh,
         'clubMember' => $request->clubMember, 
         'updatedBy' => $user,  
    ]); 


    if($archer){

        return redirect()->back()->with('success', 'Archer updated successfully!');
      }
        return back()->with('error', 'Failed to update Archer!');
     
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
