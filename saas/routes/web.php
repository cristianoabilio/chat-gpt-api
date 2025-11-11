<?php

use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\ChatController;
use App\Http\Controllers\Backend\Admin\DocumentController;
use App\Http\Controllers\Backend\Admin\HeadingController;
use App\Http\Controllers\Backend\Admin\PlanController;
use App\Http\Controllers\Backend\Admin\QuestionController;
use App\Http\Controllers\Backend\Admin\TemplateController;
use App\Http\Controllers\Backend\Client\CheckoutController;
use App\Http\Controllers\Backend\Client\UserController;
use App\Http\Controllers\Backend\Client\UserTemplateController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;

Route::get('/', function () {
    return view('home.index');
});


/// User Routes
Route::middleware(['auth', IsUser::class])->group(function () {

    Route::get('/dashboard', function () {
        return view('client.index');
    })->name('dashboard');

    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'profileUpdate'])->name('user.profile.update');
    Route::get('/user/change-password', [UserController::class, 'changePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'passwordUpdate'])->name('user.password.update');

    // Route::get('/template', [UserTemplateController::class, 'index'])->name('user.template');

    Route::controller(UserTemplateController::class)->group(function() {
        Route::get('/user/template', 'index')->name('user.template');
        Route::get('/user/template/show/{id}', 'show')->name('user.template.show');
        Route::post('/user/content/generate/{id}', 'content')->name('user.content.generate');

        Route::get('/user/documents/all', 'document')->name('user.document');
        Route::get('/user/document/edit/{id}', 'EditUserDocument')->name('user.document.edit');
        Route::get('/user/document/delete/{id}', 'UserDocumentDestroy')->name('user.document.delete');
        Route::post('/user/update/document/{id}', 'UpdateUserDocument')->name('user.update.document');

    });

    Route::controller(CheckoutController::class)->group(function() {
        Route::get('/user/checkout', 'index')->name('user.checkout');
        Route::post('/user/process/checkout', 'store')->name('user.process.checkout');
        Route::get('/payment/success', 'paymentSuccess')->name('payment.success');

        Route::get('/invoice/generate/{id}', 'invoiceGenerate')->name('invoice.generate');


    });

});
/// End User Routes


/// Admin Routes
Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('admin.dashboard');

    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/change-password', [AdminController::class, 'changePassword'])->name('admin.change.password');
    Route::post('/profile/update', [AdminController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::post('/password/update', [AdminController::class, 'passwordUpdate'])->name('admin.password.update');

    Route::controller(ChatController::class)->group(function() {
        Route::get('/chat/assistants', 'index')->name('chat.assistants.all');
        Route::get('/chat/assistant/add', 'create')->name('chat.assistant.create');
        Route::post('/chat/assistant/store', 'store')->name('chat.assistant.store');

        Route::get('/chat/assistant/chat/{assistantId}', 'chatAssistant')->name('chat-assistant.chat');
        Route::post('/chat/assistant/send/{assistantId}', 'send')->name('chat-assistant.send');
        Route::get('/chat/assistant/new/{assistantId}', 'newConversation')->name('chat-assistant.new');
        // Route::get('/chat/assistant/show/{assistantId}/{conversationId}', 'show')->name('chat-assistant.show');
        Route::get('/chat-assistants/{assistantId}/conversation/{conversationId}', 'SelectedConversation')->name('chat-assistants.select');






    });

    Route::controller(PlanController::class)->group(function() {
        Route::get('/plans/all', 'index')->name('admin.plans.all');
        Route::get('/plans/add', 'create')->name('admin.plans.add');
        Route::get('/plans/edit/{id}', 'edit')->name('admin.plans.edit');
        Route::get('/plans/delete/{id}', 'destroy')->name('admin.plans.delete');
        Route::post('/plans/store', 'store')->name('admin.plans.store');
        Route::post('/plans/update/{id}', 'update')->name('admin.plans.update');

    });

    Route::controller(TemplateController::class)->group(function() {
        Route::get('/template', 'index')->name('admin.template');
        Route::get('/template/add', 'create')->name('admin.create.template');
        Route::get('/template/edit/{id}', 'edit')->name('admin.template.edit');
        Route::get('/template/show/{id}', 'show')->name('admin.template.show');
        Route::post('/template/store', 'store')->name('admin.store.template');
        Route::post('/template/update/{id}', 'update')->name('admin.template.update');
        Route::post('/content/generate/{id}', 'content')->name('admin.content.generate');
    });

    Route::controller(DocumentController::class)->group(function() {
        Route::get('/documents/all', 'index')->name('admin.documents.all');
        Route::get('/document/edit/{id}', 'edit')->name('admin.document.edit');
        Route::get('/document/delete/{id}', 'destroy')->name('admin.document.delete');
        Route::post('/update/document/{id}', 'update')->name('admin.update.document');

    });

    Route::controller(AdminController::class)->group(function() {
        Route::get('/orders/all', 'orders')->name('admin.orders.all');
        Route::get('/update/orders/status/{id}', 'updateOrderStatus')->name('update.order.status');
    });

    Route::controller(HomeController::class)->group(function() {
        Route::get('/slider', 'slider')->name('home.slider');
        Route::post('/update/slider', 'update')->name('update.slider');
    });

    Route::controller(HeadingController::class)->group(function() {
        Route::get('/headings', 'index')->name('all.heading');
        Route::get('/add/heading', 'create')->name('add.heading');
        Route::post('/store/heading', 'store')->name('store.heading');
        Route::get('/edit/heading/{id}', 'edit')->name('edit.heading');
        Route::post('/update/heading/{id}', 'update')->name('update.heading');
        Route::get('/delete/heading/{id}', 'destroy')->name('delete.heading');
    });


    Route::controller(QuestionController::class)->group(function() {
        Route::get('/questions', 'index')->name('all.questions');
        Route::get('/add/questions', 'create')->name('add.questions');
        Route::post('/store/questions', 'store')->name('store.questions');
        Route::get('/edit/questions/{id}', 'edit')->name('edit.questions');
        Route::post('/update/questions/{id}', 'update')->name('update.questions');
        Route::get('/delete/questions/{id}', 'destroy')->name('delete.questions');
    });
});
/// End User Routes


Route::post('/update-slider/{id}', [HomeController::class, 'updateSlider']);
Route::post('/update-slider-image/{id}', [HomeController::class, 'updateSliderImage']);

Route::post('/update-get-started/{id}', [HomeController::class, 'updateHeading']);
Route::post('/update-how-it-works/{id}', [HomeController::class, 'updateHeading']);
Route::post('/update-pricing/{id}', [HomeController::class, 'updateHeading']);

    Route::controller(HomeController::class)->group(function() {
        Route::get('/use-case', 'useCase')->name('home.usecase');
        Route::get('/feature', 'feature')->name('home.feature');
        Route::get('/pricing', 'pricing')->name('home.pricing');
    });



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
