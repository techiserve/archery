<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Archer;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AcheryController extends Controller
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
