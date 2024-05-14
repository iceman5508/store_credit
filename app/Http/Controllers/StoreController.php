<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\User;
use Core\Authentication\Auth;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{

    public function index()
    {

    }

    public function addStore(){
        $store = Store::where('owner_id', auth()->user()->id)->get();
        $package = Package::all();
       return view('addStore', compact('store', 'package'));
    }


    public function create()
    {
        //
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
