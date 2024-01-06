<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $tax = DB::table('tj_tax')
            ->paginate(10);

        return view("administration_tools.tax.index")->with("Tax", $tax);
    }

    public function edit($id)
    {

        $Tax = Tax::find($id);
        return view("tax.edit")->with('Tax', $Tax);

    }

    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        $value = $request->input('value');
        $type = $request->input('type');
        $enabled = $request->input('enabled');
        $modifier = date('Y-m-d H:i:s');
        $Tax = Tax::find($id);

        if($enabled == "on"){
            $enabled = "yes";
        }else{
            $enabled = "no";
        }
        if ($Tax) {
            $Tax->libelle = $name;
            $Tax->value = $value;
            $Tax->type = $type;
            $Tax->statut = $enabled;
            $Tax->modifier = $modifier;
            $Tax->save();


            return redirect()->back();
        }
    }

    public function show($id)
    {

        $Tax = Tax::find($id);
        return view("administration_tools.tax.show")->with('Tax', $Tax);

    }

    public function changeStatus(Request $request, $id)
    {
        $Tax = Tax::find($id);
        if ($Tax->statut == 'no') {
            $Tax->statut = 'yes';
            $comm=DB::table('tj_tax')->where('id','!=',$id)->update(['statut'=>'no']);
        }  else {
            $Tax->statut = 'no';
            $comm=DB::table('tj_tax')->where('id','!=',$id)->update(['statut'=>'yes']);
        }


        $Tax->save();
        return redirect()->back();


    }

    public function searchTax(Request $request)
    {
        if ($request->has('search') && $request->search != '' && $request->selected_search == 'Name') {
            $search = $request->input('search');
            $Tax=DB::table('tj_tax')
                ->select('tj_tax.*')
                ->where('tj_tax.libelle','LIKE','%' . $search . '%')
                ->paginate(10);

        } else if ($request->has('search') && $request->search != '' && $request->selected_search == 'Type') {
            $search = $request->input('search');
            $Tax=DB::table('tj_tax')
                ->select('tj_tax.*')
                ->where('tj_tax.type','LIKE','%' . $search . '%')
                ->paginate(10);
        } else {
            $Tax=DB::table('tj_tax')
                ->select('tj_tax.*')
                ->paginate(10);
        }
        return view('administration_tools.tax.index')->with("Tax",$Tax);
    }
    public function toggalSwitch(Request $request){
            $ischeck=$request->input('ischeck');
            $id=$request->input('id');
            $tax = Tax::find($id);

            if($ischeck=="true"){
              $tax->statut = 'yes';
            }else{
              $tax->statut = 'no';
            }
              $tax->save();

    }
}
