<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverDocument;
use App\Models\DriversDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\CpvRequirement;
use Carbon\Carbon;
use Validator;

// use Illuminate\Support\Facades\Validator;

class DriverDocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {


        if ($request->has('search') && $request->search != '' && $request->selected_search == 'title') {
            $search = $request->input('search');
            $document = DB::table('admin_documents')->where('admin_documents.title', 'LIKE', '%' . $search . '%')
            ->paginate(10);
        }
        else{
            $document = DriverDocument::paginate(10);
        }



        return view("administration_tools.driverDocument.index")->with("document", $document);
    }

    public function create()
    {
        return view("administration_tools.driverDocument.create");
    }

    public function storeDocument(Request $request)
    {

        $validator = Validator::make($request->all(), $rules = [
            'title' => 'required',
        ], $messages = [
            'title.required' => 'The Title field is required!',

        ]);

        if ($validator->fails()) {
            return redirect('driver_document/create')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $document = new DriverDocument;
        $document->title = $request->input('title');
        if ($request->input('status')) {
            $document->is_enabled = "Yes";
        } else {
            $document->is_enabled = "No";
        }

		Driver::where('id', '!=', '0')->update(['is_verified' => 0]);

        $document->save();
        return redirect('administration_tools/driver_document');

    }

    public function edit($id)
    {

        $document = DriverDocument::where('id', "=", $id)->first();
        return view("administration_tools.driverDocument.edit")->with("document", $document);
    }


    public function documentUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $rules = [
            'title' => 'required',

        ], $messages = [
            'title.required' => 'The Title field is required!',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }

        $title = $request->input('title');

        if ($request->input('status')) {
            $status = "Yes";
        } else {
            $status = "No";
        }


        $document = DriverDocument::find($id);
        if ($document) {
            $document->title = $title;
            $document->is_enabled = $status;
            $document->save();
        }

        return redirect('administration_tools/driver_document');
    }

    public function deleteDocument($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {


                for ($i = 0; $i < count($id); $i++) {
                   DriversDocuments::where('document_id',$id[$i])->delete();
                    $user = DriverDocument::find($id[$i]);
                    $user->delete();
                }

            } else {
                DriversDocuments::where('document_id',$id)->delete();
                $user = DriverDocument::find($id);
                $user->delete();
            }


        }

        return redirect()->back();
    }

public function toggalSwitch(Request $request){
        $ischeck=$request->input('ischeck');
        $id=$request->input('id');
        $document = DriverDocument::find($id);

        if($ischeck=="true"){
            $document->is_enabled = 'Yes';
        }else{
            $document->is_enabled = 'No';
        }
          $document->save();

}
public function getcpvemail( $id){

    $driver = Driver::where('id',$id)->first();
    if(!empty($driver)){
        $cpvs = CpvRequirement::where('driver_id',$id)->
                            where('driver_fatigue','1')-> where('maintaing_vehicle','1')-> where('emergency_management','1')
                            ->where('driver_behave','1')->where('medical_fitness','1')->where('covid_19','1')
                            ->where('notifiable_incidents','1')-> where('notifiable_incidents','1')->where('notifiable_incidents','1')
                            ->where('updated_at', '>', Carbon::now()->subMonths(6))
                            ->first();

        $to = $driver->email;
        $adto = 'info@callataxi.au';
        $subject = "CPV Requirement Update";
        $message = '
                    <body style="margin:100px; background: #f8f8f8; ">
                        <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                            <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px; background: #fff;">
                                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: top; padding-bottom:30px;" align="center">
                                                <img src="http://projets.hevenbf.com/yellow%20taxi/webservices/images/logo_taxijaune.jpg" alt="logo Spark" style="border:none" width="15%">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="padding: 40px; background: #fff;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                        <tbody>
                                            <tr>
                                             
                                                <h3>CPV Requirement Update </h3>
                                                <p> Mr./Mrs '.$driver->nom.' '.$driver->prenom.'</p>
                                                <b><u>Details of CPV:</u></b><br>
                                              
                                              
                                                <br/>
                                                <p>Good continuation and see you soon !</p>
                                                <p>Regards </p>
                                                <p>Hail A Taxi </p>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </body>
                    ';
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\b";
        $headers .= 'From: Taxi Jaune' . "\r\n";
        mail($to,$subject,$message,$headers);     
        mail($adto,$subject,$message,$headers);              
        
        return redirect()->back();
    }
    
}
}
