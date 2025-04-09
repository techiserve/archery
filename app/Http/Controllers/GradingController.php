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
use App\Models\Round8;
use App\Models\Round9;
use App\Models\Eventscore;
use App\Models\Scorecard;
use Illuminate\Support\Facades\Auth;

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
        $archers = Event::all();
        $categories = Eventcategory::all();

       return view('events.manage', compact('archers','categories'));

    }


    public function showEvent($id)
    {
         $event = Event::where('id',$id)->first();

         if($event->status == 1){
          
           return back()->with('error', 'This event has been Ended!');
         }

        $archers = Eventscore::where('event_id', $id)->get();
        $pples = archer::all();
        $cat = $event->cat;
        $scores = MinScores::all();
  

       return view('events.scoring', compact('archers','pples','cat','scores'));
    }


    public function gradearcher($id)
    {

         $eventyacho = Eventscore::where('id', $id)->first();
         $archer = Archer::where('id', $eventyacho->archer_id )->first();
      
         $scores = MinScores::all();
         $event =  Event::where('id',  $eventyacho->event_id)->first();
         $categories = Eventcategory::where('id', $event->cat )->first();  
       //  dd($categories);

         $archergrading = Archergrading::where('archer_id', $eventyacho->archer_id)->where('event', $eventyacho->event_id)->first();

         if($archergrading){
       
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
 
          $figure = MinScores::where('level' ,$gradefor)->pluck($age)->first();
          $scores  = Eventcategoryscore::where('eventcategory_id', $eventcategory)->pluck('score');
          $category = Eventcategory::where('id', $eventcategory)->first();
 
         $lastrecord = Scorecard::where('event_id', $event)->where('archer_id', $archer)->latest()->first();
         $cumtotal =  $lastrecord->cumtotal ?? 0;
         $noofrounds = $lastrecord->round ?? 1;
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
         
         
 
         return view('events.finalgrading', compact('lastrecord','cumtotal','currentRound','noofrounds','remaining_rounds','name','date','figure','bowused','curentgrading','age','arrow','gradefor','scores','category','eventcategory','archer','event'));

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

         $figure = MinScores::where('level' ,$gradefor)->pluck($age)->first();
         $scores  = Eventcategoryscore::where('eventcategory_id', $request->eventcategory_id)->pluck('score');
         $category = Eventcategory::where('id', $request->eventcategory_id)->first();

      //   dd($gradefor);    
        $lastrecord = Scorecard::where('event_id', $event)->where('archer_id', $archer)->latest()->first();
        $cumtotal =  $lastrecord->cumtotal ?? 0;
        $noofrounds = $lastrecord->round ?? 1;
        $remaining_rounds =  $category->rounds - $noofrounds;
        //dd($remaining_rounds);
        if($noofrounds < $category->rounds){
          $currentRound = $noofrounds + 1;
         }else{
          $currentRound = $category->rounds;
         }

       return view('events.finalgrading', compact('lastrecord','cumtotal','currentRound','noofrounds','remaining_rounds','name','date','figure','bowused','curentgrading','age','arrow','gradefor','scores','category','eventcategory','archer','event'));
    }



    public function finalgradingdetail(Request $request)
    {
       // dd($request->all());
        $scores = $request->input('scores');
       // dd($scores);

         $user = Auth::user()->id;

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


         foreach($scores[$request->round] as $score){
          
          $score = Scorecard::create([
            
            'event_id' => $request->event,
            'archer_id' => $request->archer,
            'archergrading_id' => $grading->id ,
            'round' => $request->round,
            'currentPR' => $request->current_pr,
            'requiredPR' => $request->required_pr,
            'arrow' =>  $score,
            'roundtotal' => $request->round_total,
            'cumtotal' => $request->cum_total,
            'total' => $request->total,
            'time' => $request->time,
            'createdBy' => $request->user,

          ]);


         }

         $eventscore = Eventscore::where('event_id', $request->event )->where('archer_id', $request->archer)->update([
        
          'status' => 1
        ]);
  
      

        if($request->gradefor){

         if($request->total >= $request->figure){

          $updatearcher = Archer::where('id', $request->archer)->update([
         
            'currentGrading' => $request->gradefor,

          ]);
             
             return redirect()->route('events.showEvent', ['id' => $request->event])->with('success', 'Archer passed and has been upgraded!');

         }else{

        //  dd('not done');
            return redirect()->route('events.showEvent', ['id' => $request->event])->with('error', 'Archer failed to be upgraded!');
      
         }

        }else{

          return redirect()->route('events.showEvent', ['id' => $request->event])->with('success', 'Archer scores updated!');

        }
           
 
       return view('events.finalgrading', compact('name'));

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

       foreach ($scores as $score) {
         
        $event = new Eventcategoryscore();
        $event->eventcategory_id = $archer->id;
        $event->score = $score;
        $event->save();
       
       }
  
          if($archer){
          
            return back()->with('success', 'Category created successfully!');
          }
          return back()->with('error', 'Failed to create Event Category!');
         
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
      $events = Event::all();
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
       // dd($request->all());
      
      //  dd($categories);
     // $eventyacho = Eventscore::where('id', $id)->first();
      $archer = Archer::where('id', $request->archer )->first();
   
      $scores = MinScores::all();
      $event =  Event::where('id',  $request->event)->first();
      $categories = Eventcategory::where('id', $request->cat )->first();  
     
       $name = $archer->name;
       $date = $event->doe;
       $bowused = $request->bowUsed;
       $curentgrading = $archer->currentGradingDominant;
       $age = $archer->ageCategory;
       $arrow = $request->arrowUsed;
       $gradefor = $request->gf; 
       $eventcategory = $categories->name; 
       $archer = $request->archer;
       $event = $request->event;

      // dd($gradefor);
        if($gradefor != '0'){
          $figure = MinScores::where('level' ,$gradefor)->pluck($age)->first();
        }else{
           $figure = null;
        }

     
      $scores  = Eventcategoryscore::where('eventcategory_id', $request->cat )->pluck('score');
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
     
       return view('events.finalgrading', compact('lastrecord','currentRound','cumtotal','noofrounds','remaining_rounds','name','date','figure','bowused','curentgrading','age','arrow','gradefor','scores','category','eventcategory','archer','event'));


    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
