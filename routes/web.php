<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\auth_controller;
    use App\Http\Controllers\classRoomsController;
    use App\Http\Controllers\groupController;
    use App\Http\Controllers\moduleController;
    use App\Http\Controllers\formateurController;
    use App\Http\Controllers\FormateurHasGroup;
    use App\Http\Controllers\ShowGroupAffected;
    use App\Http\Controllers\ShowModuleAffected;
    use App\Http\Controllers\ScheduleChaqueFormateur;
    use App\Http\Controllers\forgotPassword;
    use App\Http\Controllers\FormateurHasModuleController;
    use App\Http\Controllers\FormateurRequestController;
    use App\Http\Controllers\branchController;
    use App\Http\Controllers\modelSetting;
    use App\Http\Controllers\FileExcel;
    use App\Http\Controllers\MailController;
    use App\Http\Controllers\ScheduleFormateurs;
    use App\Http\Controllers\Schedule;
    use App\Http\Controllers\ScheduleChaqueGroup;
    use App\Http\Controllers\adminProfileController;
    use App\Http\Controllers\EmploiStricture;
    use App\Models\group;


    // use App\Http\Middleware\Authenticate;
    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now  something great!
    |
    */


    // retreve password  && forgot password Routes
    Route::post('/forgot-password', [forgotPassword::class, 'forgotPassword'])->name('forgotPassword');
    // return view for forgot password page
    Route::get('/forgot-password', [forgotPassword::class, 'index'])->name('ForgotPassword');
    // retrve  new passeword
    Route::post('/reset-Password', [forgotPassword::class, 'resetPassword'])->name('resetPassword');
    // return  a view for page  that can  return view for page   change password
    Route::get('/reset-password/{token}', [forgotPassword::class, 'resetPasswordView'])->name('resetPasswordView');
    //login and  create an account
         // logout
         Route::get('/logout', [auth_controller::class, 'logout'])->name('logout');


    Route::get('/', function () {
        return view('auth.Login');
    })->name('login');
    Route::get('/create-account', [auth_controller::class, 'index'])->name('create-account');
    Route::post('/insert', [auth_controller::class, 'create_account'])->name('insert');
    Route::post('/login', [auth_controller::class, 'login'])->name('login_into_account');

    // for admin
    Route::middleware(['auth', 'RoutesForAdmin'])->prefix('admin')->group(function () {

        // profile
        Route::controller(adminProfileController::class)->group(function () {
            Route::get('/profile', 'index')->name('showProfileAdmin');
            Route::post('/profile', 'update')->name('updateAdmindata');
        });
        //emploi pour tout les formateur
        Route::get('/emploi-for-formateurs', [ScheduleFormateurs::class, 'index'])->name('emploiForFormateurs');
        //emploi pour chaque group
        Route::get('/Schedule-for-Group', [ScheduleChaqueGroup::class, 'index'])->name('emploiForGroup');
        //notification
        Route::get('/Notifications/MarkAsRead', [FormateurRequestController::class, 'markAsRead'])->name('markAsRead');;
        Route::get('/Notifications/Clear', [FormateurRequestController::class, 'Clear'])->name('Clear');;
        // brache routes
        Route::controller(branchController::class)->group(function () {
            Route::get('/add-Branch', 'index')->name('addbranch');
            Route::post('/create-Branch', 'create')->name('createBranch');
            Route::get('/delate-branch/{id}', 'delateBranch')->name('delateBranch');

            Route::get('/update-branch/{id}', 'updateView')->name('update-branch');
            Route::post('/update-branch/{id}', 'updateBarnch')->name('updateBarnch');
        });
        // end branch routes
        // Model Setting
        Route::get('/modele-seting', [modelSetting::class, 'index'])->name('modelSetting');
        Route::post('/Model-setting', [modelSetting::class, 'createOrUpdate']);
        Route::get('/Model-values', [modelSetting::class, 'getCheckedValue']);
        Route::get('/EmploiSricture', [EmploiStricture::class, 'index'])->name('EmploiSricture');
        Route::post('/Emplois-Stracture', [EmploiStricture::class, 'create']);
        Route::get('/Emplois-Stracture', [EmploiStricture::class, 'getdata']);
        // end Model Setting
        // For Accueil page
        Route::get('dashboardAdmin', function () {
            return view('adminDashboard.Main.Accueil');
        })->name('dashboardAdmin');
        //Schedule
        Route::get('/ChaqueFormateur', [ScheduleChaqueFormateur::class, 'index'])->name('ChaqueFormateur');
        Route::get('/formateur-Selected/{id}', [ScheduleChaqueFormateur::class, 'SessionsForEashFormateur']);



        Route::get('/CreateEmpoi', [Schedule::class, 'index'])->name('CreateEmploi');
        Route::get('/insertSession', [Schedule::class, 'insertSession'])->name('insertSession');
        Route::post('/createNewSchedule', [Schedule::class, 'createNewSchedule'])->name('createNewSchedule');
        Route::post('/deleteSessions', [Schedule::class, 'deleteAllSessions'])->name('deleteAllSessions');
        Route::post('/AddAutherEmploi', [Schedule::class, 'AddAutherEmploi'])->name('AddAutherEmploies');
        Route::get('/toutlesEmploi', [Schedule::class, 'toutlesEmploi'])->name('toutlesEmploi');
        Route::get('/AllRequest', [Schedule::class, 'AllRequest'])->name('AllRequest');
        //end Schedule routes
        Route::get('/add-class-rooms', [classRoomsController::class, 'index'])->name('add-class-rooms');
        Route::post('/insertClasses', [classRoomsController::class, 'insert'])->name('insertClasses');
        Route::post('/insert-class-type', [classRoomsController::class, 'insert_class_type'])->name('insert-class-type');
        Route::get('/add-class-type', [classRoomsController::class, 'show_add_class_type'])->name('add-class-type');
        // delate types of classes
        Route::get('/delate-class-type', [classRoomsController::class, 'Delete_Types_Of_Class'])->name('delate-class-type');
        // Delate class room
        Route::get('/delate-class', [classRoomsController::class, 'Delete_Class'])->name('delate-class');
        // determine type of eash class room
        Route::get('/determine-type-class-room', [classRoomsController::class, 'indexOfDetermineTypeOfclass'])->name('determine-type-class-room');
        // insert class with his types
        Route::post('/insert-class-with-types', [classRoomsController::class, 'insertClassWithTtypes'])->name('insert-class-with-types');
        Route::get('/delateClassWithType', [classRoomsController::class, 'deleteClassWithTypes'])->name('delateClassWithType');
        Route::get('/UpdateClasses/{id}', [classRoomsController::class, 'EditClass']);
        Route::post('/UpdateClasses', [classRoomsController::class, 'updateClass'])->name('UpdateClasses');


        // groups
        Route::controller(groupController::class)->group(function () {
            Route::get('/add-groups', 'index')->name('addGroups');
            Route::get('/GetdataGroupe/{id}', 'GetdataGroupe')->name('updateGroups');
            Route::post('updateGroupe/{id}', 'updateGroupes');
            Route::get('/setting', 'settingView')->name('AllSetting');
        });

        // modules
        Route::controller(moduleController::class)->group(function () {
            Route::get('/add-model', 'index')->name('addModule');
            Route::post('/create-model', 'create')->name('insertmodule');
            Route::get('/delate-module/{id}', 'destroy')->name('delateModule');
            Route::get('/update-module/{id}', 'display_update_page')->name('display_update_page');
            Route::post('/update-module/{id}', 'update')->name('update-module');
        });

        // Formateru Part
        Route::controller(formateurController::class)->group(function () {
            Route::get('/add-formateur', 'index')->name('addFormateur');
            Route::get('reserve/{di}', 'reserved');
            Route::post('update/{id}', 'update')->name('updateFormateur');
            // update formateur data from admin
            Route::get('/delete-formateur/{id}', 'destroy');
        });



        // Files excel
        Route::get('upload', [FileExcel::class, 'index'])->name('UploedFileExcelView');
        Route::post('upload', [FileExcel::class, 'upload'])->name('UploedFileExcel');
    });



    // routes for  Formateur
    Route::middleware(['auth', 'RoutesForFormateur'])->group(function () {

        // displat main page in formateur account
        Route::get('/dashboardFormateur', [formateurController::class, 'showHomepage'])->name('dashboard_formateur');
        Route::get('/settingsFormateur', [FormateurRequestController::class, 'settings'])->name('settings_formateur');
        Route::post('/update_settings', [FormateurRequestController::class, 'updateSettings'])->name('update_settings');
        Route::post('/update_password', [FormateurRequestController::class, 'updatePassword'])->name('update_password');


        // request Emploi
        Route::get('DemanderEmploi', [FormateurRequestController::class, 'show'])->name('DemanderEmploi');
        // Route::post('DemanderEmploi',[FormateurRequestController::class,'show'])->name('DemanderEmploi');
        Route::post('submitAllData', [FormateurRequestController::class, 'submitAllData'])->name('submitAllData');
        Route::post('/updateSession', [FormateurRequestController::class, 'updateSession'])->name('updateSession');
        Route::post('/deleteSession', [FormateurRequestController::class, 'deleteSession'])->name('deleteSession');

        Route::post('createRequestEmploi', [FormateurRequestController::class, 'createRequestEmploi'])->name('createRequestEmploi');
        Route::get('/TousLesSeances', [Schedule::class, 'ForamteurCalendar'])->name('TousLesSeances');

        //
        Route::get('dashboardFormateur', [ShowGroupAffected::class, 'ShowInHomeGroupAndModuleAffected'])->name('dashboard_formateur');

        Route::get('FormateurGroupeList', [ShowGroupAffected::class, 'Show']);
        Route::get('FormateurModuleList', [ShowModuleAffected::class, 'Show']);
    });