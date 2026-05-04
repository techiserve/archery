<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\MinScores;
use App\Models\Archer;
use App\Models\Archergrading;
use App\Models\Eventcategory;
use App\Models\Eventcategoryscore;
use App\Models\Event;
use App\Models\Round1;
use App\Models\Round2;
use App\Models\Round3;
use App\Models\Round4;
use App\Models\Round5;
use App\Models\Round6;
use App\Models\Round7;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Round8;
use App\Models\GradingCard;
use App\Models\Eventscore;
use App\Models\Scorecard;
use Illuminate\Support\Facades\Auth;
use App\Exports\EventScoresSummaryExport;
use App\Exports\EventRawScoresExport;
use App\Exports\EventSummaryExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        $cat = Eventcategory::all();

         return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function scores()
    {
       return view('grading.scores');
    }

    public function scoring()
    {
       return view('events.scoring');
    }


    public function createCategory()
    {
       return view('events.eventCategory');
    }


    public function createEvent()
    {
        $archers = Archer::all();
        $cat = Eventcategory::all();

       return view('events.create', compact('archers','cat'));

    }

    public function manage()
    {
        $archers = Event::orderBy('status', 'asc')->get();
        $categories = Eventcategory::all();

       return view('events.manage', compact('archers','categories'));

    }


   public function showEvent(Request $request, $id)
{
    $event = Event::where('id', $id)->first();

    $institutes = Archer::whereNotNull('institute')
        ->where('institute', '!=', '')
        ->distinct()
        ->orderBy('institute')
        ->pluck('institute');

    $filteredArcherIds = Archer::query()
        ->when($request->filled('institute'), function ($query) use ($request) {
            $query->where('institute', $request->institute);
        })
        ->when($request->filled('ageCategory'), function ($query) use ($request) {
            $query->where('ageCategory', $request->ageCategory);
        })
        ->pluck('id');

    $archers = Eventscore::where('event_id', $id)
        ->when($request->filled('institute') || $request->filled('ageCategory'), function ($query) use ($filteredArcherIds) {
            $query->whereIn('archer_id', $filteredArcherIds);
        })
        ->orderBy('totalScore', 'desc')
        ->orderBy('updatedBy', 'desc')
        ->orderBy('bowUsed', 'desc')
        ->get();

    $pples = Archer::all();

    $cat = $event->cat;

    if ($cat == '11') {
        $pples->each(function ($archer) {
            $gradepacho = $archer->currentGradingWeak;
            $gradeId = Gradingcard::where('level', '=', $gradepacho)->first();

            if ($archer->currentGradingWeak == 'CNG') {
                $x = 0;
            } elseif ($archer->currentGradingWeak == 'JNG') {
                $x = 9;
            } elseif ($archer->currentGradingWeak == 'ANG') {
                $x = 18;
            } else {
                $x = $gradeId ? $gradeId->id : 0;
            }

            $archer->gradingfor = Gradingcard::where('id', '>', $x)
                ->orderBy('id', 'asc')
                ->value('level');
        });
    } else {
        $pples->each(function ($archer) {
            $gradepacho = $archer->currentGradingDominant;
            $gradeId = Gradingcard::where('level', '=', $gradepacho)->first();
           // dd($gradeId);
            if ($archer->currentGradingDominant == 'CNG') {
                $x = 0;
            } elseif ($archer->currentGradingDominant == 'JNG') {
                $x = 9;
            } elseif ($archer->currentGradingDominant == 'ANG') {
                $x = 18;
            } else {
                $x = $gradeId ? $gradeId->id : 0;
            }

            $archer->gradingfor = Gradingcard::where('id', '>', $x)
                ->orderBy('id', 'asc')
                ->value('level');
        });
    }

    $category = Eventcategory::where('id', $cat)->first();
    $catname = $category->name;
    $scores = MinScores::all();

    return view('events.scoring', compact(
        'archers',
        'pples',
        'cat',
        'scores',
        'event',
        'category',
        'catname',
        'institutes'
    ));
}

    public function gradearcher($id)
    {

         $eventyacho = Eventscore::where('id', $id)->first();
         $archer = Archer::where('id', $eventyacho->archer_id )->first();
      
         $scores = MinScores::all();
         $event =  Event::where('id',  $eventyacho->event_id)->first();
         $categories = Eventcategory::where('id', $event->cat )->first();  

         $archergrading = Archergrading::where('archer_id', $eventyacho->archer_id)->where('event', $eventyacho->event_id)->first();

         if($archergrading){
          //dd($categories);
          $currentprof = $archer->currentProficiency;
          $name = $archergrading->name;
          $date = $archergrading->date;
          $bowused = $archergrading->bowUsed;
          $curentgrading = $archergrading->currentGrading;
          $age = $archergrading->ageCategory;
          $arrow = $archergrading->arrowsUsed;
          $gradefor = $archergrading->gradingfor; 
          $eventcategory = $categories->id; 
          $archer = $archergrading->archer_id;
          $event = $archergrading->event;

        //  dd($eventcategory);
        
          $figure =  GradingCard::where('level', $gradefor)->first();
          if($figure){
          $figure = $figure->score;  
          }else{
            $figure = null;  
          }

          $scores  = Eventcategoryscore::where('eventcategory_id', $eventcategory)->pluck('score');
          $category = Eventcategory::where('id', $eventcategory)->first();

          $isX = Eventcategoryscore::where('eventcategory_id', $eventcategory)
            ->orderBy('id', 'desc')
            ->value('isX');
 
         $lastrecord = Scorecard::where('event_id', $event)->where('archer_id', $archer)->latest()->first();
         $cumtotal =  $lastrecord->cumtotal ?? 0;
         $noofrounds = $lastrecord->round ?? 1;
         $currentPR =  $lastrecord->currentPR ?? 0;
         $requiredPR =  $lastrecord->requiredPR ?? 0;
         $remaining_rounds =  $category->rounds - $noofrounds;
        // dd($noofrounds,$category->rounds );
        if($lastrecord != null){
          if($noofrounds < $category->rounds){

            $currentRound = $noofrounds + 1;
           }else{
            $currentRound = $category->rounds;
           }
        }else{
          
          $currentRound =  1;
        }
         
        $eventcategory = $categories->name; 
         $currentPR = (string)$currentPR;
      //  dd($currentPR,$requiredPR,$figure);
         return view('events.finalgrading', compact('lastrecord','isX','currentprof','currentPR','requiredPR','cumtotal','currentRound','noofrounds','remaining_rounds','name','date','figure','bowused','curentgrading','age','arrow','gradefor','scores','category','eventcategory','archer','event'));

         }

       return view('events.grading', compact('archer','eventyacho','categories','scores','event'));
    }


    
    public function gradingdetail(Request $request)
    {
        
         $name = $request->name;
         $date = $request->date;
         $bowused = $request->bu;
         $curentgrading = $request->cg;
         $age = $request->ag;
         $arrow = $request->au;
         $gradefor = $request->gf; 
         $eventcategory = $request->ec; 
         $archer = $request->archer;
         $event = $request->event;

        // dd($eventcategory);

         $figure =  GradingCard::where('level', $gradefor)->pluck('score');  
         $scores  = Eventcategoryscore::where('eventcategory_id', $request->eventcategory_id)->pluck('score');
         $category = Eventcategory::where('id', $request->eventcategory_id)->first();

      //   dd($gradefor);    
        $lastrecord = Scorecard::where('event_id', $event)->where('archer_id', $archer)->latest()->first();
        $cumtotal =  $lastrecord->cumtotal ?? 0;
        $noofrounds = $lastrecord->round ?? 1;
        $currentPR =  $lastrecord->currentPR ?? 0;
        $requiredPR =  $lastrecord->requiredPR ?? 0;
        $remaining_rounds =  $category->rounds - $noofrounds;
        //dd($remaining_rounds);
        if($noofrounds < $category->rounds){
          $currentRound = $noofrounds + 1;
         }else{
          $currentRound = $category->rounds;
         }

         $currentPR = (string)$currentPR;
       //  dd($currentPR,$requiredPR,$figure);
        // dd($currentPR,$requiredPR,$figure);

       return view('events.finalgrading', compact('lastrecord','currentPR','requiredPR','cumtotal','currentRound','noofrounds','remaining_rounds','name','date','figure','bowused','curentgrading','age','arrow','gradefor','scores','category','eventcategory','archer','event'));
    }


   //after last round
    public function finalgradingdetail(Request $request)
    {
        //dd($request->all());
        $scores = $request->input('scores');
        $user = Auth::user()->id;
        $checkUser = Archergrading::where('archer_id',$request->archer)->where('event',$request->event)->first();
        $eventCat = Eventcategory::where('name', $request->eventcategory)->orwhere('id',$request->eventcategory)->first();
       // dd($eventCat);
        $currentPR = $request->total / $request->round;
        if( $eventCat->id == 1 || $eventCat->id == 11){
 
        $remaining_rounds = ($eventCat->rounds - $request->round) == 0 ? 1 : ($eventCat->rounds - $request->round);
        $requiredPR = ($request->figure - $request->total)/$remaining_rounds;
      
      }else{

        $requiredPR = 0;
      }

        if(!$checkUser){

         $grading = new Archergrading();
         $grading->event = $request->event;
         $grading->archer_id = $request->archer;
         $grading->name = $request->name;
         $grading->date = $request->date;
         $grading->bowUsed = $request->bowused;
         $grading->arrowsUsed = $request->arrow;
         $grading->ageCategory = $request->age;
         $grading->currentGrading = $request->curentgrading;
         $grading->gradingfor = $request->gradefor ?? 0;
         $grading->totalScore = $request->figure;
         $grading->withKhatrah = $request->has('khatrah') ? 1 : 0;
         $grading->arrowinhand = $request->has('timed') ? 1 : 0;
         $grading->timed = $request->has('inhand') ? 1 : 0;
         $grading->thumbring =$request->has('thumb') ? 1 : 0;
         $grading->scoredBy = $request->user;
         $grading->createdBy = $request->user;   
         $grading->save(); 

        }else{

          $grading = $checkUser;

        }
 
        if($request->event != '1'){
      //  dd( $request->event);
        $cat = Event::where('id', $request->event)->first();
        $highestvalue = Eventcategoryscore::where('eventcategory_id',$cat->cat)->get()->max('score');
        $eventscore = Eventscore::where('event_id', $request->event )->where('archer_id', $request->archer)->first();
        $count = $eventscore->bowUsed ? $eventscore->bowUsed : 0;

        }


       $round = (string) $request->input('round');

      // 2) Pull scores and X flags for just that round
      $scoresForRound = data_get($request->input('scores', []), $round, []);   // [arrowIndex => score]
      $isXPerRound    = data_get($request->input('isX', []),    $round, []);   // [arrowIndex => 0|1]

      // 3) Save each arrow's score, aligning isX by arrow index
      foreach ($scoresForRound as $arrowIndex => $score) {
          $scorec = Scorecard::create([
              'event_id'        => $request->event,
              'archer_id'       => $request->archer,
              'archergrading_id'=> $grading->id,
              'round'           => $round,
              'currentPR'       => $currentPR,
              'requiredPR'      => $requiredPR,

              // assuming 'arrow' column stores the score value for that arrow
              'arrow'           => (int) $score,

              // new: per-arrow X flag (defaults to 0 if missing/disabled)
              'isX'             => (int) ($isXPerRound[$arrowIndex] ?? 0),

              'roundtotal'      => $request->round_total,
              'cumtotal'        => $request->cum_total,
              'total'           => $request->total,
              'time'            => $request->time,
              'createdBy'       => $request->user,
          ]);

          if($request->event != '1' && $highestvalue == $score){
                 
            $count++;

          } 


         }


         $totalXs = Scorecard::where('event_id', $request->event )->where('archer_id', $request->archer)->where('archergrading_id','=', $grading->id)->where('isX','=', 1)->sum('isX');
       //  dd($totalXs);
         $eventscore = Eventscore::where('event_id', $request->event )->where('archer_id', $request->archer)->update([
        
          'status' => 1,
          'totalScore' => intval($request->total),
          'timed' => $request->round,
          'bowUsed' => $count,
          'thumbring' =>  $currentPR,
          'updatedBy' =>  $totalXs,
          'arrowinhand' => $requiredPR

        ]);
  

        if($request->gradefor &&  $eventCat->rounds == $request->round){

         if($request->total >= $request->figure){

         if($eventCat->id == 11){

          $updatearcher = Archer::where('id', $request->archer)->update([
         
            'currentGradingWeak' => $request->gradefor,

          ]);
          
         }else{

          $updatearcher = Archer::where('id', $request->archer)->update([
         
            'currentGradingDominant' => $request->gradefor,

          ]);

         }
             
             return redirect()->route('events.showEvent', ['id' => $request->event])->with('success', 'Archer passed and has been upgraded!');

         }else{

        //  dd('not done');
            return redirect()->route('events.showEvent', ['id' => $request->event])->with('error', 'Archer failed to score enough points be upgraded!');
      
         }

        }else{

          return redirect()->route('events.showEvent', ['id' => $request->event])->with('success', 'Archer scores updated!');

        }
           
 
       return view('events.finalgrading', compact('name'));

    }



    public function updateScore(Request $request){

      // dd($request->all());
       $name = $request->name;
       $round = $request->round;
       $cat = $request->cat;
       $archer = $request->archer;
       $event = $request->event;
       $round_total = $request->round_total;
       $time = $request->time;
       $total = $request->total;
       $currentPR = $request->current_pr;
       $archerDetail = Archer::where('id', $archer)->first();

       $eventCat = Eventcategory::where('id', $cat)->first();
       if($eventCat->id == 1 || $eventCat->id == 11){
 
        $remaining_rounds = ($eventCat->rounds - $request->round) == 0 ? 1 : ($eventCat->rounds - $request->round);
      $requiredPR = ($request->figure - $request->total)/$remaining_rounds;
    
    }else{

      $requiredPR = 0;
    }

       $highestvalue = Eventcategoryscore::where('eventcategory_id',$cat)->get()->max('score');
       $eventscore = Eventscore::where('event_id', $request->event )->where('archer_id', $request->archer)->first();
       $count = $eventscore->bowUsed ? $eventscore->bowUsed : 0;

       $scores = $request->input('scores');
   
     $getData = Scorecard::where('event_id', $request->event)
     ->where('archer_id', $request->archer)
     ->where('round', '!=', $request->round)
     ->get()
     ->unique('round')
     ->values();

     $totall = $getData->sum('roundtotal') + $round_total;

    // dd($getData->sum('roundtotal'),$totall);

      foreach ($scores[$request->round] as $arrowId => $scoreValue) {
      
      $scorec = Scorecard::where('id', $arrowId)->update([  
  
        'currentPR' => $currentPR,
        'requiredPR' => $requiredPR,
        'arrow' =>  $scoreValue,
        'roundtotal' => $round_total,
        'cumtotal' => $request->cum_total,
        'total' => $totall,
        'time' => $request->time,

      ]);
        

      if($request->event != '1' && $highestvalue == $round_total){
             
        $count++;

      }

     }
  
     if($cat == '1'){

      $currentgrading = GradingCard::where('level', $archerDetail->currentGradingDominant)->first();     
      $nextgrading = null;
      if ($currentgrading) {
          $nextgrading = GradingCard::where('id', '>', $currentgrading->id)->orderBy('id')->first();
      }

        $figure = $nextgrading->score ?? null;
        $gradefor = $nextgrading->level ?? null;

      }elseif($cat == '11'){

        $currentgrading = GradingCard::where('level', $archerDetail->currentGradingWeak)->first();     
        $nextgrading = null;
        if ($currentgrading) {
            $nextgrading = GradingCard::where('id', '>', $currentgrading->id)->orderBy('id')->first();
        }

          $figure = $nextgrading->score ?? null;
          $gradefor = $nextgrading->level ?? null;
          
      }else{

         $figure = null;
         $gradefor = null;

      }



      $eventscore = Eventscore::where('event_id', $request->event )->where('archer_id', $request->archer)->update([
        
        'status' => 1,
        'totalScore' => intval($totall),
        //'timed' => $request->round,
        'bowUsed' => $count,
        'thumbring' =>  $currentPR,
        'arrowinhand' => $requiredPR

      ]);

   $update = Scorecard::where('event_id', $request->event)->where('archer_id',$request->archer)->update([  'total' => $totall ]);

      if($cat == '1'){

        if($totall >= $figure){

        //  dd($totall,$figure,$gradefor);

         $updatearcher = Archer::where('id', $request->archer)->update([
        
           'currentGradingDominant' => $gradefor,

         ]);
            
            return redirect()->route('events.showEvent', ['id' => $request->event])->with('success', 'Archer passed and has been upgraded!');

        }else{

           return redirect()->route('events.showEvent', ['id' => $request->event])->with('error', 'Archer score updated!');
     
        }

       }elseif($cat == '11'){
        
        if($totall >= $figure){

          $updatearcher = Archer::where('id', $request->archer)->update([
         
            'currentGradingWeak' => $gradefor,

          ]);
             
             return redirect()->route('events.showEvent', ['id' => $request->event])->with('success', 'Archer passed and has been upgraded!');

         }else{

            return redirect()->route('events.showEvent', ['id' => $request->event])->with('error', 'Archer score updated!');
      
         }
       }else{

         return redirect()->route('events.showEvent', ['id' => $request->event])->with('success', 'Archer scores updated!');

       }
          


    }


    public function storeCategory(Request $request)
    {

        $user = Auth::user()->id;
       
        $archer = new Eventcategory();
        $archer->name = $request->name;
        $archer->desc = $request->desc;
        $archer->rounds = $request->rounds;
        $archer->arrows = $request->arrows;
        $archer->createdBy = $user;    
        $archer->save();

          $scores = $request->input('score');

          foreach ($scores as $index => $score) {
              $event = new Eventcategoryscore();
              $event->eventcategory_id = $archer->id;
              $event->score = $score;

              // Only update isX for the last score
              if ($index === array_key_last($scores)) {
                  $event->isX = $request->include_x;
              }

              $event->save();
          }
  
          if($archer){
          
            return back()->with('success', 'Category created successfully!');
          }
          return back()->with('error', 'Failed to create Event Category!');
         
    }



        public function editEventCategory2($id)
        {
            $category = Eventcategory::findOrFail($id);

            $scores = Eventcategoryscore::where('eventcategory_id', $id)
                ->orderBy('id', 'asc')
                ->get();

            return view('events.editCategory', compact('category', 'scores'));
        }



      public function updateEventCategory(Request $request, $id)
      {
          $category = Eventcategory::findOrFail($id);

          $category->name = $request->name;
          $category->desc = $request->desc;
          $category->rounds = $request->rounds;
          $category->arrows = $request->arrows;
          $category->save();

          $scores = $request->input('score', []);

          Eventcategoryscore::where('eventcategory_id', $id)->delete();

          foreach ($scores as $index => $score) {
              if ($score === null || $score === '') {
                  continue;
              }

              $eventScore = new Eventcategoryscore();
              $eventScore->eventcategory_id = $category->id;
              $eventScore->score = $score;

              $eventScore->isX = 0;

              if ($index === array_key_last($scores)) {
                  $eventScore->isX = $request->input('include_x', 0);
              }

              $eventScore->save();
          }

          return redirect()->back()->with('success', 'Event Category updated successfully!');
      }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;
       
          $archer = new MinScores();
          $archer->name = $request->name;
          $archer->level = $request->level;
          $archer->distance = $request->distance;
          $archer->cub = $request->cub;
          $archer->junior = $request->junior;
          $archer->adult = $request->adult;
          $archer->stripeColor = $request->color;
          $archer->createdBy = $user;    

          $archer->save();
  
          if($archer){
          
            return back()->with('success', 'Scores created successfully!');
          }
           return back()->with('error', 'Failed to create scores!');
         
    }


    public function eventStore(Request $request)
    {


        $user = Auth::user()->id;
       
        $archer = new Event();
        $archer->name = $request->name;
        $archer->cat = $request->cat;
        $archer->doe = $request->doe;
        $archer->createdBy = $user;    
        $archer->save();


        $truck_ids = $request->input('selected_archers');
     
       // dd($truck_ids);

        foreach($truck_ids as $key => $n ) {

            $arrData[] = array(

                $companyrole = Eventscore::create([

                    'archer_id' => $truck_ids[$key],
                    'event_id' => $archer->id ,
                    'createdBy' => $user
                    
                ]),

            );

            }
  
          if($archer){

         // dd('done');
          
              return back()->with('success', 'Event created successfully!');
          }
            return back()->with('error', 'Failed to create Event!');
         
    }

    /**
     * Display the specified resource.
     */
    public function indexeventCategory()
    {
      $categories = Eventcategory::all();

      return view('events.indexeventCategory', compact('categories'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function indexevent()
    {
      $events = Event::latest('doe')->get(); 
      $categories = Eventcategory::all();
      
      return view('events.indexevent', compact('events','categories'));
    }


    public function endevent($id)
    {
    
        $EndEvent = Event::where('id', $id)->update([
           'status' => 1
        ]);
  
        if( $EndEvent){
        return back()->with('success', 'Event Ended successfully!');
        }else{
        return back()->with('error', 'Failed to End Event!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function archerDetails(Request $request)
    {
    
      $archer = Archer::where('id', $request->archer )->first();
      $currentprof = $archer->currentProficiency;
      $scores = MinScores::all();
      $event =  Event::where('id',  $request->event)->first();
      $categories = Eventcategory::where('id', $request->cat )->first();  
     
      if($categories->name == 'Grading'){

        $currentgrading = GradingCard::where('level', $archer->currentGradingDominant)->first();     
        $nextgrading = null;
        if ($currentgrading) {

          if($archer->currentGradingDominant == 'CNG'){
            $x = 0;
          }elseif($archer->currentGradingDominant == 'JNG'){
            $x = 9;
          }elseif($archer->currentGradingDominant == 'ANG'){
            $x = 18;
          }else{
            $x = $currentgrading->id;
          }
            $nextgrading = GradingCard::where('id', '>', $x)->orderBy('id')->first();
        }

          $figure = $nextgrading->score ?? null;
          $gradefor = $nextgrading->level ?? null;

        }elseif($categories->name == 'Non Dominant Hand'){

          $currentgrading = GradingCard::where('level', $archer->currentGradingWeak)->first();     
          $nextgrading = null;
          if ($currentgrading) {

            if($archer->currentGradingWeak == 'CNG'){
              $x = 0;
            }elseif($archer->currentGradingWeak == 'JNG'){
              $x = 9;
            }elseif($archer->currentGradingWeak == 'ANG'){
              $x = 18;
            }else{
              $x = $currentgrading->id;
            }
              $nextgrading = GradingCard::where('id', '>', $x)->orderBy('id')->first();
          }

            $figure = $nextgrading->score ?? null;
            $gradefor = $nextgrading->level ?? null;

        }else{

         $figure = null;
         $gradefor = null;

        }


       $name = $archer->name;
       $date = $event->doe;
       $bowused = $request->bowUsed;
       $curentgrading = $archer->currentGradingDominant;
       $age = $archer->ageCategory;
       $arrow = $request->arrowUsed;
       //$gradefor = $request->gf; 
       $eventcategory = $categories->name; 
       $archer = $request->archer;
       $event = $request->event;
      
     
       $scores  = Eventcategoryscore::where('eventcategory_id', $request->cat )->pluck('score');
       $isX = Eventcategoryscore::where('eventcategory_id', $request->cat)
            ->orderBy('id', 'desc')
            ->value('isX');
       $category = Eventcategory::where('id', $request->cat )->first();

      $lastrecord = Scorecard::where('event_id', $event)->where('archer_id', $archer)->latest()->first();
      $cumtotal =  $lastrecord->cumtotal ?? 0;
      $noofrounds = $lastrecord->round ?? 1;
      $remaining_rounds =  $category->rounds - $noofrounds;
      // dd($noofrounds, $category->rounds );
      if($lastrecord != null){
      if($noofrounds < $category->rounds){

        $currentRound = $noofrounds + 1;
       }else{
        $currentRound = $category->rounds;
       }
    }else{
      
      $currentRound =  1;
    }
     
       return view('events.finalgrading', compact('lastrecord','isX','currentRound','currentprof','cumtotal','noofrounds','remaining_rounds','name','date','figure','bowused','curentgrading','age','arrow','gradefor','scores','category','eventcategory','archer','event'));
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function certificate(string $id)
    {
      //  dd($id);
        $eventscore = Eventscore::where('id',$id)->first();
        $archer = Archergrading::where('archer_id',$eventscore->archer_id)->where('event',$eventscore->event_id)->first();
        //dd($archer);

        $data = [
          'archer' => (object)[
              'name'     => $archer->name ?? 'Unknown',
              'event'    => $archer->gradingfor ?? 'Unknown Event',
              'score'    => $eventscore->totalScore ?? '0',
              'position' => $archer->id ?? 'N/A',
          ]
      ];
  
      $pdf = Pdf::loadView('pdf.certificate', $data)->setPaper('a4', 'landscape');
  
      return $pdf->download('archer_scorecard.pdf');
    }


    public function editeventCategory($id) {
    
      $post = Eventcategory::findOrFail($id);
      $post->delete();

      return redirect()->back()->with('success', 'Category deleted successfully.');


    }

       

    public function editevent($id) {
    
    // dd($id);

     $event = Event::where('id', $id)->first();
     if($event->status == 1){

      return redirect()->back()->with('error', 'Event ended and cannot be updated.');
     }
     $archers = Eventscore::where('event_id', $id)->get();
     $allarchers = Archer::all();
     $cat = Eventcategory::where('id', $event->cat)->first();
     $cats = Eventcategory::all();
     //dd($event,$archers, $allarchers);

     return view('events.editEvent', compact('event','archers','allarchers','cat','cats'));



    }



public function update(Request $request, string $id)
{
    $event = Event::findOrFail($id);

    $event->update([
        'name' => $request->name,
        'doe'  => $request->doe,
        'cat'  => $request->cat,
    ]);

    $selectedArchers = $request->input('selected_archers', []);
  // dd($selectedArchers);
    // Remove archers that were unchecked
    Eventscore::where('event_id', $id)
        ->whereNotIn('archer_id', $selectedArchers)
        ->delete();

    // Add newly checked archers
    foreach ($selectedArchers as $archerId) {
        Eventscore::firstOrCreate([
            'event_id'  => $id,
            'archer_id' => $archerId,
        ]);
    }

    return redirect()->back()->with('success', 'Event updated successfully.');
}


    public function deletearcher($archer_id, $event_id){

  
      $archers = Eventscore::where('event_id', $event_id)->where('archer_id', $archer_id)->delete();

      return redirect()->back()->with('success', 'Archer removed successfully.');

    }


    public function editScore(Request $request){

      $getData = Scorecard::where('event_id',$request->event)->where('archer_id',$request->archer)->where('round',$request->round)->get();
    // dd($getData->Count());

    if($getData->Count() == 0 ){
      return redirect()->back()->with('error', 'Selected Round is yet to be caputured!');   
    }

 
      $roundScores = [];
      foreach ($getData as $record) {
    $roundScores[$record->arrow] = $record->score;
    }

      $round = $request->round;
      $cat = $request->cat;
      $category = Eventcategory::where('id', $cat)->first();
      $possibleScores = Eventcategoryscore::where('eventcategory_id', $cat)->get();
      $archer = $request->archer;
      $event = $request->event;

      $name = Archer::where('id', $archer)->first();
      $name = $name->name;

  
      return view('events.editScore', compact('getData','archer','round','category','possibleScores','cat','event','name','roundScores'));

    }


     public function rawscores(string $id){

         return Excel::download(
        new EventRawScoresExport((int) $id),
        "raw_scores_summary_{$id}.xlsx"
    );

    }


       public function scoresummary(string $id){

        return Excel::download(new EventSummaryExport($id), "event_summary_{$id}.xlsx");
     }


       public function supersummary(string $id){


       // dd($id);
     //  $eventScore = Eventscore::where('event_id',$id)->get();
      // dd( $eventScore);

     $fileName = "event_scores_summary_{$id}.xlsx";
    return Excel::download(new EventScoresSummaryExport($id), $fileName);

    }


}
