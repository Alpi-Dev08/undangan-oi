<?php

use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\Documentation\ReferencesController;
    use App\Http\Controllers\FileManagerController;
    use App\Http\Controllers\GeneralSettingsController;
    use App\Http\Controllers\Klinik\DiseasesController;
    use App\Http\Controllers\Klinik\ExaminationsController;
    use App\Http\Controllers\Klinik\HealthcareCategoriesController;
    use App\Http\Controllers\Klinik\HealthcaresController;
    use App\Http\Controllers\Klinik\HealthcareTypesController;
    use App\Http\Controllers\Klinik\HealthProfesionalsController;
    use App\Http\Controllers\Klinik\HealthProfesionalTypesController;
    use App\Http\Controllers\Klinik\LaboratoriesController;
    use App\Http\Controllers\Klinik\LaboratoryExaminationCategoriesController;
    use App\Http\Controllers\Klinik\LaboratoryExaminationsController;
    use App\Http\Controllers\Klinik\LaboratoryExaminationTypesController;
    use App\Http\Controllers\Klinik\LaboratoryUnitsController;
    use App\Http\Controllers\Klinik\PackagesController;
    use App\Http\Controllers\Klinik\PatientsController;
    use App\Http\Controllers\Klinik\ServiceTypesController;
    use App\Http\Controllers\Klinik\SocialActivitiesController;
    use App\Http\Controllers\Klinik\SocialActivityCategoriesController;
    use App\Http\Controllers\Klinik\SpecialitiesController;
    use App\Http\Controllers\Klinik\TransactionsController;
    use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\Master\BloodTypesController;
use App\Http\Controllers\Master\CardTypesController;
use App\Http\Controllers\Master\CitiesController;
use App\Http\Controllers\Master\CountriesController;
use App\Http\Controllers\Master\DistrictsController;
use App\Http\Controllers\Master\EducationsController;
use App\Http\Controllers\Master\GendersController;
use App\Http\Controllers\Master\MaritalStatusesController;
use App\Http\Controllers\Master\ProvincesController;
use App\Http\Controllers\Master\RelationshipStatusesController;
use App\Http\Controllers\Master\ReligionsController;
use App\Http\Controllers\Master\SubDistrictsController;
use App\Http\Controllers\Master\WorksController;
    use App\Http\Controllers\NakesController;
    use App\Http\Controllers\PagesController;
    use App\Http\Controllers\PermissionsController;
    use App\Http\Controllers\RolesController;
    use App\Http\Controllers\UsersController;
    use App\Models\Klinik\HealthcareType;
    use App\Models\Klinik\HealthProfesional;
    use App\Models\Klinik\HealthProfesionalType;
    use App\Models\Klinik\LaboratoryExaminationCategory;
    use App\Models\Klinik\SocialActivityCategory;
    use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return redirect('index');
// });

$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);

        // Exclude documentation from auth middleware
        if (!Str::contains($val['path'], 'documentation')) {
            $route->middleware('auth');
        }
    }
});

// Documentations pages
Route::prefix('documentation')->group(function () {
    Route::get('getting-started/changelog', [PagesController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    // Account pages
    Route::prefix('account')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('setting/nakes', [SettingsController::class, 'nakes'])->name('settings.nakes');
        Route::get('examinations', [SettingsController::class, 'examinations'])->name('settings.examinations');
        Route::post('examinations', [SettingsController::class, 'createExamination'])->name('settings.create.examination');
        Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
        Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');

        Route::get('payments', [SettingsController::class, 'payments'])->name('settings.payment');
        Route::post('payments', [SettingsController::class, 'createPayment'])->name('settings.create.payment');
    });

    //User Management
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::resource('users', UsersController::class);

    //Masters Data
    Route::prefix('masters')->group(function () {
        Route::resource('religions', ReligionsController::class);
        Route::resource('genders', GendersController::class);
        Route::resource('works', WorksController::class);
        Route::resource('educations', EducationsController::class);
        Route::resource('bloodtypes', BloodTypesController::class);
        Route::resource('maritalstatuses', MaritalStatusesController::class);
        Route::resource('relationshipstatuses', RelationshipStatusesController::class);
        Route::resource('countries', CountriesController::class);
        Route::resource('cardtypes', CardTypesController::class);
        Route::resource('provinces', ProvincesController::class);
        Route::get('province-country',[ProvincesController::class,'getProvinceByCountryId']);
        Route::resource('cities', CitiesController::class);
        Route::get('city-province',[CitiesController::class,'getCityByProvinceId']);
        Route::resource('districts', DistrictsController::class);
        Route::get('district-city',[DistrictsController::class,'getDistrictByCityId']);
        Route::resource('subdistricts', SubDistrictsController::class);
        Route::get('district-sub',[SubDistrictsController::class,'getSubDistrictByCityId']);
    });

    //Masters Data
    Route::prefix('klinik')->group(function () {
        Route::resource('healthcarecategories', HealthcareCategoriesController::class);
        Route::resource('healthcaretypes', HealthcareTypesController::class);
        Route::resource('healthcares', HealthcaresController::class);
        Route::resource('healthprofesionaltypes', HealthProfesionalTypesController::class);
        Route::resource('healthprofesionals', HealthProfesionalsController::class);
        Route::resource('patients', PatientsController::class);
        Route::post('patients/generate-barcode', [PatientsController::class, 'barcode'])->name('patients.barcode');
        Route::resource('specialities', SpecialitiesController::class);
        Route::resource('diseases', DiseasesController::class);
        Route::resource('examinations', ExaminationsController::class);
        Route::get('examinations-service', [ExaminationsController::class, 'services'])->name('examinations.services');
        Route::get('examinations-invoice', [ExaminationsController::class, 'invoice'])->name('examinations.invoice');
        Route::get('examinations-payments', [ExaminationsController::class, 'payments'])->name('examinations.payment');
        Route::post('examinations-payments', [ExaminationsController::class, 'createPayment'])->name('examinations.create.payment');
        Route::resource('transactions', TransactionsController::class);
        Route::get('examinations-vitality', [ExaminationsController::class, 'vitality'])->name('examinations.vitality');
        Route::POST('examinations-service-store', [ExaminationsController::class, 'storeservices'])->name('examinations.storeservices');

        Route::resource('servicecategories', \App\Http\Controllers\Klinik\ServiceCategoriesController::class);
        Route::resource('services', \App\Http\Controllers\Klinik\ServicesController::class);
        Route::resource('vitalityexaminations', \App\Http\Controllers\Klinik\VitalityExaminationsController::class);
        Route::resource('anamnesiscategories', \App\Http\Controllers\Klinik\AnamnesisCategoriesController::class);
        Route::resource('anamnesis', \App\Http\Controllers\Klinik\AnamnesisController::class);
        Route::resource('physicalcategories', \App\Http\Controllers\Klinik\PhysicalCategoriesController::class);
    });


    // Logs pages
    Route::prefix('log')->name('log.')->group(function () {
        Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
        Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
    });
});
/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);

require __DIR__.'/auth.php';
