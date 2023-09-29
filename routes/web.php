<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PromptTemplateController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\TestimonialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/install/check-db', [App\Http\Controllers\Installer::class, 'checkConnectDatabase']);

Route::prefix('/')->middleware(['check-db-connection'])->group(function () {
    Route::match(['get', 'post'], '/', [App\Http\Controllers\FrontendController::class, 'index']);
    Route::match(['get', 'post'], 'pricing', [App\Http\Controllers\FrontendController::class, 'pricing']);
    Route::match(['get', 'post'], 'contact-us', [App\Http\Controllers\FrontendController::class, 'contact']);
    Route::match(['get', 'post'], 'terms', [App\Http\Controllers\FrontendController::class, 'terms']);
    Route::match(['get', 'post'], 'privacy', [App\Http\Controllers\FrontendController::class, 'privacy']);

    Route::match(['get', 'post'], 'webhook/{processor}', [App\Http\Controllers\WebhookController::class, 'processWebhook']);

    Route::match(['get', 'post'], 'login', [App\Http\Controllers\User\AuthController::class, 'login'])->name('login');
    Route::match(['get', 'post'], 'forgot-password', [App\Http\Controllers\User\AuthController::class, 'forgot']);
    Route::match(['get', 'post'], 'reset-password/{token}', [App\Http\Controllers\User\AuthController::class, 'resetPassword'])->name('password.reset');
    Route::match(['get', 'post'], 'signup', [App\Http\Controllers\User\AuthController::class, 'signup']);
    Route::get('plans/price/{id}', [App\Http\Controllers\User\AuthController::class, 'get_price']);
    Route::get('/google/login', [App\Http\Controllers\User\AuthController::class, 'googleLogin'])->name('google.login');
    Route::get('/google/callback', [App\Http\Controllers\User\AuthController::class, 'googleCallback'])->name('google.callback');
    Route::get('/facebook/login', [App\Http\Controllers\User\AuthController::class, 'redirectToFacebook']);
    Route::get('/facebook/callback', [App\Http\Controllers\User\AuthController::class, 'handleFacebookCallback']);
    Route::get('forgot-password', [App\Http\Controllers\User\AuthController::class, 'forgot']);
    Route::get('logout', [App\Http\Controllers\User\AuthController::class, 'logout']);
    Route::get('lang/{locale}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
    Route::get('verify-email/{uuid?}', [App\Http\Controllers\User\DashboardController::class, 'verify_email'])->name('verify-email');
    Route::get('resend-verification-email', [App\Http\Controllers\User\DashboardController::class, 'resend_verification_email']);

    Route::middleware(['auth', 'role:customer'])->group(function () {
        Route::middleware(['verified'])->group(function () {
            Route::get('dashboard', [App\Http\Controllers\User\DashboardController::class, 'index']);
            Route::get('update-counts', [App\Http\Controllers\User\DashboardController::class, 'update_counts']);
            Route::get('/prompts', [App\Http\Controllers\User\DocumentController::class, 'prompts'])->name('prompts_user');
            Route::get('/prompts/sort', [App\Http\Controllers\User\DocumentController::class, 'sort'])->name('templates.sort');
            Route::get('/filterProjectTemplates', [App\Http\Controllers\User\DocumentController::class, 'filter_bysub']);
            Route::get('/subcategories', [PromptTemplateController::class, 'getSubcategories']);
            
            Route::match(['get', 'post'], '/prompts/add/token/{token}/{amount}', [App\Http\Controllers\User\DocumentController::class, 'addToken'])->name('add.token');
            Route::post('/add-token-details', [App\Http\Controllers\User\DocumentController::class, 'addTokenDetails'])->name('add.token.details');
            Route::get('/add-token-details-token', [App\Http\Controllers\User\DocumentController::class, 'addTokenDetailsToken'])->name('add.token.details');

            Route::get('documents', [App\Http\Controllers\User\DocumentController::class, 'index']);
            Route::get('audios', [App\Http\Controllers\User\AudioController::class, 'index']);

            Route::post('/subscription',  [App\Http\Controllers\User\SubscriptionController::class, 'index']);

            Route::get('templates/{category?}', [App\Http\Controllers\User\DashboardController::class, 'templates']);
            Route::get('template/mark-as-favorite/{id}', [App\Http\Controllers\User\DashboardController::class, 'mark_as_favorite'])->name('favorite.template');
            Route::get('templates-search/{category?}', [App\Http\Controllers\User\DashboardController::class, 'search_template']);
            Route::get('templates-searchby/{subcategory?}', [App\Http\Controllers\User\DashboardController::class, 'search_bysub']);

            Route::match(['get', 'post'], 'project/create/{id}', [App\Http\Controllers\User\ProjectController::class, 'create']);
            Route::match(['get', 'post'], 'projects/search', [App\Http\Controllers\User\ProjectController::class, 'search']);
            Route::get('project/{id}', [App\Http\Controllers\User\ProjectController::class, 'view']);
            Route::post('project/{uuid}/edit', [App\Http\Controllers\User\ProjectController::class, 'update_project']);
            Route::get('project/{uuid}/generate', [App\Http\Controllers\User\ProjectController::class, 'generate_content']);
            Route::post('project/{uuid}/update-content', [App\Http\Controllers\User\ProjectController::class, 'update_workspace_content']);
            Route::get('project/content/{id}/delete', [App\Http\Controllers\User\ProjectController::class, 'delete_content']);
            Route::get('project/content/{id}/save', [App\Http\Controllers\User\ProjectController::class, 'save_content']);
            Route::get('project/delete/{uuid}', [App\Http\Controllers\User\ProjectController::class, 'delete_project']);
            Route::get('project/export/{uuid}/{type}', [App\Http\Controllers\User\ProjectController::class, 'export_project']);

            Route::get('ai-images', [App\Http\Controllers\User\ImageController::class, 'index']);
            Route::match(['get', 'post'], 'images/search', [App\Http\Controllers\User\ImageController::class, 'search']);
            Route::post('image/create', [App\Http\Controllers\User\ImageController::class, 'create']);
            Route::get('image/{uuid}/{id}', [App\Http\Controllers\User\ImageController::class, 'view']);
            Route::delete('image/{id}', [App\Http\Controllers\User\ImageController::class, 'delete']);
            Route::get('image-download/{id}', [App\Http\Controllers\User\ImageController::class, 'download']);
            Route::post('image/{uuid}', [App\Http\Controllers\User\ImageController::class, 'update_project']);

            Route::post('audio/create', [App\Http\Controllers\User\AudioController::class, 'create']);
            Route::match(['get', 'post'], 'audios/search', [App\Http\Controllers\User\AudioController::class, 'search']);
            Route::post('audio/{uuid}', [App\Http\Controllers\User\AudioController::class, 'update_project']);
            Route::get('audio/{uuid}', [App\Http\Controllers\User\AudioController::class, 'view']);

            Route::get('chat', [App\Http\Controllers\User\ChatController::class, 'index']);
            Route::post('chat', [App\Http\Controllers\User\ChatController::class, 'processMessage']);
            Route::post('chat-personality', [App\Http\Controllers\User\ChatController::class, 'changePersonality'])->name('chat.personality');
            
            Route::match(['get', 'post'], 'settings', [App\Http\Controllers\User\SettingController::class, 'index']);
            Route::post('change-password', [App\Http\Controllers\User\SettingController::class, 'password']);
        
            //Billing
            Route::get('billing', [App\Http\Controllers\User\SettingController::class, 'billing']);
            Route::get('invoice/{id}', [App\Http\Controllers\User\BillingController::class, 'view_invoice']);
            Route::match(['get', 'post'], 'pay/{id}/{period}', [App\Http\Controllers\User\BillingController::class, 'pay']);
            Route::match(['get', 'post'], 'add-coupon/{id}/{period}', [App\Http\Controllers\User\BillingController::class, 'add_coupon']);
            Route::match(['get', 'post'], 'remove-coupon/{id}/{period}', [App\Http\Controllers\User\BillingController::class, 'remove_coupon']);

            Route::get('/approval', [App\Http\Controllers\User\SubscriptionController::class, 'approval'])->name('approval');
            Route::get('/cancelled', [App\Http\Controllers\User\SubscriptionController::class, 'cancelled'])->name('cancelled');
        });
    });
});

Route::prefix('admin')->middleware(['check-db-connection'])->group(function () {
    Route::match(['get', 'post'], 'login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
    Route::match(['get', 'post'], 'forgot-password', [App\Http\Controllers\Admin\AuthController::class, 'forgot']);
    Route::match(['get', 'post'], 'reset-password/{token}', [App\Http\Controllers\Admin\AuthController::class, 'resetPassword'])->name('password.reset');
    Route::get('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout']);

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::match(['get', 'post'],'contacts/add', [ContactController::class, 'add']);
        Route::match(['get', 'post'],'contacts/groups/add', [ContactController::class, 'add_group']);

        Route::get('subscriptions', [SubscriptionController::class, 'index']);
        Route::match(['get', 'post'], 'subscriptions/search', [SubscriptionController::class, 'search']);
        Route::match(['get', 'post'], 'subscriptions/edit/{userId}', [SubscriptionController::class, 'edit']);

        Route::get('billing', [BillingController::class, 'index']);
        Route::match(['get', 'post'], 'billing/search', [BillingController::class, 'search']);

        Route::get('templates', [TemplateController::class, 'index']);
        Route::match(['get', 'post'],'templates/add', [TemplateController::class, 'add']);

        Route::match(['get', 'post'], 'settings/general', [SettingController::class, 'general']);
        Route::post('settings/contacts', [SettingController::class, 'contacts']);
        Route::post('settings/upload/{type}', [SettingController::class, 'upload']);
        Route::match(['get', 'post'], 'settings/smtp', [SettingController::class, 'smtp']);
        Route::post('settings/test-email', [SettingController::class, 'test_email']);

        //Customers
        Route::get('customers', [CustomerController::class, 'index']);
        Route::match(['get', 'post'], 'customers/search', [CustomerController::class, 'search']);
        Route::get('customers/add', [CustomerController::class, 'create']);
        Route::post('customers/add', [CustomerController::class, 'store']);
        Route::get('customers/edit/{id}', [CustomerController::class, 'edit']);
        Route::post('customers/edit/{id}', [CustomerController::class, 'editUser']);
        Route::get('customers/deactivate/{id}', [CustomerController::class, 'deactivate']);
        Route::get('customers/activate/{id}', [CustomerController::class, 'activate']);
        Route::get('customers/delete/{id}', [CustomerController::class, 'delete']);

        //Email Templates
        Route::get('settings/email-templates', [EmailTemplateController::class, 'index']);
        Route::get('settings/email-templates/edit/{id}', [EmailTemplateController::class, 'edit']);
        Route::post('settings/email-templates/edit/{id}', [EmailTemplateController::class, 'editTemplate']);

        //Pages Templates
        Route::get('settings/pages', [PageController::class, 'index']);
        Route::match(['get', 'post'], 'settings/pages/edit/{id}', [PageController::class, 'edit']);
        Route::get('settings/pages/reset/{id}', [PageController::class, 'reset']);

        //Testimonials
        Route::get('settings/testimonials', [TestimonialController::class, 'index']);
        Route::match(['get', 'post'], 'settings/testimonials/add', [TestimonialController::class, 'create']);
        Route::match(['get', 'post'], 'settings/testimonials/edit/{id}', [TestimonialController::class, 'edit']);
        Route::get('settings/testimonials/delete/{id}', [TestimonialController::class, 'delete']);

        //Subscription Plans
        Route::get('settings/plans', [SubscriptionPlanController::class, 'index']);
        Route::get('settings/plans/add', [SubscriptionPlanController::class, 'create']);
        Route::post('settings/plans/add', [SubscriptionPlanController::class, 'store']);
        Route::get('settings/plans/edit/{id}', [SubscriptionPlanController::class, 'edit']);
        Route::post('settings/plans/edit/{id}', [SubscriptionPlanController::class, 'editPlan']);
        Route::get('settings/plans/popularize/{id}', [SubscriptionPlanController::class, 'popularize']);
        Route::get('settings/plans/deactivate/{id}', [SubscriptionPlanController::class, 'deactivate']);
        Route::get('settings/plans/activate/{id}', [SubscriptionPlanController::class, 'activate']);
        Route::get('settings/plans/delete/{id}', [SubscriptionPlanController::class, 'delete']);
        Route::get('settings/plans/price/{id}', [SubscriptionPlanController::class, 'get_price']);

        //Teams
        Route::get('settings/team', [TeamController::class, 'index']);
        Route::get('settings/team/add', [TeamController::class, 'create']);
        Route::post('settings/team/add', [TeamController::class, 'store']);
        Route::get('settings/team/edit/{id}', [TeamController::class, 'edit']);
        Route::post('settings/team/edit/{id}', [TeamController::class, 'editUser']);
        Route::get('settings/team/deactivate/{id}', [TeamController::class, 'deactivate']);
        Route::get('settings/team/activate/{id}', [TeamController::class, 'activate']);
        Route::get('settings/team/delete/{id}', [TeamController::class, 'delete']);

        //Billing
        Route::match(['get', 'post'], 'settings/billing-info', [SettingController::class, 'billing']);

        //Tax Rates
        Route::match(['get', 'post'], 'settings/tax-rates', [TaxController::class, 'index']);
        Route::match(['get', 'post'], 'settings/tax-rates/add', [TaxController::class, 'create']);
        Route::match(['get', 'post'], 'settings/tax-rates/edit/{id}', [TaxController::class, 'edit']);
        Route::get('settings/tax-rates/deactivate/{id}', [TaxController::class, 'deactivate']);
        Route::get('settings/tax-rates/activate/{id}', [TaxController::class, 'activate']);
        Route::get('settings/tax-rates/delete/{id}', [TaxController::class, 'delete']);

        //Coupons
        Route::match(['get', 'post'], 'settings/coupons', [CouponController::class, 'index']);
        Route::match(['get', 'post'], 'settings/coupons/add', [CouponController::class, 'create']);
        Route::match(['get', 'post'], 'settings/coupons/edit/{id}', [CouponController::class, 'edit']);
        Route::get('settings/coupons/deactivate/{id}', [CouponController::class, 'deactivate']);
        Route::get('settings/coupons/activate/{id}', [CouponController::class, 'activate']);
        Route::get('settings/coupons/delete/{id}', [CouponController::class, 'delete']);

        //AI Prompts
        Route::get('settings/prompt-categories', [CategoryController::class, 'index']);
        Route::get('prompt-categories-list', [CategoryController::class, 'show'])->name('list_cat');
        Route::post('settings/prompt-categories/add', [CategoryController::class, 'create'])->name('category.store');
        Route::match(['get', 'post'], 'settings/prompt-categories/edit/{id}', [CategoryController::class, 'update']);
        Route::match(['get', 'post'], 'settings/prompt-categories/delete/{id}', [CategoryController::class, 'delete']);
        Route::match(['get', 'post'], 'settings/prompt-sub-categories/add', [SubCategoryController::class, 'create']);
        Route::get('settings/prompt-sub-categories/list/{id}', [SubCategoryController::class, 'list'])->name('subcategory_list');
        Route::match(['get', 'post'], 'settings/prompt-subcategories/edit/{id}', [SubCategoryController::class, 'update']);
        Route::match(['get', 'post'], 'settings/prompt-subcategories/delete/{id}', [SubCategoryController::class, 'delete']);
        
        //AI Chat
        Route::get('settings/chat', [App\Http\Controllers\User\ChatController::class, 'index']);
        Route::post('settings/chat', [App\Http\Controllers\User\ChatController::class, 'processMessage']);
        Route::post('settings/chat-personality', [App\Http\Controllers\User\ChatController::class, 'changePersonality'])->name('chat.personality');
        

        Route::get('settings/prompts', [PromptTemplateController::class, 'index']);
        Route::get('getSubcategories', [PromptTemplateController::class, 'getSubcategories'])->name('subcategories_get');
        Route::post('prompts/search', [PromptTemplateController::class, 'search'])->name('prompt_search');
        Route::get('settings/prompts-list', [PromptTemplateController::class, 'show_prompt'])->name('show_prompt'); 
        Route::get('settings/import/prompts', [PromptTemplateController::class, 'import_prompt'])->name('import_prompt');
        Route::post( 'settings/prompts/bulk/add', [PromptTemplateController::class, 'bulk_create'])->name('prompt.bulk.add');
        Route::match(['get', 'post'], 'settings/prompts/add', [PromptTemplateController::class, 'create']);
        Route::match(['get', 'post'], 'settings/prompts/edit/{id}', [PromptTemplateController::class, 'update']);
        Route::match(['get', 'post'], 'settings/prompts/delete/{id}', [PromptTemplateController::class, 'delete']);
        
        //Newly added
        Route::get('settings/prompts/check/free', [SubscriptionPlanController::class, 'plan_check'])->name('prompt.plan.check');
        Route::post('settings/prompts/bulk/delete', [PromptTemplateController::class, 'bulk_delete'])->name('prompt.bulk.delete');

        Route::get('settings/integrations', [SettingController::class, 'integrations']);
        Route::match(['get', 'post'], 'settings/integrations/{id}', [SettingController::class, 'update_integration']);
        Route::post('settings/integrations/{id}/status', [SettingController::class, 'update_integration']);
        Route::get('settings/integrations/plan-subscription-id/{id}', [SettingController::class, 'check_plan_subscription_ids']);
    });
});