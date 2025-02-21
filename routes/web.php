<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::get('/register', [LoginController::class, 'showRegistrationForm']);

Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/', [HomeController::class, 'ShowHome'])->name('user.home');

// Route::middleware(['web'])->group(function () {
//     Route::get('/', [HomeController::class, 'ShowHome'])->name('user.home');
//     Route::get('/Admin/Home', [AdminController::class, 'ShowHome'])->name('admin.home');
// });


// Route::get('/', [HomeController::class, 'ShowHome'])->name('user.home');
Route::get('/Articles', [HomeController::class, 'ShowArticles']);
Route::get('/Article/{id}', [HomeController::class, 'ShowArticleContent']);
Route::get('/Facilities', [HomeController::class, 'ShowFacilities']);
Route::get('/Academies', [HomeController::class, 'ShowAcademies']);
Route::get('/Faqs', [HomeController::class, 'ShowFAQs']);
Route::get('/About', [HomeController::class, 'ShowAbout']);
Route::get('/Qoutation', [HomeController::class, 'quotationpage'])->name('quotationpage');
Route::get('/Qoutation/{id}', [HomeController::class, 'singleqoutation']);
Route::get('/service/{id}', [HomeController::class, 'ShowRate']);


Route::post('/Contactus', [HomeController::class, 'contactus'])->name('contactus');


Route::get('/Admin/Home', [AdminController::class, 'ShowHome'])->name('admin.home');
Route::get('/Admin/facilities', [AdminController::class, 'ShowFacilities'])->name('admin.facilities');
Route::get('/Admin/academies', [AdminController::class, 'ShowAcademies'])->name('admin.academies');
Route::get('/Admin/articles', [AdminController::class, 'ShowArticles'])->name('admin.articles');
Route::get('/Admin/faq', [AdminController::class, 'ShowFAQs'])->name('admin.faq');
Route::get('/Admin/about', [AdminController::class, 'ShowAbout'])->name('admin.about');

Route::post('/Admin/Content/Modify', [AdminController::class, 'CreateOrUpdateContent'])->name('admin.CreateOrUpdateContent');
Route::post('/Admin/Partners/Create', [AdminController::class, 'CreatePartners'])->name('admin.CreatePartners');
Route::post('/Admin/Team/Create', [AdminController::class, 'Createteam'])->name('admin.Createteam');
Route::post('/Admin/Article/Create', [AdminController::class, 'CreateArticle'])->name('admin.CreateArticle');
Route::post('/Admin/Faqs/Category/Create', [AdminController::class, 'CreateFaqCategory'])->name('admin.CreateFaqCategory');
Route::post('/Admin/Faqs/Question/Create', [AdminController::class, 'CreateFaqQuestions'])->name('admin.CreateFaqQuestions');
Route::post('/Admin/Services/Create', [AdminController::class, 'CreateService'])->name('admin.CreateService');
Route::post('/AddToCart', [CartController::class, 'addToCart'])->name('cart.add');


Route::put('/Admin/Faqs/Update', [AdminController::class, 'EditFaqs'])->name('admin.editfaqs');
Route::put('/Admin/Article/Update', [AdminController::class, 'editarticle'])->name('admin.editarticle');

Route::delete('/Admin/Faqs/Question/Delete', [AdminController::class, 'deletefaqs'])->name('admin.deletefaqs');
Route::delete('/Admin/Article/Delete', [AdminController::class, 'DelereArticle'])->name('admin.DelereArticle');








Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
