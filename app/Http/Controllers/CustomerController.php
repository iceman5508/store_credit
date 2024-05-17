<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewCustomerRequest;
use App\Models\Credit;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class CustomerController extends Controller
{
    /**
     * Save Customers
     * @param Request $request
     * @return void
     */
    public function saveCustomer(NewCustomerRequest $request){

       $user =  User::create([
            'name' => $request->name,
           'password' => uniqid(),
            'email' => $request->email,
            'store_id' => Auth::user()->store->id,
            'role_id' => 3
        ]);

        if($request->credit > 0 ){
            Credit::create([
                'store_id' => Auth::user()->store->id,
                'user_id' => $user->id,
                'employee_id' => Auth::user()->id,
                'value' => $request->credit
            ]);
        }

        return back()->with('success',"{$request->name}'s account was successfully created!");



    }


    /**
     * @param User $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function details(User $id, Request $request){
        $user_fields = $id->store->userFields($id->id);
        return view('dashboard.user_detail',['user' => $id, 'user_fields' => $user_fields]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveTransaction(Request $request){
        $validated = $request->validate([
            'selCustomer' => ['required','min:1',
                Rule::exists('users','id')->where('store_id', Auth::user()->store->id)],
            'trans_credit' => 'required|min:1',
        ]);


        if($request->trans_credit < 0)
        {
            $user = User::findOrFail($request->selCustomer);
            if($user->available_credit() < abs($request->trans_credit)){
                return back()->with('error',"User does not have enough credit to complete this transaction!");
            }
        }


        Credit::create([
            'store_id' => Auth::user()->store->id,
            'user_id' => $request->selCustomer,
            'employee_id' => Auth::user()->id,
            'value' => $request->trans_credit
        ]);

        return back()->with('success',"Transaction was successfully completed.");

    }

    /**
     * Update User detail
     * @param User $id
     * @param Request $request
     * @return void
     */
    public function updateUser(User $id, Request $request){
        $store = Auth::user()->store->id;
        if($request->customerEmail !== $id->email){
            $validated = $request->validate([
                'email' => [
                    'required', 'min:5', 'email', 'unique:users',
                    Rule::unique('users','email')->where('store_id', $store)
                ],
                'inputUsername' => 'required|min:3',
            ]);
        }else{
            $validated = $request->validate([
                'email' => ['required', 'min:5', 'email'],
                'inputUsername' => 'required|min:3',
            ]);
        }

        $id->name = $request->inputUsername;
        $id->email = $request->email;
        $id->save();

        return back()->with('success',"User Detail was saved.");

    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleUserField(User $user, Request $request){
        $store = Auth::user()->store->id;
        $validated = $request->validate([
            'selected_field' => [
                'required', 'min:1', 'numeric', 'exists:fields,id'
            ],
            'fieldValue' => [
                'required', 'min:4'
            ],

            'userMeta' => [
                'required', 'min:0', 'numeric'
            ]
        ]);

        $field = UserMeta::find($request->userMeta);

        if(!empty($field)){
            if($field->user_id === $user->id && $field->store_id === $store && $field->field_id ===  (int)$request->selected_field){
                $field->value = $request->fieldValue;
                $field->save();
            }else{
                return back()->with('error',"Unauthorized Access.");
            }
        }else{
            $field = UserMeta::create(
                [
                    'store_id' => $store,
                    'user_id' => $user->id,
                    'field_id' =>  $request->selected_field,
                    'value' => $request->fieldValue
                ]
            );
        }

        if($field){
            return back()->with('success',"The field was successfully saved.");
        }
        return back()->with('error',"The field could not be saved, please try again later.");

    }

    function index(){
        return view('dashboard.customers');
    }


    function transactions(){
        return view('dashboard.transactions');
    }
}
