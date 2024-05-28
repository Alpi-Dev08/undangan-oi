<?php

    use App\Http\Controllers\Account\SettingsController;
    use App\Http\Controllers\Auth\SocialiteLoginController;
    use App\Http\Controllers\Klinik\AdditionalExaminationsController;
    use App\Http\Controllers\Klinik\AnamnesisCategoriesController;
    use App\Http\Controllers\Klinik\AnamnesisController;
    use App\Http\Controllers\Klinik\AnamnesisExaminationsController;
    use App\Http\Controllers\Klinik\AppointmentsController;
    use App\Http\Controllers\Klinik\DiseasesController;
    use App\Http\Controllers\Klinik\DrugsController;
    use App\Http\Controllers\Klinik\ExaminationsController;
    use App\Http\Controllers\Klinik\HealthcareCategoriesController;
    use App\Http\Controllers\Klinik\HealthcaresController;
    use App\Http\Controllers\Klinik\HealthcareTypesController;
    use App\Http\Controllers\Klinik\HealthProfesionalsController;
    use App\Http\Controllers\Klinik\HealthProfesionalTypesController;
    use App\Http\Controllers\Klinik\LaboratoryExaminationsController;
    use App\Http\Controllers\Klinik\LocationsController;
    use App\Http\Controllers\Klinik\OrganizationController;
    use App\Http\Controllers\Klinik\OtherExaminationsController;
    use App\Http\Controllers\Klinik\PackagesController;
    use App\Http\Controllers\Klinik\PatientsController;
    use App\Http\Controllers\Klinik\PhysicalCategoriesController;
    use App\Http\Controllers\Klinik\PhysicalExaminationsController;
    use App\Http\Controllers\Klinik\PhysicalsController;
    use App\Http\Controllers\Klinik\ServiceCategoriesController;
    use App\Http\Controllers\Klinik\ServicesController;
    use App\Http\Controllers\Klinik\SpecialitiesController;
    use App\Http\Controllers\Klinik\TransactionsController;
    use App\Http\Controllers\Klinik\UnitController;
    use App\Http\Controllers\Klinik\VitalityExaminationsController;
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
    use App\Http\Controllers\PagesController;
    use App\Http\Controllers\PermissionsController;
    use App\Http\Controllers\RolesController;
    use App\Http\Controllers\UsersController;
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

    Route::get('bukti-penyampaian-informasi/{id}', [PagesController::class, 'bukti_penyampaian_informasi'])->name('buktipenyampaianinformasi');
    Route::post('bukti-penyampaian-informasi', [PagesController::class, 'store_bukti_penyampaian_informasi'])->name('buktipenyampaianinformasi.store');
    Route::get('bukti-penyampaian/{id}', [PagesController::class, 'get_bukti_penyampaian_informasi'])->name('bukti_penyampaian');

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
            Route::post('examinations', [SettingsController::class, 'createExamination'])
                 ->name('settings.create.examination');
            Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
            Route::put('settings/password', [SettingsController::class, 'changePassword'])
                 ->name('settings.changePassword');

            Route::get('payments', [SettingsController::class, 'payments'])->name('settings.payment');
            Route::post('payments', [SettingsController::class, 'createPayment'])->name('settings.create.payment');

            Route::get('appointments', [SettingsController::class, 'appointments'])->name('settings.appointments');
            Route::post('appointments', [SettingsController::class, 'createAppointment'])
                 ->name('settings.create.appointment');
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
            Route::get('province-country', [ProvincesController::class, 'getProvinceByCountryId']);
            Route::resource('cities', CitiesController::class);
            Route::get('city-province', [CitiesController::class, 'getCityByProvinceId']);
            Route::resource('districts', DistrictsController::class);
            Route::get('district-city', [DistrictsController::class, 'getDistrictByCityId']);
            Route::resource('subdistricts', SubDistrictsController::class);
            Route::get('district-sub', [SubDistrictsController::class, 'getSubDistrictByCityId']);
        });

        //Masters Data
        Route::prefix('klinik')->group(callback: function () {
            Route::resource('healthcarecategories', HealthcareCategoriesController::class);
            Route::resource('healthcaretypes', HealthcareTypesController::class);
            Route::resource('healthcares', HealthcaresController::class);
            Route::resource('healthprofesionaltypes', HealthProfesionalTypesController::class);
            Route::resource('healthprofesionals', HealthProfesionalsController::class);
            Route::resource('patients', PatientsController::class);
            Route::get('patients/print/{id}', [PatientsController::class, 'print'])->name('patients.print');
            Route::post('patients/pretest', [PatientsController::class, 'pretest'])->name('patients.pretest');
            Route::post('patients/check-nik', [PatientsController::class, 'check_nik'])->name('patients.ceknik');

            Route::resource('specialities', SpecialitiesController::class);
            Route::resource('diseases', DiseasesController::class);
            Route::resource('examinations', ExaminationsController::class);
            Route::get('examinations-service', [ExaminationsController::class, 'services'])
                 ->name('examinations.services');
            Route::get('examinations-pdf', [ExaminationsController::class, 'pdf'])->name('examinations.pdf');
            Route::get('examinations-invoice', [ExaminationsController::class, 'invoice'])
                 ->name('examinations.invoice');
            Route::get('examinations-payments', [ExaminationsController::class, 'payments'])
                 ->name('examinations.payment');
            Route::post('examinations-payments', [ExaminationsController::class, 'createPayment'])
                 ->name('examinations.create.payment');
            Route::resource('transactions', TransactionsController::class);
            Route::get('examinations-vitality', [ExaminationsController::class, 'vitality'])
                 ->name('examinations.vitality');
            Route::POST('examinations-service-store', [ExaminationsController::class, 'storeservices'])
                 ->name('examinations.storeservices');
            Route::get('transactions-service', [TransactionsController::class, 'service'])
                 ->name('transactions.service');

            Route::post('suket-sehat/{id}', [ExaminationsController::class, 'sehat'])->name('suket.sehat');
            Route::post('suket-sakit/{id}', [ExaminationsController::class, 'sakit'])->name('suket.sakit');
            Route::post('suket-hak-dan-kewajiban/{id}', [ExaminationsController::class, 'hakkewajiban'])
                 ->name('suket.hakkewajiban');
            Route::post('suket-persetujuan/{id}', [ExaminationsController::class, 'persetujuan'])
                 ->name('suket.persetujuan');

            Route::resource('servicecategories', ServiceCategoriesController::class);
            Route::resource('services', ServicesController::class);
            Route::resource('packages', PackagesController::class);
            Route::resource('packages', PackagesController::class);
            Route::resource('vitalityexaminations', VitalityExaminationsController::class);
            Route::post('vitalityexaminations-skrining', [VitalityExaminationsController::class, 'skrining'])
                 ->name('vitalityexaminations.skrining');

            Route::resource('anamnesiscategories', AnamnesisCategoriesController::class);
            Route::resource('anamnesis', AnamnesisController::class);
            Route::resource('physicalcategories', PhysicalCategoriesController::class);
            Route::resource('physicals', PhysicalsController::class);
            Route::resource('anamnesisexaminations', AnamnesisExaminationsController::class);
            Route::resource('physicalexaminations', PhysicalExaminationsController::class);
            Route::resource('otherexaminations', OtherExaminationsController::class);
            Route::resource('additionalexaminations', AdditionalExaminationsController::class);
            Route::resource('appointments', AppointmentsController::class);

            Route::get('laboratoryexamination-lab', [LaboratoryExaminationsController::class, 'lab'])
                 ->name('laboratoryexaminations.lab');
            Route::get('laboratoryexamination-result', [LaboratoryExaminationsController::class, 'result'])
                 ->name('laboratoryexaminations.result');
            Route::get('laboratoryexamination-download', [LaboratoryExaminationsController::class, 'download'])
                 ->name('laboratoryexaminations.download');
            Route::put('laboratoryexamination-result', [LaboratoryExaminationsController::class, 'resultUpdate'])
                 ->name('result.update');
            Route::resource('laboratoryexaminations', LaboratoryExaminationsController::class);

            Route::resource('organization', OrganizationController::class);
            Route::resource('locations', LocationsController::class);

            Route::resource('units', UnitController::class);
            Route::resource('drugs', DrugsController::class);
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

    require __DIR__ . '/auth.php';
