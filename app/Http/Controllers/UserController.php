<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index',["test"=>"ahmed"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $data = $request->validated();

        if($request->hasFile("avatar_image")){
            $path = $request->file("avatar_image")
                ->store('',["disk"=>"avatars"]);

            $data["avatar_image"] = $path;
        }

        $data["password"] = Hash::make($data["password"]);

        $user = User::create($data);

        $user->assignRole("admin");


        return redirect()->route("users.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view("users.show",["user" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("users.edit",["user"=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $data["password"] = isset($request->password)
                            ? Hash::make($request->password)
                            : $user->password;

        if ($request->hasFile("avatar_image"))
        {
            Storage::disk("avatars")->delete($user->avatar_image);
            $data["avatar_image"] = $request->file("avatar_image")
                                    ->store('',["disk"=>"avatars"]);
        }
//        dd($data);

        $user->update($data);

        return redirect()->route("users.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route("users.index");
    }
}
