<?php

namespace App\Http\Controllers;

use App\Problem;
use App\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ContestController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contestant.home');
    }


    public function profile()
    {
        return view('contestant.profile');
    }

    public function contests()
    {
        return view('contestant.all_contests');
    }

    public function problems(Problem $problem)
    {
        $problems =  $problem->with('Contest')->get();

        return view('problem.problems', compact('problems'));
    }

    public function changePassword()
    {
        return view('auth.passwords.change_password');
    }

    public function passwordChange(Request $request)
    {

        $this->validate(request(),
            [
                'password' => 'required|min:6|confirmed',
            ]);


        $request->user()->fill([

            'password' => Hash::make($request->password)

            ])->save();

        ContestController::showMessage('alert-success','Success!', 'Password Change Successfully' );

        return redirect('/home');
    }



    public function enroll(Request $request)        
    {
        dd($request->all());
    }
}
