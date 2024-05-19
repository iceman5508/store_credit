<?php

namespace App\Http\Controllers;

use App\Models\EnabledField;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(){
        if(auth()->user()->role_id !== 1){
            return view('dashboard.index');
        }
        $store = Auth::user()->store->id;
        $all_fields = Field::storeEnabled($store);
        return view('dashboard.fields', compact('all_fields'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleField(Request $request){
        $store = Auth::user()->store->id;
        $validated = $request->validate([
            'field_value' => [
                'required', 'min:0', 'numeric', 'exists:fields,id'
            ],
            'field_id' => [
                'required', 'min:0', 'numeric'
            ],
            'field_status' => [
                'required', 'min:0', 'numeric'
            ]
        ]);

        $settings = EnabledField::find($request->field_id);

        if(!empty($settings)){
            if($settings->store_id === $store){
                $settings->status = $request->field_status;
                $settings->save();
            }else{
                return back()->with('error',"Unauthorized Access.");
            }
        }else{
            $settings=   EnabledField::create(
                [
                    'store_id' => $store,
                    'field_id' => $request->field_value,
                    'status' => 1
                ]
            );
        }

        if($settings){
            return back()->with('success',"The field, {$settings->field->name}, was successfully toggled.");
        }
        return back()->with('error',"The field could not be toggled, please try again later.");


    }


    public function addField(Request $request){
        $validated = $request->validate([
            'field' => [
                'required', 'min:5',  'unique:fields,name,'
            ]
        ]);

        Field::create([
            'name' => $request->field
        ]);

        return back()->with('success',"The field, {$request->field}, was successfully created.");

    }
}
