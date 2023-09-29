<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailSeeder extends Seeder
{
    public function run()
    {
        DB::table('email_templates')->insert([
            [
                'id' => 1,
                'name' => 'Reset Password',
                'subject' => 'Reset Your Password',
                'body' => 'Hi {firstName},<br><br>You have submitted a password reset for your account. If this was not you, simply ignore this email. But if you did, click on this link {passwordResetLink} to reset your password. If that doesn\'t work, copy and paste this link to your browser.',
                'modified_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Password Reset Notification',
                'subject' => 'Your Password has been reset',
                'body' => 'Hi {firstName},<br><br>Your password has been reset successfully!',
                'modified_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Registration',
                'subject' => 'Welcome to our AI-powered content writing platform!',
                'body' => 'Hi {firstName},<br><br>Welcome to {companyName}. Our AI-powered content writing platform creates personalized, high-quality content that engages your audience and drives traffic to your website. Whether you need blog posts, social media updates, or product descriptions, our platform has got you covered. With our time-saving content creation and SEO optimization, you can focus on other aspects of your business while we help you grow. Our team of experts is always here to help. Thank you for choosing our platform!',
                'modified_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'id' => 4,
                'name' => 'Subscription Payment',
                'subject' => 'You\'ve paid your subscription successfully!',
                'body' => 'Hi {firstName},<br><br>Your payment for subscription plan {plan} has been received successfully. You can continue enjoying our services.<br><br>Best regards,',
                'modified_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Contact Us - Admin',
                'subject' => 'New Enquiry From {email}',
                'body' => 'Hi,<br><br>You have received a new contact request from:<br><br>Name: {firstName} {lastName}<br>Email : {email}<br>Details : {details}<br><br>Best regards,',
                'modified_at' => Carbon::now(),
                'modified_by' => 1,
            ],
            [
                'id' => 6,
                'name' => 'Contact Us - Customer',
                'subject' => 'Your Enquiry to {companyName}',
                'body' => 'Hi {firstName},<br><br>You have created the following request to {companyName}:<br><br>Name: {firstName} {lastName}<br>Email : {email}<br>Details : {details}<br><br>Best regards,',
                'modified_at' => Carbon::now(),
                'modified_by' => 1,
            ],
        ]);
    }
}
