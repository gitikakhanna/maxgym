<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Packages;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainer = DB::table("trainers")->get();
        return view("trainer",compact('trainer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function storeAction($data)
    {
       
        DB::table('trainers')->insert([
            'name' => $data->name,
            'email' => $data->email,
            'address' => $data->address,
            'contact' => $data->contact,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

       

   }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'address' => 'required',
            'contact' => 'required|numeric',
            'email' => 'unique:trainers,email'
            
           
        ]);
        
        $this->storeAction($request);
        $request->session()->flash('flashSuccess', 'New Trainer added successfully.'); 
       
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        DB::table('trainers')->where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'contact' => $request->contact,
           
            'updated_at' => now(),
        ]);
        $request->session()->flash('flashSuccess', 'Trainer updated successfully.');    
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
      public function delete($id)
    {
        DB::table('trainers')->where('id', $id)->delete();
        return redirect()->back();
    }
    public function destroy($id)
    {
        //
    }
}
