<?php

namespace App\Http\Controllers;


use App\Http\Requests\NewEmployeeRequest;
use App\Models\Package;
use App\Models\User;
use Core\Authentication\Auth;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{

    public function index()
    {
        if(auth()->user()->role_id !== 0){
            return view('dashboard.index');
        }
        return view('dashboard.employees');
    }

    public function addStore(){

        if(auth()->user()->store_id === 0){
            $store = Store::where('owner_id', auth()->user()->id)->get();
        }else{
            $store = Store::where('id', auth()->user()->store_id)->get();
        }


        $package = Package::all();
       return view('addStore', compact('store', 'package'));
    }

    /**
     *Add employee
     * @param Request $request
     * @return void
     */
    public function addEmployee(NewEmployeeRequest $request)
    {
        $user =  User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'store_id' => \Illuminate\Support\Facades\Auth::user()->store->id,
            'role_id' => 2
        ]);



        return back()->with('success',"{$request->name}'s account was successfully created!");

    }


    public function store(Request $request)
    {
        $store = Store::create([
            'name' => $request->name,
            'owner_id' => auth()->user()->id
        ]);

        if($store)
        {
            return redirect()->route('addStore')->with('success', 'store added successfully');
        }
    }

    public function show(string $id)
    {

    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
        return redirect()->back()->with('success', 'store deleted successfully');
    }

    /**
     * Logi to a specific store
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLogin(string $id){
        $store = Store::findOrFail($id);
        auth()->user()->store_id = $id;
        auth()->user()->save();
        return redirect('/home');
    }
}
