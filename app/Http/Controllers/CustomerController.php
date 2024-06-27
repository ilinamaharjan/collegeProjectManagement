<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{


    public function index()
    {
        $customer = Customer::get();
        return view('backend.customer.index',compact('customer'));
    }

  
    public function create()
    {
        return view('backend.customer.create');
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $customer = new Customer([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address' => $data['address'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'url' => $data['url'],
        ]);

        $customer->save();
       
        return $this->index();
        
    
    }

    public function update($id)
    {
       $customer = Customer::all();
       $customer = Customer::where('id' ,$id)->first();
       return view('backend.customer.index', compact('customer'));
    }


    public function FunctionName(Type $var = null)
    {
        $data = $request->all();
        $customer = Customer::where('id' ,$data['id'])->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address' => $data['address'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'url' => $data['url'],
        ]

        );
        return $this->index();
    }

    public function delete($id)
    {
        $customer = Customer::where('id', $id)->first();
        if ($customer != null) {
        $customer->delete();
        return $this->index()->with(['message'=> 'Successfully deleted!!']);
        }
        return redirect()->route('index')->with(['message'=> 'Wrong ID!!']);
    }


 
    
}
