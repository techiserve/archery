<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\MinScores;
use App\Models\Archer;
use App\Models\Archergrading;
use App\Models\Eventcategory;
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
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
       // $cat = Eventcategory::all();

       return view('events.manage', compact('archers'));

    }


    public function showEvent($id)
    {
    
        $archers = Eventscore::where('event_id', $id)->get();
        $pples = archer::all();
        // $archers = DB::table('eventscores')
        // ->join('archers', 'eventscores.archer_id', '=', $id)
        // ->get();

       // dd($archers);

       return view('events.scoring', compact('archers','pples'));
    }


    public function gradearcher($id)
    {

         $eventyacho = Eventscore::where('id', $id)->first();
         $archer = Archer::where('id', $eventyacho->archer_id )->first();
         $categories = Eventcategory::all();
         $scores = MinScores::all();
      

       return view('events.grading', compact('archer','eventyacho','categories','scores'));
    }


    
    public function gradingdetail(Request $request)
    {
        // dd($request->all());
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

         $figure = MinScores::where('level' ,$gradefor)->pluck($age)->first();
 

       return view('events.finalgrading', compact('name','date','figure','bowused','curentgrading','age','arrow','gradefor','eventcategory','archer','event'));
    }



    public function finalgradingdetail(Request $request)
    {
       // dd($request->all());
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
         $grading->gradingfor = $request->gradefor;
         $grading->totalScore = $request->figure;
         $grading->scoredBy = $request->user;
         $grading->createdBy = $request->user;   
         $grading->save(); 

        // dd($grading);

         $round1 = new Round1();
         $round1->archergrading_id = $grading->id;
         $round1->event_id = $request->event;
         $round1->archer_id = $request->archer;
         $round1->arrow1 = $request->field11;
         $round1->arrow2 = $request->field12;
         $round1->arrow3 = $request->field13;
         $round1->arrow4 = $request->field14;
         $round1->arrow5 = $request->field15;
         $round1->arrow6 = $request->field16;
         $round1->roundtotal = $request->total;
         $round1->cumtotal = $request->cumtotalfirst;
         $round1->time = $request->time1; 
         $round1->createdBy = $user;    
         $round1->save(); 

         $round2 = new Round2();
         $round2->event_id = $request->event;
         $round2->archer_id = $request->archer;
         $round2->archergrading_id = $grading->id;
         $round2->arrow1 = $request->field21;
         $round2->arrow2 = $request->field22;
         $round2->arrow3 = $request->field23;
         $round2->arrow4 = $request->field24;
         $round2->arrow5 = $request->field25;
         $round2->arrow6 = $request->field26;
         $round2->roundtotal = $request->total2;
         $round2->cumtotal = $request->cumtotal2;
         $round2->time = $request->time2; 
         $round2->createdBy = $user;    
         $round2->save();

         $round3 = new Round3();
         $round3->event_id = $request->event;
         $round3->archer_id = $request->archer;
         $round3->archergrading_id = $grading->id;
         $round3->arrow1 = $request->field31;
         $round3->arrow2 = $request->field32;
         $round3->arrow3 = $request->field33;
         $round3->arrow4 = $request->field34;
         $round3->arrow5 = $request->field35;
         $round3->arrow6 = $request->field36;
         $round3->roundtotal = $request->total3;
         $round3->cumtotal = $request->cumtotal3;
         $round3->time = $request->time3; 
         $round3->createdBy = $user;    
         $round3->save();

         $round4 = new Round4();
         $round4->event_id = $request->event;
         $round4->archer_id = $request->archer;
         $round4->archergrading_id = $grading->id;
         $round4->arrow1 = $request->field41;
         $round4->arrow2 = $request->field42;
         $round4->arrow3 = $request->field43;
         $round4->arrow4 = $request->field44;
         $round4->arrow5 = $request->field45;
         $round4->arrow6 = $request->field46;
         $round4->roundtotal = $request->total4;
         $round4->cumtotal = $request->cumtotal4;
         $round4->time = $request->time4; 
         $round4->createdBy = $user;    
         $round4->save();

         $round5 = new Round5();
         $round5->event_id = $request->event;
         $round5->archer_id = $request->archer;
         $round5->archergrading_id = $grading->id;
         $round5->arrow1 = $request->field51;
         $round5->arrow2 = $request->field52;
         $round5->arrow3 = $request->field53;
         $round5->arrow4 = $request->field54;
         $round5->arrow5 = $request->field55;
         $round5->arrow6 = $request->field56;
         $round5->roundtotal = $request->total5;
         $round5->cumtotal = $request->cumtotal5;
         $round5->time = $request->time5; 
         $round5->createdBy = $user;    
         $round5->save();

         $round6 = new Round6();
         $round6->event_id = $request->event;
         $round6->archer_id = $request->archer;
         $round6->archergrading_id = $grading->id;
         $round6->arrow1 = $request->field61;
         $round6->arrow2 = $request->field62;
         $round6->arrow3 = $request->field63;
         $round6->arrow4 = $request->field64;
         $round6->arrow5 = $request->field65;
         $round6->arrow6 = $request->field66;
         $round6->roundtotal = $request->total6;
         $round6->cumtotal = $request->cumtotal6;
         $round6->time = $request->time6; 
         $round6->createdBy = $user;    
         $round6->save();

         $round7 = new Round7();
         $round7->event_id = $request->event;
         $round7->archer_id = $request->archer;
         $round7->archergrading_id = $grading->id;
         $round7->arrow1 = $request->field71;
         $round7->arrow2 = $request->field72;
         $round7->arrow3 = $request->field73;
         $round7->arrow4 = $request->field74;
         $round7->arrow5 = $request->field75;
         $round7->arrow6 = $request->field76;
         $round7->roundtotal = $request->total7;
         $round7->cumtotal = $request->cumtotal7;
         $round7->time = $request->time7; 
         $round7->createdBy = $user;    
         $round7->save();

         $round8 = new Round8();
         $round8->event_id = $request->event;
         $round8->archer_id = $request->archer;
         $round8->archergrading_id = $grading->id;
         $round8->arrow1 = $request->field81;
         $round8->arrow2 = $request->field82;
         $round8->arrow3 = $request->field83;
         $round8->arrow4 = $request->field84;
         $round8->arrow5 = $request->field85;
         $round8->arrow6 = $request->field86;
         $round8->roundtotal = $request->total8;
         $round8->cumtotal = $request->cumtotal8;
         $round8->time = $request->time8; 
         $round8->createdBy = $user;    
         $round8->save();

         $round9 = new Round9();
         $round9->event_id = $request->event;
         $round9->archer_id = $request->archer;
         $round9->archergrading_id = $grading->id;
         $round9->arrow1 = $request->field91;
         $round9->arrow2 = $request->field92;
         $round9->arrow3 = $request->field93;
         $round9->arrow4 = $request->field94;
         $round9->arrow5 = $request->field95;
         $round9->arrow6 = $request->field96;
         $round9->roundtotal = $request->total9;
         $round9->cumtotal = $request->cumtotal9;
         $round9->time = $request->time9; 
         $round9->grandtotal = $request->grandtotal; 
         $round9->createdBy = $user;    
         $round9->save();
         

         if($request->grandtotal >= $request->figure){

          $updatearcher = Archer::where('id', $request->archer)->update([
         
            'currentGrading' => $request->gradefor,

          ]);
             
             return redirect()->route('events.showEvent', ['id' => $request->event])->with('success', 'Archer passed and has been upgraded!');

         }else{

            return back()->with('error', 'Archer! failed to be upgraded');
      
         }

      
        
 
       return view('events.finalgrading', compact('name'));

    }



    public function storeCategory(Request $request)
    {
        $user = Auth::user()->id;
       
        $archer = new Eventcategory();
        $archer->name = $request->name;
        $archer->desc = $request->desc;
        $archer->score1 = $request->score1;
        $archer->score2 = $request->score2;
        $archer->score3 = $request->score3;
        $archer->createdBy = $user;    
        $archer->save();

      
  
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

      //  dd($request->all());

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
    public function show(string $id)
    {
        //
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
