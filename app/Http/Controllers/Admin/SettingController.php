<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; 
use App\Models\Contact;
use App\Models\Group;
use App\Models\ProjectTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\Template;
use App\Resolvers\PaymentPlatformResolver;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use DateTime;
use Helper;
use Session;
use Validator;

class SettingController extends BaseController
{
    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function general(Request $request){
        if ($request->isMethod('get')){
            $data['timezones'] = $this->_get_timezones();

            return view('admin.settings.general', $data);
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'company_name' => 'required',
                'timezone' => 'required',
                'date_format' => 'required',
                'time_format' => 'required',
                'trial_period' => 'required',
                'trial_word_limit' => 'required',
            ]);
    
            if ($validator->passes()) {
                foreach($request->except('_token') as $key => $value){
                    DB::table('settings')
                    ->updateOrInsert([
                        'key' => $key
                    ],[
                        'value' => $value,
                    ]);
                }

                return response()->json(['success'=>true, 'message'=>__('You\'ve updated your settings successfully!')]);
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }

    public function contacts(Request $request){
        foreach($request->except('_token') as $key => $value){
            if($key != 'socials'){
                DB::table('settings')
                ->updateOrInsert([
                    'key' => $key
                ],[
                    'value' => $value,
                ]);
            }
        }

        foreach($request->socials as $key => $value){
            $socials[$key] = $value;
        }

        DB::table('settings')
        ->updateOrInsert([
            'key' => 'socials'
        ],[
            'value' => serialize($socials),
        ]);

        return response()->json(['success'=>true, 'message'=>__('You\'ve updated your settings successfully!')]);
    }

    public function upload(Request $request, $type){
        $validator = Validator::make($request->all(),[
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->passes()) {
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = $file->hashName();

                // Check if the file exists
                if (file_exists(public_path('uploads/brand/' . $filename))) {
                    unlink(public_path('uploads/brand/' . $filename));
                }

                // Save the file
                $file->move(public_path('uploads/brand'), $filename);

                //$file->storeAs('public', $filename);
                DB::table('settings')
                    ->where('key', $type)
                    ->update([
                        'value' => $filename,
                    ]);
            }
        
            return response()->json(['success' => true, 'url' => url('uploads/brand/' . $filename), 'message' => __('You\'ve updated your ' . $type . ' successfully!')]);
        }

        return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
    }

    public function smtp(Request $request){
        if ($request->isMethod('get')){
            return view('admin.settings.smtp');
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'email_method' => 'required',
                'smtp_host' => 'required_if:email_method,smtp',
                'smtp_port' => 'required_if:email_method,smtp',
                'smtp_username' => 'required_if:email_method,smtp',
                'smtp_password' => 'required_if:email_method,smtp',
                'email_provider_api_key' => 'required_if:email_method,api',
                'email_provider_api_key' => 'required_if:email_method,api',
                'smtp_sender_name' => 'required',
                'smtp_sender_email' => 'required',
            ]);
    
            if ($validator->passes()) {
                foreach($request->except('_token') as $key => $value){
                    DB::table('settings')
                    ->updateOrInsert([
                        'key' => $key
                    ],[
                        'value' => $value,
                    ]);
                }

                return response()->json(['success'=>true, 'message'=>__('You\'ve updated your settings successfully!')]);
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }

    public function test_email(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
        ]);

        if ($validator->passes()) {
            if(Helper::config('email_method') == 'smtp'){
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = Helper::config('smtp_host');
                    $mail->SMTPAuth = true;
                    $mail->Username = Helper::config('smtp_username');
                    $mail->Password = Helper::config('smtp_password');
                    $mail->SMTPSecure = Helper::config('smtp_encryption');
                    $mail->Port = Helper::config('smtp_port');
                    $mail->setFrom(Helper::config('smtp_sender_email'), Helper::config('smtp_sender_name'));
                    $mail->addAddress($request->email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Test email subject';
                    $mail->Body = 'This is a test email. Your email smtp settings are working great!';
                    $mail->send();
                    return response()->json(['success' => true, 'message'=>'Email sent successfully.']);
                } catch (Exception $e) {
                    return response()->json(['success' => false, 'errors'=> ['email' => $mail->ErrorInfo]]);
                }
            } else {
                $email = new \SendGrid\Mail\Mail();
                $email->setFrom(Helper::config('smtp_sender_email'), Helper::config('smtp_sender_name'));
                $email->setSubject('Test email subject');
                $email->addTo($request->email, 'Test');
                $email->addContent("text/plain", 'This is a test email. Your email smtp settings are working great!');
                
                $sendgrid = new \SendGrid(Helper::config('email_provider_api_key'));
        
                try {
                    $response = $sendgrid->send($email);
                    return response()->json(['success' => true, 'message'=>'Email sent successfully.']);
                } catch (Exception $e) {
                    return response()->json(['success' => false, 'errors'=> ['email' => 'Caught exception: '. $e->getMessage() ."\n"]]);
                }
            }
        }

        return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
    }

    public function team(Request $request){
        $data['rows'] = DB::table('team')
            ->where('status', '!=', 'deleted')
            ->get();

        return view('admin.settings.team', $data);
    }

    public function integrations(Request $request){
        $data['rows'] = DB::table('integrations')->get();
        return view('admin.settings.integrations.list', $data);
    }

    public function update_integration(Request $request, $id = NULL, $change_status = NULL){
        if ($request->isMethod('get')){
            $data['api'] = DB::table('integrations')->where('id', $id)->first();
            $data['is_serialized'] = unserialize($data['api']->data);
            return view('admin.settings.integrations.edit', $data);
        } else if ($request->isMethod('post')){
            if(request()->segment(5) == 'status'){
                $api = DB::table('integrations')->where('id', $id)->first();
                $status = $request->status == 0 ? 0 : 1;

                DB::table('integrations')
                    ->where('id', $id)
                    ->update([
                        'status' => $status
                    ]);

                if($status == 0){
                    $message = "You\'ve deactivated ".$api->name." successfully!";
                } else {
                    $message = "You\'ve activated ".$api->name." successfully!";
                }
                return response()->json(['success'=>true, 'message'=>__('You\'ve updated your api settings successfully!')]);
            } else {
                $inputs = $request->except('_token');
                foreach($inputs as $key => $val){
                    $inp[$key] = $val;
                }

                $array = array(
                    'data' => serialize($inp)
                );

                DB::table('integrations')
                    ->where('id', $id)
                    ->update($array);

                return response()->json(['success'=>true, 'message'=>__('You\'ve updated your api settings successfully!')]);
            }
        }
    }

    public function update(Request $request){
        if ($request->isMethod('get')){
            return view('templates.add');
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'message' => 'required'
            ]);
    
            if ($validator->passes()) {
                $array = array(
                    'name' => $request->name,
                    'message' => $request->message,
                    'created_at' => date('Y-m-d H:i:s')
                );

                $res = Template::create($array);

                if($res){
                    return response()->json(['success' => true, 'message'=> __('Template created successfully')]);
                } else {
                    return response()->json(['success' => false, 'message'=> __('Something went wrong. Please refresh the page and try again!')]);
                }
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }

    public function billing(Request $request){
        if ($request->isMethod('get')){
            return view('admin.settings.billing');
        } else if ($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'billing_vendor' => 'required',
                'billing_invoice_prefix' => 'required',
            ]);
    
            if ($validator->passes()) {
                foreach($request->except('_token') as $key => $value){
                    DB::table('settings')
                    ->updateOrInsert([
                        'key' => $key
                    ],[
                        'value' => $value,
                    ]);
                }

                return response()->json(['success'=>true, 'message'=>__('You\'ve updated your settings successfully!')]);
            }

            return response()->json(['success' => false, 'errors'=>$validator->messages()->get('*')]);
        }
    }

    function _get_timezones()
	{
		$timezones = \DateTimeZone::listIdentifiers();
		$timezone_offsets = array();
		
		foreach($timezones as $timezone)
		{
		    $tz = new \DateTimeZone($timezone);
		    $timezone_offsets[$timezone] = $tz->getOffset(new \DateTime);
		}

		// sort timezone by offset
		asort($timezone_offsets);

		$timezone_list = array();
		foreach($timezone_offsets as $timezone => $offset)
		{
		    $offset_prefix = $offset < 0 ? '-' : '+';
		    $offset_formatted = gmdate('H:i', abs($offset) );
		    $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
			

			$current_time = '';
			$date = new \DateTime();
			$date->setTimezone(new \DateTimeZone($timezone));
			if (method_exists($date, 'setTimestamp'))
			{
				$date->setTimestamp(time());
				$current_time = $date->format('h:i a');
			}
			$timezone_list[$timezone] = "(${pretty_offset}) $timezone $current_time";
		}

		return $timezone_list;
	}
}