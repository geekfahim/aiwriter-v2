<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Validator;

class TeamController extends BaseController
{
    /**
     * Display a listing of administrative users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = User::all()->where('role', '!=', 'customer')->where('status', '!=', 'deleted');
        return view('admin.settings.team.index', compact('rows'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.team.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->where(function ($query) {
                    $query->whereIn('role', ['admin', 'manager']);
                }),
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }

        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->role = 'manager';
        $user->save();

        return response()->json(['success' => true, 'message'=> __('User created successfully')]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.settings.team.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($id)->where(function ($query) {
                    $query->whereIn('role', ['admin', 'manager']);
                }),
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }

        $user = User::findOrFail($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json(['success' => true, 'message'=> __('User updated successfully')]);
    }

    /**
     * Delete a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);

        if($user->role != 'admin'){
            $user->status = 'deleted';
            $user->save();
            return response()->json(['success' => true, 'message'=> __('User deleted successfully.')]);
        } else {
            return response()->json(['success' => true, 'message'=> __('You can\'t delete the main admin user.')]);
        }
    }

    /**
     * Deactivate a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        if($user->role != 'admin'){
            $user->status = 'inactive';
            $user->save();
            return response()->json(['success' => true, 'message'=> __('User deactivated successfully.')]);
        } else {
            return response()->json(['success' => true, 'message'=> __('You can\'t deactivate the main admin user.')]);
        }
    }

    /**
     * Activate a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();
        return response()->json(['success' => true, 'message'=> __('User activated successfully.')]);
    }
}
