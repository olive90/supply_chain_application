<?php

namespace App\Http\Controllers;

use App\Remarks;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class RemarksController extends Controller
{
    public function index()
    {
        
    }

    public function create(Request $request)
    {
        $pr_key = $request->pr_key;
        return view('remarks.index', ['pr_key' => $pr_key]);
        // echo $key;die;
    }

    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'rating' => 'required',
            'remarks' => 'required'
        ]);

        $key = base64_decode($request->pr_key);
    
        $remarks = new Remarks();
        $remarks->rating = $request->rating;
        $remarks->remark = $request->remarks;
        $remarks->user_id = $request->user()->id;
        $remarks->pr_id = $key;
        $remarks->save();
    
        return redirect()->route('purchase-order.index')
                        ->with('success','Thanks for your valuable rating.');
    }

    public function show(Remarks $remarks)
    {
        //
    }

    public function edit(Remarks $remarks)
    {
        //
    }

    public function update(Request $request, Remarks $remarks)
    {
        //
    }

    public function destroy(Remarks $remarks)
    {
        //
    }
}
