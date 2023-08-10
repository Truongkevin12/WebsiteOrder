<?php

namespace App\Http\Controllers\Admin;

use App\Models\Stores;
use App\Models\Customer;
use App\Models\UsersGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomersBids;
use App\Models\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $customers = Customer::query();
        if ($keyword) {
            $customers->where('customer_name', 'like', "%{$keyword}%");
            $customers->orWhere('customer_phone', 'like', "%{$keyword}%");
            $customers->orWhere('customer_code', 'like', "%{$keyword}%");
        }
        $customers = $customers->paginate(50);
        $data = [
            'customers' => $customers,
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = Stores::paginate(50);
        $customers = Customer::paginate(50);
        $data = [
            'stores' => $stores,
            'customers' => $customers,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        if ($request->hasFile('customer_image')) {
            $imagePath = $request->file('customer_image')->store('customer_images', 'public');
            $requestData['customer_image'] = $imagePath;
        }
        $customer = Customer::create($requestData);
        return response()->json(['message' => 'Customer created successfully'], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        $stores = Stores::all();
        $users = User::all();
        $customerBids = CustomersBids::all();
        return response()->json([
            "customer" => $customer,
            "stores" => $stores,
            "customerBids" => $customerBids,
            "users" => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stores = Stores::all();
        $customer = Customer::find($id);
        return response()->json([
            "customer" => $customer,
            "stores" => $stores,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Customer::where('id', $id)->update($request->all());
        return response()->json(['message' => 'Store updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::where('id', $id)->delete();
        return response()->json('The post successfully deleted');
    }
}
