<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\ExpertiseAreaController;

use App\Models\RoleRoute;

function getRoleName($routeName)
{
    $routesData = RoleRoute::where('route_name', $routeName)->get();
    $result = [];
    foreach ($routesData as $routeData) {
        array_push($result, $routeData->role_name);
    }
    return $result;
}
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

Route::get('/visitor-info', function (Request $request) {
    $ipAddress = $request->ip();
    $port = $_SERVER['SERVER_PORT'];

    $client = new Client();
    $response = $client->get("https://ipinfo.io/{$ipAddress}/json");
    $ispDetails = json_decode($response->getBody(), true);

    return response()->json([
        'ip' => $ipAddress,
        'port' => $port,
        'isp' => $ispDetails['org'] ?? 'Unknown'
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'about'])->name('about.us');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact.us');
Route::get('/works', [HomeController::class, 'works'])->name('works');
Route::get('/blogs', [HomeController::class, 'blog'])->name('blog');


Route::get('/error', function () {
    return view('errors.404');
});



Route::get('/privacy-policy', [PrivacyController::class, 'page_view'])->name('privacy.view');
Route::get('/terms-and-condition', [PrivacyController::class, 'condition_page_view'])->name('condition.view');

Route::prefix('profile')->group(function () {
    Route::get('/', [HomeController::class, 'profileView'])->name('profile.view');
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('migrate', function() {
        $exitCode = Artisan::call('migrate');

        if ($exitCode === 0) {
            $output = Artisan::output();
            return response()->json(['status' => 'success', 'message' => $output]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Migration failed'], 500);
        }
    })->name('migrate');
    Route::get('migrate-rollback', function() {
        $exitCodeRollBack = Artisan::call('migrate:rollback');

        if ($exitCodeRollBack === 0) {
            $output = Artisan::output();
            return response()->json(['status' => 'success', 'message' => $output]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Migration failed'], 500);
        }
    })->name('migrate-rollback');
    Route::get('clear',function() {
        Artisan::call('optimize:clear');
        flash()->success('Cache Clear', 'Cache clear successfully');
        return redirect()->back();
//    dd('cleared');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/backup', [SettingController::class, 'backup'])->name('database.backup');
        Route::get('/visitor-info', [SettingController::class, 'visitor'])->name('visitor.info');
        Route::get('/smtp', [SettingController::class, 'smtp'])->name('setting.smtp');
        Route::post('/smtp-update', [SettingController::class, 'smtpUpdate'])->name('setting.smtp-update');
        Route::post('/test-mail', [SettingController::class, 'testMail'])->name('test.mail');
        Route::middleware(['roles'])->group(function () {
            Route::group(['prefix' => 'role', 'as' => 'role.'], function(){
                Route::get('/add', [RoleController::class, 'index'])->name('add');
                Route::post('/new', [RoleController::class, 'create'])->name('new');
                Route::get('/manage', [RoleController::class, 'manage'])->name('manage');
                Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
                Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
            });

            Route::prefix('user')->group(function () {
                Route::get('/add', [UserController::class, 'index'])->name('user.add');
                Route::post('/new', [UserController::class, 'create'])->name('user.new');
                Route::get('/manage', [UserController::class, 'manage'])->name('user.manage');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
                Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
                Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
            });
            Route::prefix('slider')->group(function () {
                Route::get('/add', [SliderController::class, 'index'])->name('slider.add');
                Route::post('/new', [SliderController::class, 'create'])->name('slider.new');
                Route::get('/manage', [SliderController::class, 'manage'])->name('slider.manage');
                Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
                Route::post('/update/{id}', [SliderController::class, 'update'])->name('slider.update');
                Route::get('/delete/{id}', [SliderController::class, 'delete'])->name('slider.delete');
            });
            Route::prefix('category')->group(function () {
                Route::get('/add', [CategoryController::class, 'index'])->name('category.add');
                Route::post('/new', [CategoryController::class, 'create'])->name('category.new');
                Route::get('/manage', [CategoryController::class, 'manage'])->name('category.manage');
                Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
                Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
                Route::post('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
            });
            Route::prefix('privacy')->group(function () {
                Route::get('/add', [PrivacyController::class, 'index'])->name('privacy.add');
                Route::post('/new', [PrivacyController::class, 'create'])->name('privacy.new');
                Route::get('/manage', [PrivacyController::class, 'manage'])->name('privacy.manage');
                Route::get('/edit/{id}', [PrivacyController::class, 'edit'])->name('privacy.edit');
                Route::post('/update/{id}', [PrivacyController::class, 'update'])->name('privacy.update');
                Route::post('/delete/{id}', [PrivacyController::class, 'delete'])->name('privacy.delete');
            });
            Route::prefix('work-experience')->group(function () {
                Route::get('/add', [WorkExperienceController::class, 'index'])->name('experience.add');
                Route::post('/new', [WorkExperienceController::class, 'create'])->name('experience.new');
                Route::get('/manage', [WorkExperienceController::class, 'manage'])->name('experience.manage');
                Route::get('/edit/{id}', [WorkExperienceController::class, 'edit'])->name('experience.edit');
                Route::post('/update/{id}', [WorkExperienceController::class, 'update'])->name('experience.update');
                Route::post('/delete/{id}', [WorkExperienceController::class, 'delete'])->name('experience.delete');
            });
            Route::prefix('expertise-area')->group(function () {
                Route::get('/add', [ExpertiseAreaController::class, 'index'])->name('expertise-area.add');
                Route::post('/new', [ExpertiseAreaController::class, 'create'])->name('expertise-area.new');
                Route::get('/manage', [ExpertiseAreaController::class, 'manage'])->name('expertise-area.manage');
                Route::get('/edit/{id}', [ExpertiseAreaController::class, 'edit'])->name('expertise-area.edit');
                Route::post('/update', [ExpertiseAreaController::class, 'update'])->name('expertise-area.update');
                Route::post('/delete/{id}', [ExpertiseAreaController::class, 'delete'])->name('expertise-area.delete');
            });
        });
    });

