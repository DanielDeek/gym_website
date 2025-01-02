<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\GymClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberClassController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/footer',[Controller::class,'showFooter'])->name('footer');
Route::get('/', [Controller::class,'showHomeContent'])->name('home');

Route::get('/classes', [Controller::class,'showClasses'])->name('classes');

Route::get('/pricing', [Controller::class,'showPricing'])->name('pricing');

Route::get('/contactus', [Controller::class, 'showForm'])->name('contactus');
Route::post('/contactus', [Controller::class, 'submitForm'])->name('contactus.post');


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/change-password', [Controller::class, 'showChangePasswordForm'])->name('change-password.form')->middleware('auth');
Route::post('/change-password', [Controller::class, 'changePassword'])->name('change-password')->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(AdminMiddleware::class)->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/create', [UserController::class, 'store'])->name('admin.users.store');

    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

    Route::delete('/admin/users/{user}',[UserController::class,'destroy'])->name('admin.users.destroy');

    // members
    Route::get('/admin/members',[MemberController::class,'index'])->name('admin.members.index');

    Route::get('admin/members/search', [MemberController::class, 'search'])->name('admin.members.search');

    Route::get('/admin/members/create', [MemberController::class, 'create'])->name('admin.members.create');
    Route::post('/admin/members/create', [MemberController::class, 'store'])->name('admin.members.store');

    Route::get('/admin/members/{member}/edit', [MemberController::class, 'edit'])->name('admin.members.edit');
    Route::post('/admin/members/{member}', [MemberController::class, 'update'])->name('admin.members.update');

    Route::delete('/admin/members/{member}',[MemberController::class,'destroy'])->name('admin.members.destroy');

    Route::middleware('membership.check');

    //memberships
    Route::get('/admin/memberships',[MembershipController::class,'index'])->name('admin.memberships.index');

    Route::get('/admin/memberships/create',[MembershipController::class,'create'])->name('admin.memberships.create');
    Route::post('/admin/memberships/create',[MembershipController::class,'store'])->name('admin.memberships.store');

    Route::get('/admin/memberships/{membership}/edit', [MembershipController::class, 'edit'])->name('admin.memberships.edit');
    Route::post('/admin/memberships/{membership}', [MembershipController::class, 'update'])->name('admin.memberships.update');

    Route::delete('/admin/memberships/{membership}',[MembershipController::class,'destroy'])->name('admin.memberships.destroy');

    //Trainer
    Route::get('/admin/trainers',[TrainerController::class,'index'])->name('admin.trainers.index');

    Route::get('/admin/trainers/create',[TrainerController::class,'create'])->name('admin.trainers.create');
    Route::post('/admin/trainers/create',[TrainerController::class,'store'])->name('admin.trainers.store');

    Route::get('/admin/trainers/{trainer}/edit', [TrainerController::class, 'edit'])->name('admin.trainers.edit');
    Route::post('/admin/trainers/{trainer}', [TrainerController::class, 'update'])->name('admin.trainers.update');

    Route::delete('/admin/trainers/{trainer}',[TrainerController::class,'destroy'])->name('admin.trainers.destroy');

    //classes
    Route::get('/admin/classes',[ClassController::class,'index'])->name('admin.classes.index');

    Route::get('/admin/classes/create',[ClassController::class,'create'])->name('admin.classes.create');
    Route::post('/admin/classes/create',[ClassController::class,'store'])->name('admin.classes.store');

    Route::get('/admin/classes/{class}/edit', [ClassController::class, 'edit'])->name('admin.classes.edit');
    Route::post('/admin/classes/{class}', [ClassController::class, 'update'])->name('admin.classes.update');

    Route::delete('/admin/classes/{class}',[ClassController::class,'destroy'])->name('admin.classes.destroy');

    //services
    Route::get('/admin/services',[ServiceController::class,'index'])->name('admin.services.index');

    Route::get('/admin/services/create',[ServiceController::class,'create'])->name('admin.services.create');
    Route::post('/admin/services/create',[ServiceController::class,'store'])->name('admin.services.store');

    Route::get('/admin/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
    Route::post('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');

    Route::delete('/admin/services/{service}',[ServiceController::class,'destroy'])->name('admin.services.destroy');

    //contacts
    Route::get('/admin/contacts',[ContactController::class,'index'])->name('admin.contacts.index');
    Route::get('/admin/contacts/{contact}',[ContactController::class,'show'])->name('admin.contacts.show');
    Route::delete('/admin/contacts/{contact}',[ContactController::class,'destroy'])->name('admin.contacts.destroy');

    //Home
    Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home.index');
    Route::get('/admin/home/create', [HomeController::class, 'create'])->name('admin.home.create');
    Route::post('/admin/home/create', [HomeController::class, 'store'])->name('admin.home.store');
    Route::get('/admin/home/{id}/edit', [HomeController::class, 'edit'])->name('admin.home.edit');
    Route::post('/admin/home/{id}', [HomeController::class, 'update'])->name('admin.home.update');
    Route::delete('/admin/home/{id}', [HomeController::class, 'destroy'])->name('admin.home.destroy');

    //About
    Route::get('/admin/about-us', [AboutController::class, 'index'])->name('admin.about-us.index');
    Route::get('/admin/about-us/create', [AboutController::class, 'create'])->name('admin.about-us.create');
    Route::post('/admin/about-us/create', [AboutController::class, 'store'])->name('admin.about-us.store');
    Route::get('/admin/about-us/{id}/edit', [AboutController::class, 'edit'])->name('admin.about-us.edit');
    Route::post('/admin/about-us/{id}', [AboutController::class, 'update'])->name('admin.about-us.update');
    Route::delete('/admin/about-us/{id}', [AboutController::class, 'destroy'])->name('admin.about-us.destroy');

    //footer
    Route::get('/admin/footer', [FooterController::class, 'index'])->name('admin.footer.index');
    Route::get('/admin/footer/create', [FooterController::class, 'create'])->name('admin.footer.create');
    Route::post('/admin/footer/create', [FooterController::class, 'store'])->name('admin.footer.store');
    Route::get('/admin/footer/{id}/edit', [FooterController::class, 'edit'])->name('admin.footer.edit');
    Route::post('/admin/footer/{id}', [FooterController::class, 'update'])->name('admin.footer.update');
    Route::delete('/admin/footer/{id}', [FooterController::class, 'destroy'])->name('admin.footer.destroy');



    // MemberClass
    Route::get('admin/class-member', [MemberClassController::class, 'index'])->name('admin.memberClass.index');

    Route::get('admin/class-member/create', [MemberClassController::class, 'create'])->name('admin.memberClass.create');
    Route::post('admin/class-member', [MemberClassController::class, 'store'])->name('admin.memberClass.store');

    Route::get('admin/class-member/{id}/edit', [MemberClassController::class, 'edit'])->name('admin.memberClass.edit');
    Route::post('admin/class-member/{id}', [MemberClassController::class, 'update'])->name('admin.memberClass.update');
    
    Route::delete('admin/class-member/{id}', [MemberClassController::class, 'destroy'])->name('admin.memberClass.destroy');
});
