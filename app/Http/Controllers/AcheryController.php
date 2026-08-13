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
use Barryvdh\DomPDF\Facade\Pdf;
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
public function index(Request $request)
{
    $institutes = Archer::whereNotNull('institute')
        ->where('institute', '!=', '')
        ->distinct()
        ->orderBy('institute')
        ->pluck('institute');

    $query = Archer::query();

    if ($request->filled('institute')) {
        $query->where('institute', $request->institute);
    }

    if ($request->filled('ageCategory')) {
        $query->where('ageCategory', $request->ageCategory);
    }

    $all = $query->get();

    return view('archers.index', compact('all', 'institutes'));
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
  
       $prefix = strtolower(substr($request->name, 0, 3) . substr($request->surname, 0, 3));

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
        $archer->institute = $request->institute;
        $archer->dob = $request->dob;
        $archer->gender = $request->gender;
        $archer->nId = $request->nId;
        $archer->knownAs = $request->knownAs;
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
       $eventIds = $all->pluck('event')->filter()->unique()->values();
       $eventScores = Eventscore::where('archer_id', $id)
          ->whereIn('event_id', $eventIds)
          ->get()
          ->keyBy(fn ($eventScore) => (string) $eventScore->event_id);
       $categories = Eventcategory::whereIn('id', $events->whereIn('id', $eventIds)->pluck('cat')->filter()->unique())
          ->get()
          ->keyBy(fn ($category) => (string) $category->id);
       $certificateEventScoreIdsByGradingId = collect();
       $certificates = app(GradingController::class);

       foreach ($all as $grading) {
          $event = $events->firstWhere('id', $grading->event);
          $eventScore = $eventScores->get((string) $grading->event);
          $category = $event ? $categories->get((string) $event->cat) : null;

          if (
             $eventScore
             && $certificates->isCertificateEvent($category)
             && $certificates->isUpgradedForCertificate($eventScore, $grading, $category)
          ) {
             $certificateEventScoreIdsByGradingId->put((string) $grading->id, $eventScore->id);
          }
       }

       return view('archers.history', compact('all','events', 'certificateEventScoreIdsByGradingId'));

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
    
    // fix nid and gender that are not being updated in the database

       $user = Auth::user()->id;
    
 
         $archer =  Archer::where('id', $id)->update([

         'name' => $request->name,
         'surname' => $request->surname,
         'dob' => $request->dob,
         'gender' => $request->gender,
         'nId' => $request->nId,
         'knownAs' => $request->knownAs,
         'ageCategory' => $request->ag,
         'currentGradingWeak' => $request->cgw,
         'currentGradingDominant' => $request->cgd,
         'hand' => $request->hand,
         'email' => $request->email,
         'currentProficiency' => $request->cp,
         'agegroupProficiency' => $request->agp,
         'hand' => $request->dh,
         'institute' => $request->institute,
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
    public function downloadGrading(string $id)
    {
      $grading = Archergrading::where('id', $id)->first();
    $Round1 = Round1::where('archergrading_id', $id)->first();
    $scorecards = DB::table('scorecards')
        ->where('archergrading_id', $id)
        ->orderBy('round')
        ->get()
        ->groupBy('round');

    // Same pre-processing logic from Blade
    $maxArrows = $scorecards->map(function ($round) {
        return count($round);
    })->max();

    $roundTotals = [];
    $cumTotals = [];
    $times = [];
    $totalScore = 0;

    foreach ($scorecards as $round => $entries) {
        $first = collect($entries)->first();
        $roundTotals[$round] = $first->roundtotal ?? 0;
        $cumTotals[$round] = $first->cumtotal ?? 0;
        $times[$round] = $first->time ?? '-';
        $totalScore = $first->total ?? 0;
    }

    $pdf = Pdf::loadView('pdf.scorecard', compact(
        'grading',
        'Round1',
        'scorecards',
        'maxArrows',
        'roundTotals',
        'cumTotals',
        'times',
        'totalScore'
    ))->setPaper('a4', 'landscape');

    return $pdf->download('scorecard-history.pdf'); 
    }
}
