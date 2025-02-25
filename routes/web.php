<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\LoginController;


Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::get('/register', [LoginController::class, 'showRegisterForm']);

Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'ShowHome'])->name('user.home');
Route::get('/Articles', [HomeController::class, 'ShowArticles']);
Route::get('/Article/{id}', [HomeController::class, 'ShowArticleContent']);
Route::get('/Facilities', [HomeController::class, 'ShowFacilities']);
Route::get('/Academies', [HomeController::class, 'ShowAcademies']);
Route::get('/Faqs', [HomeController::class, 'ShowFAQs']);
Route::get('/About', [HomeController::class, 'ShowAbout']);
Route::get('/Quotation', [HomeController::class, 'quotationpage'])->name('quotationpage');
Route::get('/Quotation/{id}', [HomeController::class, 'singlequotation']);
Route::get('/service/{id}', [HomeController::class, 'ShowRate']);
Route::post('/Contactus', [HomeController::class, 'contactus'])->name('contactus');
Route::get('/User/Request/Dates/api', [HomeController::class, 'GetReservedDates'])->name('GetReservedDates');

Route::middleware(['auth', 'user.type:user'])->group(function () {
    Route::get('/Profile', [HomeController::class, 'ShowProfile']);
    Route::get('/Quotations/view', [HomeController::class, 'QuotationPDF']);
    Route::get('/Payment/{id}', [HomeController::class, 'ShowPayment'])->name('ShowPayment');
    Route::get('/Confirmation/{id}', [HomeController::class, 'ShowConfirmation'])->name('ShowConfirmation');
    Route::get('/Reservation/Confirmed/{id}', [HomeController::class, 'ShowPDF'])->name('ShowPDF');


    Route::post('/Quotation/Create', [HomeController::class, 'CreateQuotation'])->name('CreateQuotation');
    Route::post('/Quotations/Submit', [HomeController::class, 'SubmitQuotationRequest'])->name('SubmitQuotationRequest');
    Route::post('/Quotation/Payment/Submit', [HomeController::class, 'SubmitPayment'])->name('SubmitPayment');

    Route::post('/Profile/Edit', [HomeController::class, 'EditProfile'])->name('EditProfile');
    Route::put('/Profile/Password/Change', [HomeController::class, 'ChangePassword'])->name('ChangePassword');
});


Route::middleware(['auth', 'user.type:admin'])->group(function () {
    Route::get('/Admin/Dashboard', [AdminController::class, 'ShowDashboard'])->name('admin.dashboard');
    Route::get('/Admin/Requests', [AdminController::class, 'ShowRequests'])->name('admin.ShowRequests');
    Route::get('/Admin/Payments', [AdminController::class, 'ShowPayments'])->name('admin.ShowPayments');
    Route::get('/Admin/Home', [AdminController::class, 'ShowHome'])->name('admin.home');
    Route::get('/Admin/facilities', [AdminController::class, 'ShowFacilities'])->name('admin.facilities');
    Route::get('/Admin/academies', [AdminController::class, 'ShowAcademies'])->name('admin.academies');
    Route::get('/Admin/articles', [AdminController::class, 'ShowArticles'])->name('admin.articles');
    Route::get('/Admin/Users', [AdminController::class, 'ShowUsers'])->name('admin.users');
    Route::get('/Admin/Settings', [AdminController::class, 'ShowSettings'])->name('admin.settings');
    Route::get('/Admin/edit/{id}', [AdminController::class, 'ShowEditService'])->name('admin.ShowEditService');

    Route::get('/Admin/membership', [AdminController::class, 'ShowMembership'])->name('admin.Membership');
    Route::get('/Admin/faq', [AdminController::class, 'ShowFAQs'])->name('admin.faq');
    Route::get('/Admin/about', [AdminController::class, 'ShowAbout'])->name('admin.about');
    Route::get('/Admin/header', [AdminController::class, 'ShowHeader'])->name('admin.header');
    Route::get('/Admin/Contactus', [AdminController::class, 'ShowContactus'])->name('admin.ShowContactus');
    Route::get('/Admin/dates', [AdminController::class, 'GetBlockedDates'])->name('admin.GetBlockedDates');


    Route::get('/Admin/Request/Details/api', [AdminController::class, 'GetRequestDetails'])->name('admin.GetRequestDetails');
    Route::get('/Admin/Payments/Details/api', [AdminController::class, 'GetPaymentsDetails'])->name('admin.GetPaymentsDetails');


    Route::post('/Admin/Content/Modify', [AdminController::class, 'CreateOrUpdateContent'])->name('admin.CreateOrUpdateContent');
    Route::post('/Admin/Partners/Create', [AdminController::class, 'CreatePartners'])->name('admin.CreatePartners');
    Route::post('/Admin/Team/Create', [AdminController::class, 'Createteam'])->name('admin.Createteam');
    Route::post('/Admin/Article/Create', [AdminController::class, 'CreateArticle'])->name('admin.CreateArticle');
    Route::post('/Admin/Faqs/Category/Create', [AdminController::class, 'CreateFaqCategory'])->name('admin.CreateFaqCategory');
    Route::post('/Admin/Faqs/Question/Create', [AdminController::class, 'CreateFaqQuestions'])->name('admin.CreateFaqQuestions');
    Route::post('/Admin/Services/Create', [AdminController::class, 'CreateService'])->name('admin.CreateService');
    Route::post('/Admin/Rate/Create', [AdminController::class, 'NewRate'])->name('admin.NewRate');
    Route::post('/Admin/Password/update', [AdminController::class, 'ChangePasswords'])->name('admin.ChangePassword');


    Route::put('/Admin/Faqs/Update', [AdminController::class, 'EditFaqs'])->name('admin.editfaqs');
    Route::put('/Admin/Article/Update', [AdminController::class, 'editarticle'])->name('admin.editarticle');
    Route::put('/Admin/Partner/update', [AdminController::class, 'editpartner'])->name('admin.editpartner');
    Route::put('/Admin/Team/update', [AdminController::class, 'editeam'])->name('admin.editeam');
    Route::put('/Admin/Service/update', [AdminController::class, 'EditService'])->name('admin.EditService');
    Route::put('/Admin/Rate/update', [AdminController::class, 'EditRate'])->name('admin.EditRate');
    Route::put('/Admin/Request/Approve', [AdminController::class, 'ApproveRequest'])->name('admin.ApproveRequest');
    Route::put('/Admin/Request/Reject', [AdminController::class, 'RejectRequest'])->name('admin.RejectRequest');
    Route::put('/Admin/Request/Cancel', [AdminController::class, 'CancelRequest'])->name('admin.CancelRequest');
    Route::put('/Admin/Payment/Approve', [AdminController::class, 'ApprovePayment'])->name('admin.ApprovePayment');


    Route::delete('/Admin/Faqs/Question/Delete', [AdminController::class, 'deletefaqs'])->name('admin.deletefaqs');
    Route::delete('/Admin/Article/Delete', [AdminController::class, 'DelereArticle'])->name('admin.DelereArticle');
    Route::delete('/Admin/Partner/Delete', [AdminController::class, 'deletepartner'])->name('admin.deletepartner');
    Route::delete('/Admin/Team/Delete', [AdminController::class, 'deleteteam'])->name('admin.deleteteam');
    Route::delete('/Admin/Rate/Delete', [AdminController::class, 'DeletRate'])->name('admin.DeletRate');
    Route::delete('/Admin/Service/Delete', [AdminController::class, 'DeleteService'])->name('admin.DeleteService');
});
