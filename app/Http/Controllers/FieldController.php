<?php

namespace App\Http\Controllers;

use App\Models\EnabledField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(){
        return view('dashboard.fields');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleField(Request $request){
        $store = Auth::user()->store->id;
        $validated = $request->validate([
            'field_value' => [
                'required', 'min:1', 'numeric', 'exists:fields,id'
            ],
            'field_id' => [
                'required', 'min:1', 'numeric'
            ],
            'field_status' => [
                'required', 'min:0', 'numeric'
            ]
        ]);

        $settings = EnabledField::find($request->field_id);

        if(!empty($settings)){
            $settings->status = $request->field_status;
            $settings->save();
        }else{
            $settings=   EnabledField::create(
                [
                    'store_id' => $store,
                    'field_id' => $request->field_value
                ]
            );
        }

        if($settings){
            return back()->with('success',"The field, {$settings->field->name}, was successfully toggled.");
        }
        return back()->with('error',"The field could not be toggled, please try again later.");


    }
}
