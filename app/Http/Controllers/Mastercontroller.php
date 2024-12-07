<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Location;
class Mastercontroller extends Controller
{
    //
    public function locations(){
        $data['users'] = Auth::user();
        $data['locations'] = Location::where('status','Active')->get();
        return view('Admin.locations',$data);
    }

    public function save_location(Request $request){
        $request->validate([
            'location'=>'required',
            ]);

            $loc = new Location();
            $loc->locationname = $request->input('location');
            $loc->status       = $request->input('status');
            $loc->save();
            return redirect(route('locations'));
    }
    public function delete_location($id){
        $record = Location::find($id);
        $record->delete();
        return redirect(route('locations'));
    }
}
