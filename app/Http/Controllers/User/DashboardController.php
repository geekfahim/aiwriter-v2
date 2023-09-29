<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 
use App\Models\AudioContent;
use App\Models\FavoriteTemplate;
use App\Models\ImageContent;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Project;
use App\Models\ProjectContent;
use App\Models\ProjectTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\Review;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Helper;
use Session;
use Validator;

class DashboardController extends BaseController
{
    public function index(Request $request){
        $data['projects'] = Project::where('user_id', auth()->user()->id)
            ->orderBy('updated_at', 'desc')
            ->where('deleted', 0)
            ->limit(5)
            ->get();
        $data['plans'] = SubscriptionPlan::where('status', 'active')->get();
        $data['alltemplates'] = DB::table('project_templates')->get();
        $data['review'] = Review::where('status', 'active')->orderBy('id', 'asc')->first();
        $data['categories'] = ProjectTemplateCategory::where('deleted', 0)->get();
        $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->get();
        $data['subscription'] = userSubscription::where('user_id', auth()->user()->id)->first();

        return view('user.dashboard', $data);
    }

    public function verify_email(Request $request, $uuid = NULL){
        if ($request->isMethod('get')){
            if($uuid == NULL){
                if(Helper::config('verify_email') == 1 && auth()->user() && auth()->user()->email_verified_at == NULL){
                    return view('user.verifyEmail');
                } else {
                    return redirect('dashboard');
                }
            } else {
                //Check if uuid exists in database
                $user = User::where('uuid', $uuid)->first();
                if($user){
                    if($user->email_verified_at == null){
                        $update = User::where('uuid', $uuid)->update([
                            'email_verified_at' => date('Y-m-d H:i:s')
                        ]);
                        Auth::guard('user')->loginUsingId($user->id);
                    }
                    return redirect('dashboard');
                } else {
                    //Show error 404
                    return response()->view('errors.404', [], 404);
                }
            }
        }
    }

    public function resend_verification_email(Request $request){
        Helper::sendEmailToUser('Verify Email', auth()->user());
    }

    public function templates(Request $request, $category = NULL){
        $data['categories'] = ProjectTemplateCategory::where('deleted', 0)->get();
        if($category == NULL){
            $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->get();
        } else {
            $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->where('category', $category)->get();
        }

        //dd(ProjectTemplateCategory::with('templates')->get());
        return view('user.templates.grid', $data);
    }

    public function mark_as_favorite(Request $request, $template_id){
        $collection = $request->query('collection');
        //Check if already exists for this user
        $count = FavoriteTemplate::where('user_id', auth()->user()->id)
            ->where('template_id', $template_id)
            ->count();
        // $userSubscription= userSubscription::where('user_id', auth()->user()->id)->first();

        if($count == 0){
            
            if($collection){
                if($this->token_deduction()){
                    // $userSubscription->available_token=$userSubscription->available_token-1;
                    // $userSubscription->save();
                    
                    $query = FavoriteTemplate::create([
                        'user_id' => auth()->user()->id,
                        'template_id' => $template_id
                    ]);
            
                    return response()->json([
                    "success"=>true,
                    "message"=>"collection Updated",
                    "token"=>$userSubscription->available_token
                    ]);
                }
            }
            
        } else {
            
            if($collection){
                return response()->json([
                "success"=>false,
                "message"=>"Already In Collection"
                ]);
            }else{
                $query = FavoriteTemplate::where('user_id', auth()->user()->id)
                    ->where('template_id', $template_id)
                    ->delete();
            }
        }
        
        if(!$collection){
            return view('user.sidebar');
        }
    }

    public function token_deduction(){
        $userSubscription= userSubscription::where('user_id', auth()->user()->id)->first();
        if($userSubscription->available_token > 0){
            $userSubscription->available_token=$userSubscription->available_token-1;
            $userSubscription->save();
            return true;
        }else{
            return false;
        }
    }

    public function search_template(Request $request, $category = NULL){
        $query = $request->q;
        
        if($category == NULL){
            $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->where('name', 'LIKE', '%'.$query.'%')->paginate(20);
        } else {
            $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->where('name', 'LIKE', '%'.$query.'%')->where('category', $category)->paginate(20);
        }

        return view('user.templates.grid', $data);
    }
    public function search_bysub(Request $request, $subcategory = NULL){
        $query = $request->q;
        
        if($subcategory == NULL){
            $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->where('name', 'LIKE', '%'.$query.'%')->paginate(20);
        } else {
            $data['templates'] = ProjectTemplate::where('status', 'active')->where('deleted', 0)->where('name', 'LIKE', '%'.$query.'%')->where('subcategory', $subcategory)->paginate(20);
        }

        return view('user.templates.grid', $data);
    }
}