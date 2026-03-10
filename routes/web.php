<?php

    use App\Http\Controllers\Account\SettingsController;
    use App\Http\Controllers\Logs\AuditLogsController;
    use App\Http\Controllers\Logs\SystemLogsController;
    use App\Http\Controllers\PermissionsController;
    use App\Http\Controllers\RolesController;
    use App\Http\Controllers\UsersController;
    use Illuminate\Support\Facades\Route; 
    use Modules\Dashboard\App\Http\Controllers\DashboardController;

    use App\Http\Controllers\Master\KategoriWebsiteController;
    use App\Http\Controllers\Master\KategoriVideoController;

    use App\Http\Controllers\Master\TemplateWebsiteController;
    use App\Http\Controllers\DemoController;

    use App\Http\Controllers\Master\TemplateVideoController;
    use App\Http\Controllers\Master\FiturController;
    use App\Http\Controllers\Master\PaketController;
 
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

    Route::get('/',[DashboardController::class,'index']);
    Route::get('/',[DashboardController::class,'index']);

    // Documentations pages
    Route::prefix('documentation')->group(function () {
        Route::get('getting-started/changelog', [PagesController::class, 'index']);
    });

    Route::middleware('auth')->group(function () {

        Route::get('/kyc_url', [KycController::class,'index'])->name('kycurl');
        // Account pages
        Route::prefix('account')->group(function () {
            Route::get('overview', [SettingsController::class, 'index'])->name('settings.index');
            Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
            Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
            Route::put('setting/nakes', [SettingsController::class, 'nakes'])->name('settings.nakes');
            Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
            Route::put('settings/password', [SettingsController::class, 'changePassword'])
                 ->name('settings.changePassword');
        });

        //User Management
        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
        Route::resource('users', UsersController::class);

        //Masters Data
        Route::prefix('masters')->group(function () {
            Route::resource('kategori_web', KategoriWebsiteController::class);
            Route::resource('kategori_video', KategoriVideoController::class);

            Route::resource('template_web', TemplateWebsiteController::class);
            //Route::get('/demo/{slug}', [DemoController::class, 'show'])->name('demo.template');

            Route::resource('template_video', TemplateVideoController::class);

            Route::resource('fitur', FiturController::class);
            Route::resource('paket', PaketController::class);
        });
 
        //Masters Data
        Route::prefix('klinik')->group(callback: function () {

        });
        
        // Logs pages
        Route::prefix('log')->name('log.')->group(function () {
            Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
            Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
        });
    });

    require __DIR__ . '/auth.php';
