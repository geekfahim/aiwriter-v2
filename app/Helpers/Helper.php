<?php

namespace App\Helpers;
use Cache;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\FavoriteTemplate;
use App\Models\ProjectTemplateCategory;
use App\Models\Setting;
use App\Models\UserSubscription;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;
use Symfony\Component\Mime\Part\HtmlPart;

class Helper {
    public static function config($key){
        $config = Setting::where('key', $key)->first();

        if($config){
            return $config->value;
        } else {
            return NULL;
        }
    }

    public static function time_ago(Carbon $time){
        $now = Carbon::now();
        $difference = $now->diffInSeconds($time);

        if ($difference < 60) {
            return 'now';
        } elseif ($difference < 3600) {
            return $time->diffInMinutes($now) . ' minute' . ($time->diffInMinutes($now) > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 86400) {
            return $time->diffInHours($now) . ' hour' . ($time->diffInHours($now) > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 604800) {
            return $time->diffInDays($now) . ' day' . ($time->diffInDays($now) > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 2629743) {
            return $time->diffInWeeks($now) . ' week' . ($time->diffInWeeks($now) > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 31556926) {
            return $time->diffInMonths($now) . ' month' . ($time->diffInMonths($now) > 1 ? 's' : '') . ' ago';
        } else {
            return $time->diffInYears($now) . ' year' . ($time->diffInYears($now) > 1 ? 's' : '') . ' ago';
        }
    }

    public static function getArrayKey($value, $array){
        if (! is_array($array)) {
            return null;
        }
        
        if (array_key_exists($value, $array)) {
            return $array[$value];
        }

        return null;
    }

    public static function categories(){
        $categories = ProjectTemplateCategory::with('Templates')->where('deleted', 0)->get();
        
        return $categories;
    }

    public static function favorite_templates(){
        $categories = FavoriteTemplate::with('Template')->where('user_id', Auth::user()->id)->get();
        return $categories;
    }

    public static function is_favorite_template($template_id){
        $count = FavoriteTemplate::where('user_id', Auth::user()->id)
            ->where('template_id', $template_id)
            ->count();

        return $count > 0 ? true : false;
    }

    public static function get_currencies() {
        $currencies = DB::table('currencies')->get();
        return $currencies;
    } 

    public static function has_active_subscription(){
        //Check if trial_period exists
        $trial_period = DB::table('settings')
            ->where('key', 'trial_period')->first()->value;

        $date = Carbon::parse(Auth::user()->created_at);
        $now = Carbon::now();
        $diff = $date->diffInDays($now);
        $diff = $diff + 1;

        $query = UserSubscription::where('user_id', Auth::user()->id)
            ->where('recurring_at', '>=', date('Y-m-d H:i:s'))
            ->where('status', 'active')
            ->first();

        if($query == true || $diff <= $trial_period){
            return true;
        } else {
            return false;
        }
    }

    public static function is_trial_mode(){
        //Check if trial_period exists
        $trial_period = DB::table('settings')->where('key', 'trial_period')->first()->value;
        

        $date = Carbon::parse(Auth::user()->created_at);
        $now = Carbon::now();
        $diff = $date->diffInDays($now);
        $diff = $diff + 1;
        $query = UserSubscription::where('user_id', Auth::user()->id)
            ->where('recurring_at', '>=', date('Y-m-d H:i:s'))
            ->where('status', 'active')
            ->first();
        if($query == false && $diff <= $trial_period){
            return true;
        } else {
            return false;
        }
    }

    public static function content_generated(){
        if(Helper::is_trial_mode()){
            $start_date = Carbon::parse(Auth::user()->created_at);
            $end_date = Carbon::now();

            $word_count = DB::table('project_contents')
                ->where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [$start_date, $end_date])
                ->sum('word_count');

            $seconds_count = DB::table('audio_contents')
                ->join('projects', 'projects.id', '=', 'audio_contents.document_id')
                ->where('projects.user_id', auth()->user()->id)
                ->whereBetween('audio_contents.updated_at', [$start_date, $end_date])
                ->sum('audio_contents.seconds');

            $image_count = DB::table('image_contents')
                ->join('projects', 'projects.id', '=', 'image_contents.document_id')
                ->where('projects.user_id', auth()->user()->id)
                ->whereBetween('image_contents.updated_at', [$start_date, $end_date])
                ->count();

            $res = array(
                'limit' => Helper::config('trial_word_limit'),
                'count' => $word_count,
                'secondsCount' => $seconds_count,
                'imageCount' => $image_count
            );

            return $res;
        } else {
            $query = UserSubscription::where('user_id', Auth::user()->id)
                ->where('recurring_at', '>=', date('Y-m-d H:i:s'))
                ->where('status', 'active')
                ->orderBy('recurring_at', 'desc')
                ->first();

            if($query){
                $start_date = Carbon::parse($query->created_at);
                $end_date = Carbon::parse($query->recurring_at);

                $word_count = DB::table('project_contents')
                    ->where('user_id', auth()->user()->id)
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->sum('word_count');

                $seconds_count = DB::table('audio_contents')
                    ->join('projects', 'projects.id', '=', 'audio_contents.document_id')
                    ->where('projects.user_id', auth()->user()->id)
                    ->whereBetween('audio_contents.updated_at', [$start_date, $end_date])
                    ->sum('audio_contents.seconds');
    
                $image_count = DB::table('image_contents')
                    ->join('projects', 'projects.id', '=', 'image_contents.document_id')
                    ->where('projects.user_id', auth()->user()->id)
                    ->whereBetween('image_contents.updated_at', [$start_date, $end_date])
                    ->count();

                $plan = DB::table('subscription_plans')
                    ->where('id', $query->plan_id)
                    ->first();

                if($plan->words != 0){
                    $plan_words = $query->plan_interval == 'year' ? $plan->words*12 : $plan->words;
                } else {
                    $plan_words = 0;
                }

                $res = array(
                    'limit' => $plan_words,
                    'count' => $word_count,
                    'secondsCount' => $seconds_count,
                    'imageCount' => $image_count
                );

                return $res;
            } else {
                $res = array(
                    'limit' => 0,
                    'count' => 0,
                    'secondsCount' => 0,
                    'imageCount' => 0
                );

                return $res;
            } 
        }
    }

    public static function userSubscription(){
        return UserSubscription::where('user_id', auth()->user()->id)->first();
    }

    public static function generate_more_words(){
        $current = Helper::content_generated();
        $subscription_status = Helper::has_active_subscription();

        if($current['limit'] == 0){
            //Unlimited content
            if($subscription_status == true){
                return true;
            } else {
                return false;
            }
        } else if($current['limit'] > 0){
            if($current['count'] >= $current['limit']){
                return false;
            } else {
                return true;
            }
        }
    }

    public static function user_subscription(){
        $query = UserSubscription::where('user_id', Auth::user()->id)
            ->join('subscription_plans', 'subscription_plans.id', '=', 'user_subscriptions.plan_id', 'left')
            ->where('user_subscriptions.recurring_at', '>=', date('Y-m-d H:i:s'))
            ->where('user_subscriptions.status', 'active')
            ->orderBy('user_subscriptions.recurring_at', 'desc')
            ->first();

        return $query;
    }

    public static function subscription(){
        return UserSubscription::with('plan')->where('user_id', Auth::user()->id)->first();
    }

    public static function formatMoney($amount_cents, $currency_code){
        // Convert the amount to the appropriate currency
        $currencies = new ISOCurrencies();
        $currency = new Currency($currency_code);
        $money = new Money($amount_cents, $currency);

        // Create the formatter and format the amount
        $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $currency_symbol = $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);

        $decimals = $currencies->subunitFor($currency);

        // Check if the currency has decimal places
        if ($decimals == 0) {
            $subunit = $currency_symbol;
        } else {
            $subunit = '¤';//$formatter->getSymbol(NumberFormatter::FRACTION_SYMBOL);
        }

        $moneyFormatter = new IntlMoneyFormatter($formatter, $currencies);
        $amount = $moneyFormatter->format($money);

        // Remove the currency symbol and convert to float
        $amount = (float) preg_replace('/[^0-9.,]/', '', $amount);

        // Round to the appropriate number of decimal places
        if ($decimals > 0) {
            $amount = round($amount, $decimals);
        }

        // Format the amount as a string
        $amount_str = number_format($amount, $decimals);

        // If you need to use the formatted amount in further calculations,
        // you can convert it back to cents using the following line of code
        //$amount_cents = (int) round($amount * pow(10, $decimals));

        // Add the currency symbol and subunit
        //$amount_str = $currency_symbol . $amount_str . $subunit;

        return $amount_str;
    }

    public static function getTrialDays(){
        if(Helper::is_trial_mode()){
            $start_date = Carbon::parse(Auth::user()->created_at);
            $end_date = $start_date->copy()->addDays(Helper::config('trial_period'));
            $end_date_formatted = $end_date->format('Y-m-d H:i:s');
            $days_between = $end_date->diffInDays($start_date);
        } else {
            $days = 0;
        }
    }

    public static function sendEmailToUser($templateName, $user, $contactForm = NULL)
    {
        if(Helper::config('smtp_email_active') == 1){
            $template = DB::table('email_templates')->where('name', $templateName)->first();
            $companyName = Helper::config('company_name');
            if(isset($user->current_plan)){
                $planName = $user->current_plan ? DB::table('subscription_plans')->where('id', $user->current_plan)->value('name') : '';
            } else {
                $planName = '';
            }

            if(isset($contactForm)){
                $details = $contactForm->details;
            } else {
                $details = '';
            }

            $passwordResetLink = '';
            $verificationLink = '';
            $userPasswordReset = DB::table('password_resets')->where('email', $user->email)->first();
            if ($userPasswordReset) {
                $passwordResetLink = $user->role == 'customer' ? url('reset-password/'.$userPasswordReset->token) : url('admin/reset-password/'.$userPasswordReset->token);
            }
            if($templateName == 'Verify Email'){
                $verificationLink = url('verify-email/'.$user->uuid);
            }
            $subject = str_replace(
                ['{firstName}', '{lastName}', '{email}', '{companyName}', '{plan}', '{passwordResetLink}','{verificationLink}', '{details}'],
                [$user->first_name, $user->last_name, $user->email, $companyName, $planName, $passwordResetLink, $verificationLink, $details],
                $template->subject
            );
            $body = str_replace(
                ['{firstName}', '{lastName}', '{email}', '{companyName}', '{plan}', '{passwordResetLink}','{verificationLink}', '{details}'],
                [$user->first_name, $user->last_name, $user->email, $companyName, $planName, $passwordResetLink, $verificationLink, $details],
                $template->body
            );

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
                    if($contactForm == NULL){
                        $mail->addAddress($user->email);
                    } else {
                        $mail->addAddress($contactForm->sendTo); 
                    }
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $body;
                    $mail->send();
                    //echo 'Email sent successfully.';
                } catch (Exception $e) {
                    //echo 'Failed to send email. Error message: ' . $mail->ErrorInfo;
                }
            } else {
                $email = new \SendGrid\Mail\Mail();
                $email->setFrom(Helper::config('smtp_sender_email'), Helper::config('smtp_sender_name'));
                $email->setSubject($subject);
                $email->addTo($user->email, $user->first_name);
                $email->addContent("text/html", $body);
                
                $sendgrid = new \SendGrid(Helper::config('email_provider_api_key'));
        
                try {
                    $response = $sendgrid->send($email);
                    return response()->json("Email sent successfully");
                } catch (Exception $e) {
                    return response()->json( 'Caught exception: '. $e->getMessage() ."\n");
                }
            }
        }
    }

    public static function checkoutAmount($amount, $discountCoupon){
        $totalDiscount = $amount * ($discountCoupon / 100);
        $amountPostDiscount = $amount - $totalDiscount;

        //Get Amount Less Discount and less inclusive taxes
        $totalInclTaxRates = $amountPostDiscount - ($amountPostDiscount / (1 + ($inclTaxRatesPercentage / 100)));
        $amountPostDiscountMinusTaxIncl = $amountPostDiscount - $totalInclTaxRates;

        //Get final amount
        return CurrencyHelper::format_number($amountPostDiscountMinusTaxIncl);
    }
}
