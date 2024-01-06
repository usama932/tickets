<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\RemainingToken;
use App\Models\Driver;
use Illuminate\Support\Facades\Validator;
use DB;

class TokenController extends Controller
{

    public function index()
    {
        $tokens = RemainingToken::latest()->get();
        $drivers = Driver::where('statut','yes')->get();
        return view('tokens.index',compact('tokens','drivers'));
    }


    public function create()
    {
        return view('tokens.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $rules = [
            'token' => 'required',
            'user_id' => 'required',


        ], $messages = [
            'token.required' => 'The token field is required!',
            'user_id.required' => 'The driver field is required!',


        ]);
        $rem = RemainingToken::where('user_id',$request->user_id)->first();
        if($rem != Null){
            $token = RemainingToken::where('user_id',$request->user_id)->update([
                'tokens' => $rem->tokens + $request->tokens,
            ]);
        }
        else
        {
            $token = RemainingToken::create([
                'tokens' =>  $request->tokens,
                'user_id' => $request->user_id,
            ]);
        }

        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $token = Token::find($id);
        return view('tokens.edit',compact('token'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $rules = [
            'title' => 'required',
            'amount' => 'required',
            'expiry_date' => 'required',
            'up_to' => 'required'

        ], $messages = [
            'title.required' => 'The Title field is required!',
            'amount.required' => 'The Amount field is required!',
            'expiry_date.required' => 'The Expiry_date field is required!',
            'up_to.required' => 'The UP to field is required!',

        ]);

        $token = RemainingToken::where('user_id',$request->user_id)->update([
            'title' => $request->title,


        ]);
        return redirect()->route('tokens.index');
    }

    public function delete_tokens($id)
    {
        $token = Token::find($id);
        $token->delete();
        return redirect()->route('tokens.index');
    }
}
