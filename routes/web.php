<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\JurusanProgramController;
use App\Http\Controllers\Menu\MenuGroupController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\OrganisasiInternalController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\RoleAndPermission\AssignPermissionController;
use App\Http\Controllers\RoleAndPermission\AssignUserToRoleController;
use App\Http\Controllers\RoleAndPermission\ExportPermissionController;
use App\Http\Controllers\RoleAndPermission\ExportRoleController;
use App\Http\Controllers\RoleAndPermission\ImportPermissionController;
use App\Http\Controllers\RoleAndPermission\ImportRoleController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\RoleAndPermission\RoleController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\UniversitasController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Models\Category;

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

Route::get('/', function () {
    return view('auth/login');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('home', ['users' => User::get(),]);
    });

    //master Management
    Route::group(['prefix' => 'master-management'], function () {
        // universitas
        Route::resource('universitas', UniversitasController::class);

        // fakultas
        Route::resource('fakultas', FakultasController::class);

        //jurusan/program
        Route::resource('jurusan-program', JurusanProgramController::class);
        Route::get('/getUniversitasType/{universitasID}', [JurusanProgramController::class, 'getUniversitasType'])->name('get-universitas-type');

        //prodi
        Route::resource('program-studi', ProdiController::class);
        Route::get('/getFakultas', [ProdiController::class, 'getFakultasByUniversitas'])->name('getFakultas');
        Route::get('/getJurusanPrograms', [ProdiController::class, 'getJurusanProgramsByUniversitas'])->name('getJurusanProgram');

        //gedung 
        Route::resource('gedung', GedungController::class);

        //ruang
        Route::resource('ruang', RuangController::class);
        Route::get('/getGedung', [RuangController::class, 'getGedung'])->name('getGedung');
    });

    //organization Management
    Route::prefix('organization-management')->group(function () {
        //internal-organisasi
        Route::resource('internal-organisasi', OrganisasiInternalController::class);
        Route::get('/dataMaster', [OrganisasiInternalController::class, 'GetUniversitas'])->name('get-universitas');
    });

    //user list
    Route::prefix('user-management')->group(function () {
        Route::resource('user', UserController::class);
        Route::post('import', [UserController::class, 'import'])->name('user.import');
        Route::get('export', [UserController::class, 'export'])->name('user.export');
        Route::get('demo', DemoController::class)->name('user.demo');
    });

    Route::prefix('menu-management')->group(function () {
        Route::resource('menu-group', MenuGroupController::class);
        Route::resource('menu-item', MenuItemController::class);
    });
    Route::group(['prefix' => 'role-and-permission'], function () {
        //role
        Route::resource('role', RoleController::class);
        Route::get('role/export', ExportRoleController::class)->name('role.export');
        Route::post('role/import', ImportRoleController::class)->name('role.import');

        //permission
        Route::resource('permission', PermissionController::class);
        Route::get('permission/export', ExportPermissionController::class)->name('permission.export');
        Route::post('permission/import', ImportPermissionController::class)->name('permission.import');

        //assign permission
        Route::get('assign', [AssignPermissionController::class, 'index'])->name('assign.index');
        Route::get('assign/create', [AssignPermissionController::class, 'create'])->name('assign.create');
        Route::get('assign/{role}/edit', [AssignPermissionController::class, 'edit'])->name('assign.edit');
        Route::put('assign/{role}', [AssignPermissionController::class, 'update'])->name('assign.update');
        Route::post('assign', [AssignPermissionController::class, 'store'])->name('assign.store');

        //assign user to role
        Route::get('assign-user', [AssignUserToRoleController::class, 'index'])->name('assign.user.index');
        Route::get('assign-user/create', [AssignUserToRoleController::class, 'create'])->name('assign.user.create');
        Route::post('assign-user', [AssignUserToRoleController::class, 'store'])->name('assign.user.store');
        Route::get('assing-user/{user}/edit', [AssignUserToRoleController::class, 'edit'])->name('assign.user.edit');
        Route::put('assign-user/{user}', [AssignUserToRoleController::class, 'update'])->name('assign.user.update');
    });
});
