<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Auth;
use File;
use Hash;
use Illuminate\Http\Request;
use Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    public function register() {
        return view('account.register');
    }
    public function processRegister(Request $request) {
       $validator = Validator::make($request->all(),[
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'confirm_password' => 'required|same:password',
       ]);

       if($validator->passes()) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'user';
        $user->save();
        return redirect()->route('account.login')->with('success','registration successfull.');
       } else {
        return redirect()->route('account.register')->withInput()->withErrors($validator->errors());
       }
    }

    public function login() {
        return view('account.login');
    }
    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->passes()) {
            if(Auth::attempt(['email' => $request->email , 'password' => $request->password])) {
                return redirect()->route('account.profile')->with('success','login successfull');
            } else {
                return redirect()->route('account.login')->with('error','Either email or password is incorrect');
            }
        } else {
            return redirect()->route('account.login')->withInput()->withErrors($validator->errors());
        }
    }

    public function profile() {
        $user = User::find(Auth::user()->id);
        return view('account.profile',compact('user'));
    }
    public function updateProfile(Request $request) {
        $user = User::find(Auth::user()->id); 
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$user->id.'id',
        ];
        if(!empty($request->image)) {
            $rules['image'] = 'image';
        }
      $validator = Validator::make($request->all(),$rules); 
      if($validator->passes()) {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        if(!empty($request->image)) {
            //delete old image
            if(!empty($user->image)) {
                File::delete(public_path('uploads/profile/'.$user->image));
                File::delete(public_path('uploads/profile/thumb/'.$user->image));
            }
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext;
            $image->move('uploads/profile',$imageName);
            $user->image = $imageName;
            $user->save();

            $manager = new ImageManager(new Driver());
            $img = $manager->read(public_path('uploads/profile/'.$imageName));
            $img->cover(150,150);
            $img->save(public_path('uploads/profile/thumb/'.$imageName));
        }

        return redirect()->route('account.profile')->with('success','profile updated successfully');
      } else {
        return redirect()->route('account.profile')->withInput()->withErrors($validator->errors());
      }
    }
    public function logout() {
       Auth::logout();
       return redirect()->route('account.login')->with('success','logout successfull');
    }

    public function changePassword() {
        return view('account.changePassword');
    }
    public function changePasswordPost(Request $request) {
        $validator = Validator::make($request->all() ,[
            'old_password' => 'required',
            'new_password' => 'required',
            'password_confirm' => 'required|same:new_password',
        ]);

        if($validator->passes()) {
            $user = User::select('id','password')->where('id', Auth::user()->id)->first(); 
            if(!Hash::check($request->old_password ,$user->password)) {
                return redirect()->route('account.changePassword')->with('error','your old password is incorrect');
            }
           User::where('id',$user->id)->update([
            'password' => Hash::make($request->new_password)
           ]);

           session()->flash('success','You Updated your password');
           return redirect()->route('account.profile')->with('success','password updated successfully');
        } else {
         return redirect()->route('account.changePassword')->withInput()->withErrors($validator->errors());
        }
       
    }

    public function reviews() {
        $reviews = Review::with('user','book')->paginate(5);
        return view('account.reviews', compact('reviews'));
    }

    public function delete($id) {
        $review = Review::find($id);
        if($review == null) {
            return redirect()->route('account.reviews')->with('error','Record Not found');
        }
        $review->delete();
        return redirect()->route('account.reviews')->with('success','book deleted successfull');
    }

    public function myReviews() {
        $reviews = Review::where('user_id', Auth::id())->with('user','book')->paginate(5);
        return view('account.myReviews', compact('reviews'));
    }
    public function destroy($id) {
        $review = Review::find($id);
        if($review == null) {
            return redirect()->route('account.myReviews')->with('error','Record Not found');
        }
        $review->delete();
        return redirect()->route('account.myReviews')->with('success','review deleted successfull');
    }
    public function edit($id) {
        $review = Review::find($id);
        if($review == null) {
            return redirect()->route('account.myReviews')->with('error','Record Not found');
        }
        return view('account.editReview', compact('review'));
    }
    public function update($id,Request $request) {
        $review = Review::find($id);
        if($review == null) {
            return redirect()->route('account.myReviews')->with('error','Record Not found');
        }
       $validator = Validator::make($request->all(), [
        'review' => 'required|min:10',
        'rating' => 'required',
       ]);
       if($validator->passes()) {
        $review->review = $request->review;
        $review->ratings = $request->rating;
        $review->save();
        return redirect()->route('account.myReviews')->with('success','review updated successfully');
       } else {
        return redirect()->route('account.edit-my-reviews',$id)->withErrors($validator->errors());
       }
    }
    public function editReview($id) {
        $review = Review::find($id);
        if($review == null) {
            return redirect()->route('account.reviews')->with('error','Record Not found');
        }
        return view('account.editAdminReview', compact('review'));
    }
    public function updateReview($id,Request $request) {
        $review = Review::find($id);
        if($review == null) {
            return redirect()->route('account.reviews')->with('error','Record Not found');
        }
       $validator = Validator::make($request->all(), [
        'review' => 'required|min:10',
        'rating' => 'required',
        'status' => 'required',
       ]);
       if($validator->passes()) {
        $review->review = $request->review;
        $review->ratings = $request->rating;
        $review->status = $request->status;
        $review->save();
        return redirect()->route('account.reviews')->with('success','review updated successfully');
       } else {
        return redirect()->route('account.edit-reviews',$id)->withErrors($validator->errors());
       }
    }
}