<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewCustomerRequest;
use App\Models\Credit;
use App\Models\User;
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
        return view('dashboard.user_detail',['user' => $id]);
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

        Credit::create([
            'store_id' => Auth::user()->store->id,
            'user_id' => $request->selCustomer,
            'employee_id' => Auth::user()->id,
            'value' => $request->trans_credit
        ]);

        return back()->with('success',"Transaction was successfully completed.");

    }
}
