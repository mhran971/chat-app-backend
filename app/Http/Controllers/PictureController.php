<?php

namespace App\Http\Controllers;
use App\Models\picture;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;


class PictureController extends Controller
{

    /**
     * Store a newly created resource in storage.

     */
    public function store(Request $request)
    {
		if(auth()->user()->picture)
		{
			$picture= auth()->user()->picture;
			$picture->path=$request['file']->storeAs('images/users', $request['file']->getClientOriginalName(), 'public');
			$picture->save();
		}else
		{
			$picture= Picture::create([
			'name' => $request['file']->getClientOriginalName(),
			'path'=>$request['file']->storeAs('images/users', $request['file']->getClientOriginalName(), 'public'),
			'extension'=>'png',
			'user_id'=> auth()->id()
		]);
	}
		return new UserResource($picture->user);
	}

	function download(){
		$picture = Picture::first();

			return response()->download(storage_path('app/public/'.$picture->path));

	}

    /**
     * Display the specified resource.
     *

     */
    public function show(Picture $picture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *

     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.

     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *

     */
    public function destroy(Picture $picture)
    {
        //
    }
}
