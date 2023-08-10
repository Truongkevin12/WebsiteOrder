<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UsersGroup;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $users_customer = User::whereIn('group_id', [0, 8])->get();
        $users_admin = User::whereIn('group_id', [16, 13, 10])->get();
        $users_other = User::whereNotIn('group_id', [16,0,8,13,10])->get();
        $stores = Stores::paginate(50);
        $users_group = UsersGroup::paginate(50);
        $data = [
            'users' => $users,
            'stores' => $stores,
            'users_group' => $users_group,
            'users_customer' => $users_customer,
            'users_admin' => $users_admin,
            'users_other' => $users_other,
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
        $users_group = UsersGroup::paginate(50);
        $stores = Stores::paginate(50);
        $data = [
            'stores' => $stores,
            'users_group' => $users_group,
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
        $validated = $request->validate(
            [
                'username' => 'required|max:255',
                'email' => 'required|unique:cms_users,email|email',
                'phone' => 'required',
            ],
            [
                "username.required" => "Hãy nhập Họ và tên",
                "username.max" => "Ký tự tối đa là 255",
                "email.unique" => "Tài khoản đã tồn tại",
                "email.required" => "Hãy nhập email tài khoản",
                "email.email" => "Email không hợp lệ",
                "phone.required" => "Hãy nhập số điện thoại khách hàng",

            ]
        );
        $validated['password'] = Hash::make($request->input('password'));
        User::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::find($id);
        $users_group = UsersGroup::all();
        $stores = Stores::all();
        return response()->json([
            "users" => $users,
            "stores" => $stores,
            "users_group" => $users_group,
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
        $stores = Stores::paginate(50);
        $users_group = UsersGroup::paginate(50);
        $users = User::find($id);
        return response()->json([
            "users" => $users,
            "users_group" =>$users_group,
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
        $users = User::find($id);
        $users->update($request->all());
        return response()->json($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        $users->delete();
        return response()->json('The post successfully deleted');

    }

}
