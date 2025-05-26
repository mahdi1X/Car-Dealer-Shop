<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'region' => 'required|string|max:255',

        ]);
    }


    // public function register(Request $request)
    // {
    //     // dd($request->all());
    //     $this->validator($request->all())->validate();
    //             // dd($request->all());

    //     event(new Registered($user = $this->create($request->all())));
    //      dd($request->all());

    //     $this->guard()->login($user);

    //     if ($response = $this->registered($request, $user)) {
    //         return $response;
    //     }

    //     return $request->wantsJson()
    //                 ? new JsonResponse([], 201)
    //                 : redirect($this->redirectPath());
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $profilePath = null;

        if (request()->hasFile('profile_picture')) {
            $profilePath = request()->file('profile_picture')->store('profile_pictures', 'public');
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'payment_method' => $data['payment_method'],
            'region' => $data['region'], // if added
            'role' => 'customer',
            'profile_picture' => $profilePath,
        ]);

    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Only allow user to update their own profile
        if ($request->user()->id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|in:visa_card,cash,bnpl',
            'region' => 'required|string|in:Beirut,Mount Lebanon,North Lebanon,South Lebanon,Bekaa,Nabatieh',
            'report' => 'nullable|string',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Convert report textarea string into array and store as JSON
        if (!empty($validated['report'])) {
            $validated['report'] = array_filter(array_map('trim', explode("\n", $validated['report'])));
            $validated['report'] = json_encode($validated['report']);
        } else {
            $validated['report'] = json_encode([]);
        }

        $user->update($validated);

        return redirect()->route('user.profile', $user->id)->with('message', 'Profile updated successfully.');
    }



}
