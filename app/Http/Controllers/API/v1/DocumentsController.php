<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\DriversDocuments;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Driver;

class DocumentsController extends Controller
{

    public function __construct()
    {
        $this->limit = 20;
    }

    public function getData(Request $request)
    {

        $admin_documents = DB::table('admin_documents')->where('is_enabled','Yes')->get();

        if (!empty($admin_documents)) {
            $response['success'] = 'success';
            $response['error'] = null;
            $response['message'] = 'successfully';
            $response['data'] = $admin_documents;
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Failed to fetch data';
            $response['message'] = 'successfully';
        }
        return response()->json($response);


    }

    public function addDriverDocuments(Request $request)
    {

        $driver_id = $request->get('driver_id');

		$documents = $request->get('documents');

		$attachment = $request->file('attachment');

		if (empty($driver_id) || $driver_id == 0) {

            $response['success'] = 'Failed';
            $response['error'] = 'Driver Not Found';

		} else if (empty($documents)) {

		    $response['success'] = 'Failed';
            $response['error'] = 'Documents Not Found';

		} else if (empty($attachment)) {

            $response['success'] = 'Failed';
            $response['error'] = 'Attachment Not Found';

		} else {

            $documents = json_decode($documents);

            foreach ($documents as $data) {

                $document_id = $data->document_id;

                $attachmentIndex = $data->attachmentIndex;

                if ($attachmentIndex != '') {

                    $image_path = $attachment[$attachmentIndex];

                    $extenstion = $image_path->getClientOriginalExtension();

                    $document_name = DB::table('admin_documents')->where('id', $document_id)->first();

                    $filename = str_replace(' ','_',$document_name->title) . '_' . time() . '.' . $extenstion;

                   $image_path->move('assets/images/driver/documents/', $filename);

                    if (file_exists('assets/images/driver/documents' . '/' . $filename)) {

                        /*$image_path = asset('assets/images/driver/documents') . '/' . $filename;
                        DB::insert("INSERT INTO driver_document(driver_id, document_id, document_path, document_status, created_at) VALUES('" . $driver_id . "','" . $document_id . "','" . $filename . "', 'Pending','" . $created_at . "')");
						$id = DB::getPdo()->lastInsertId();*/

						$driver_document = new DriversDocuments;
						$driver_document->driver_id = $driver_id;
						$driver_document->document_id = $document_id;
						$driver_document->document_path = $filename;
						$driver_document->document_status = 'Pending';
						$driver_document->save();

                        if($driver_document->id > 0) {
                            $response['success'] = 'success';
                            $response['error'] = null;
                            $response['message'] = 'Documents Add Successfully';
                        } else {
                            $response['success'] = 'Failed';
                            $response['error'] = 'Documents Not Add';
                        }
                    } else {
                        $response['success'] = 'Failed';
                        $response['error'] = 'File Not Found';
                    }
                } else {
                    $response['success'] = 'Failed';
                    $response['error'] = 'Document Not Found';
                }
            }
        }

        return response()->json($response);

    }

    public function updateDriverDocuments(Request $request)
    {

		$driver_id = $request->get('driver_id');

		$document_id = $request->get('document_id');

        $attachment = $request->file('attachment');



        $validator = Validator::make($request->all(), $rules = [
            'attachment' => "required",
            'driver_id' => "required",
            'document_id' => 'required',

        ], $messages = [
            'attachment.required' => 'The docuemnt field is required!',
            'driver_id.required' => 'The driver_id field is required!',
            'document_id.required' => 'The document_id field is required!',

        ]);

        if ($validator->fails()) {
            $response['success'] = 'Failed';

            $response['error'] =$validator;

            $response['message'] =$messages;

            return response()->json($response);
        }

        $document_id = $request->input('document_id');

		$document_name = DB::table('admin_documents')->where('id', $document_id)->first();
        // print_r($document_id);
        // exit;
        $driver = DriversDocuments::where('driver_id', "=", $driver_id)->where('document_id','=',$document_id)->first();
        $driver_log = Driver::where('id',$driver_id)->first();

        $driver_id = Driver::where('id',$driver_id)->first();
        if(!empty($driver_id) && $driver_log->statut_vehicule == 'yes')
        {
            if ($driver) {

                if ($request->hasfile('attachment')) {

                    $destination = 'assets/images/driver/documents/' . $driver->document_path;

                    if (File::exists($destination)) {
                        File::delete($destination);
                    }

                    $file = $request->file('attachment');

                    $extenstion = $file->getClientOriginalExtension();

                    $filename = str_replace(' ','_',$document_name->title) . '_' . time() . '.' . $extenstion;

                    $file->move(public_path('assets/images/driver/documents/'), $filename);

                    $driver->document_path = $filename;

                    $driver->document_status = 'Pending';

                    $driver_log->statut = 'no';

                    $driver_log->save;
                }

                $driver->save();

            }
            else{

                $driver_doc = new DriversDocuments;

                if ($request->hasfile('attachment')) {

                    $file = $request->file('attachment');

                    $extenstion = $file->getClientOriginalExtension();

                    $filename = str_replace(' ','_',$document_name->title) . '_' . time() . '.' . $extenstion;

                    $file->move(public_path('assets/images/driver/documents/'), $filename);

                    $driver_doc->document_path = $filename;

                    $driver_doc->document_status = 'Pending';
                }

                $driver_doc->driver_id = $request->get('driver_id');

                $driver_doc->document_id = $request->input('document_id');

                $driver_doc->save();
            }
            $response['success'] = 'updated';

            $response['error'] = 'Nt found';
        }

        else{
            $response['success'] = 'failed';

            $response['error'] = 'Vehicle not found';
        }


        return response()->json($response);

    }

    public function getDriverDocuments(Request $request)
    {

        $driver_id = $request->get('driver_id');

		$admin_documents = DB::table('admin_documents')->where('is_enabled','=','Yes')->get();

        if(!empty($admin_documents)){

            foreach ($admin_documents as $key=>$document) {

				$get_driver_document = DB::table('driver_document')->where('document_id', $document->id)->where('driver_id', $driver_id)->first();

				if($get_driver_document){
					$document->document_path = url('assets/images/driver/documents/'.$get_driver_document->document_path);
					$document->document_status = $get_driver_document->document_status;
					$document->comment = $get_driver_document->comment;
				}else{
					$document->document_path = '';
					$document->document_status = 'Pending';
					$document->comment = '';
				}
            	$document->document_name = $document->title;

				$admin_documents[$key] = $document;
            }

            $response['success'] = 'success';
            $response['error'] = null;
            $response['message'] = 'successfully';
            $response['data'] = $admin_documents;
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Failed to fetch data';
            $response['message'] = 'successfully';
        }

        return response()->json($response);

    }


}
