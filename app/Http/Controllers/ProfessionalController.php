<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Category;
use App\Question;
use Intervention\Image\Facades\Image;
use App\Http\Requests\UpdateUserRequest;







class ProfessionalController extends Controller
{
    //admin only can view all professionals
    public function index()
    {
        $users = User::whereHas("roles", function ($q) {
            $q->where("name", "professional");
        })->get();
        return view('admin/professionals/index', [
            'users' => $users
        ]);
    }



    public function show()
    {
        //all roles can view professional profile, permissions in blade
        $userId = request()->professional;
        $user = User::find($userId);
        $categories = Category::all();
        $profs = User::all()->where('role', '=', '2');
        $users = User::all()->where('role', '=', '1');
        $userId = Auth::id();
        $users = User::all()->where('role', '=', '1');
        $questions=Question::where('prof_id','=',$userId)->orWhere('user_id','=',$userId)->orderBy('created_at', 'desc')->get();
        if (auth()->user()->hasPermissionTo('adminpermission')) {
            return view('admin.professionals.show', [
                 'user' => $user
            ]);
        } else {
            return view('professionals/show', [ 
                'profs' => $profs,
                'users' => $users,
                'categories' => $categories,
                'questions' => $questions,
                'user' => $user
            ]);
        }
    }

    public function edit()
    {
        //professional can edit his  profile
        if (auth()->user()->role==2) {
            $request = request();
            $professionalId = $request->professional;
            $professional = User::find($professionalId);
            return view('professionals/edit', [
                'professional' => $professional
            ]);
        }
    }

    public function update(UpdateUserRequest $request)
    {
        //admin and professionals can edit professional profile, permission in blade
        $categories = Category::all();
        if (auth()->user()->role==2) {
           
            $professional = User::find($request->professional);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->resize(300, 300)->save(public_path('/uploads/avatars/' . $filename));

                $professional->avatar = $filename;
                $professional->save();
            }
            $professional->name = $request->name;
            $professional->email = $request->email;
            $professional->linkedin = $request->linkedin;
            $professional->github = $request->github;
            $professional->other = $request->other;
            if ($request->password != null) {
                $professional->password = bcrypt($request->password);
            }
            $professional->save();
            return redirect()->route('professional.show', [
                'professional' => $professional,
                'categories' => $categories

            ]);
        }
    }


    public function destroy()
    {
        // here only professionals can delete profile             
        if (auth()->user()->role==2) {
            $user = User::findOrFail($id);
            $request = request();
            $professionalId = $request->professional;
            User::destroy($professionalId);

            return redirect()->route('home');
        }
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);
        //dd($user);
        $user->status = !$user->status;
        if ($user->save()) {
            return redirect()->route('home');
        } else {
            return redirect()->route('professionals.changestatus');
        }
    }
    public function banned()
    {
        //here admin only can ban any prof
        $profId = request()->professional;
        $prof = User::find($profId);
        if ($prof->isNotBanned()) {
            $prof->ban();
        } else {
            $prof->unban();
        }
        return redirect()->route('professionals.index', [
            'prof' => $prof
        ]);
    }

    public function profcat(Request $request)
    {
        $categories = Category::all();
        $request = request();
        $profId = Auth::id();
        $prof = User::find($profId); 
        $profcat = $prof->categories;
        $Aprofcat =$profcat->toArray();
        $cats = [];
        foreach($Aprofcat as $catz) {
            foreach ($catz as $cc=> $c) {
                if ($cc=='id'){
             array_push($cats, $c );
                }
        }
        }
        return view('professionals/profcat', [
            'categories' => $categories,
            'cats' => $cats
        ]);
    }

     
    public function attach(Request $request)
    {
        $request = request();
        $catid  = request()->cat;
        $cat = Category::findOrFail($catid);
        $profId = Auth::id();
        $prof = User::find($profId);
        $prof->categories()->attach($cat); 
        return redirect()->route('profcat');

    }


public function detach(Request $request)
    {
        $request = request();
        $catid  = request()->cat;
        $cat = Category::findOrFail($catid);
        $profId = Auth::id();
        $prof = User::find($profId);
        $prof->categories()->detach($cat); 
        return redirect()->route('profcat');

    }
}
