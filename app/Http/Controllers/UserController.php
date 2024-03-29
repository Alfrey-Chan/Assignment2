<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buttons = [
            [
                'href' => route('transaction.create'),
                'text' => 'New Transaction',
                'adminOnly' => false,
            ],
            [
                'href' => route('transaction.import'),
                'text' => 'Upload CSV',
                'adminOnly' => false,
            ],
            [
                'href' => route('bucket.index'),
                'text' => 'View Buckets',
                'adminOnly' => true,
            ],
        ];
        $adminEmail = config('admin.email');
        $users = User::where('email', '!=', $adminEmail)
            ->orderBy('created_at', 'asc')
            ->paginate(5);
        return view('users.approval', [
            'users' => $users,
            'buttons' => $buttons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->approved = false;
        $user->save();
        session()->flash(
            'message',
            'Please wait until the administrator approves your registration.'
        );

        return redirect()->route('welcome');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()
            ->route('users.approve')
            ->with('success', 'User removed successfully.');
    }

    public function login()
    {
        return view('users.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('transaction');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->approved = true;
        $user->save();

        return redirect()->route('approvals');
    }
}
