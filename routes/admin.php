<?php

use App\Domain\Admin\Controllers\AdminBoothBookingController;
use App\Domain\Admin\Controllers\AdminCompanyManageController;
use App\Domain\Admin\Controllers\AdminContentController;
use App\Domain\Admin\Controllers\AdminSupportController;
use App\Domain\Admin\Controllers\AdminWebsiteController;
use App\Domain\Admin\Controllers\Auth\AuthController as AdminAuthController;
use App\Domain\Admin\Controllers\BoothApprovalController;
use App\Domain\Admin\Controllers\DashboardController;
use App\Domain\Admin\Controllers\EventApprovalController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return redirect('/admin/dashboard');
    })->name('home');

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::get('/01_login', fn () => redirect()->route('admin.login'));
    Route::get('/01_login.html', fn () => redirect()->route('admin.login'));
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.store');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    foreach (['sponsors', 'news'] as $module) {
        Route::prefix($module)->name($module . '.')->group(function () use ($module) {
            Route::get('/', fn () => redirect()->route('admin.cms.index'))->name('index');
            Route::get('/create', fn () => redirect()->route('admin.cms.create'))->name('create');
            Route::get('/{id}/edit', fn () => redirect()->route('admin.cms.create'))->name('edit');
            Route::get('/{id}', fn () => redirect()->route('admin.cms.index'))->name('show');
        });
    }

    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.cms.index'))->name('index');
        Route::get('/create', fn () => redirect()->route('admin.cms.create'))->name('create');
        Route::get('/{id}/edit', fn () => redirect()->route('admin.cms.create'))->name('edit');
    });

    Route::prefix('companies')->name('companies.')->group(function () {
        Route::get('/', [AdminContentController::class, 'companies'])->name('index');
        Route::get('/create', [AdminContentController::class, 'createCompany'])->name('create');
        Route::post('/', [AdminContentController::class, 'storeCompany'])->name('store');
        Route::post('/stop-impersonation', [AdminCompanyManageController::class, 'stopImpersonation'])->name('stop-impersonation');
        Route::get('/{company}/manage', [AdminCompanyManageController::class, 'show'])->name('manage');
        Route::post('/{company}/impersonate', [AdminCompanyManageController::class, 'impersonate'])->name('impersonate');
    });

    Route::prefix('company-approval')->name('company-approval.')->group(function () {
        Route::get('/', [AdminContentController::class, 'companyApprovals'])->name('index');
        Route::post('/{company}/approve', [AdminContentController::class, 'approveCompany'])->name('approve');
        Route::post('/{company}/reject', [AdminContentController::class, 'rejectCompany'])->name('reject');
    });

    Route::prefix('exhibitions')->name('exhibitions.')->group(function () {
        Route::get('/', [AdminContentController::class, 'exhibitions'])->name('index');
        Route::get('/create', [AdminContentController::class, 'createExhibition'])->name('create');
        Route::post('/', [AdminContentController::class, 'storeExhibition'])->name('store');
        Route::post('/{exhibition}/publish', [AdminContentController::class, 'publishExhibition'])->name('publish');
        Route::post('/{exhibition}/unpublish', [AdminContentController::class, 'unpublishExhibition'])->name('unpublish');
        Route::post('/{exhibition}/approve', [AdminContentController::class, 'approveExhibition'])->name('approve');
    });

    Route::get('/exhibition-lifecycle', [AdminContentController::class, 'exhibitionLifecycle'])->name('exhibition-lifecycle.index');
    Route::get('/booth-engineering-review', [AdminContentController::class, 'boothEngineeringReview'])->name('booth-engineering.index');
    Route::get('/event-logistics-review', [AdminContentController::class, 'eventLogisticsReview'])->name('event-logistics.index');

    Route::prefix('pavilions')->name('pavilions.')->group(function () {
        Route::get('/', [AdminContentController::class, 'pavilions'])->name('index');
        Route::get('/create', [AdminContentController::class, 'createPavilion'])->name('create');
        Route::post('/', [AdminContentController::class, 'storePavilion'])->name('store');
        Route::get('/{pavilion}/edit', [AdminContentController::class, 'editPavilion'])->name('edit');
        Route::put('/{pavilion}', [AdminContentController::class, 'updatePavilion'])->name('update');
    });

    Route::prefix('halls')->name('halls.')->group(function () {
        Route::get('/', [AdminContentController::class, 'halls'])->name('index');
        Route::get('/create', [AdminContentController::class, 'createHall'])->name('create');
        Route::post('/', [AdminContentController::class, 'storeHall'])->name('store');
        Route::get('/{hall}/edit', [AdminContentController::class, 'editHall'])->name('edit');
        Route::put('/{hall}', [AdminContentController::class, 'updateHall'])->name('update');
    });

    Route::prefix('booths')->name('booths.')->group(function () {
        Route::get('/', [AdminContentController::class, 'booths'])->name('index');
        Route::get('/create', [AdminContentController::class, 'createBooth'])->name('create');
        Route::post('/', [AdminContentController::class, 'storeBooth'])->name('store');
        Route::get('/{booth}/edit', [AdminContentController::class, 'editBooth'])->name('edit');
        Route::put('/{booth}', [AdminContentController::class, 'updateBooth'])->name('update');
    });

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [AdminContentController::class, 'events'])->name('index');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminContentController::class, 'users'])->name('index');
    });

    Route::prefix('event-tickets')->name('event-tickets.')->group(function () {
        Route::get('/', [AdminContentController::class, 'tickets'])->name('index');
    });

    Route::prefix('exhibition-tickets')->name('exhibition-tickets.')->group(function () {
        Route::get('/', [AdminContentController::class, 'tickets'])->name('index');
    });

    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [AdminContentController::class, 'payments'])->name('index');
    });

    Route::prefix('enquiries')->name('enquiries.')->group(function () {
        Route::get('/', [AdminContentController::class, 'enquiries'])->name('index');
    });

    Route::get('/reports', [AdminContentController::class, 'reports'])->name('reports.index');

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'notifications'])->name('index');
        Route::get('/create', [AdminSupportController::class, 'createNotification'])->name('create');
        Route::post('/', [AdminSupportController::class, 'storeNotification'])->name('store');
        Route::post('/{notification}/read', [AdminSupportController::class, 'markNotificationRead'])->name('read');
    });

    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'roles'])->name('index');
        Route::get('/create', [AdminSupportController::class, 'createRole'])->name('create');
        Route::post('/', [AdminSupportController::class, 'storeRole'])->name('store');
    });

    Route::get('/settings', [AdminSupportController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [AdminSupportController::class, 'saveSettings'])->name('settings.save');

    Route::get('/activity-logs', [AdminSupportController::class, 'activityLogs'])->name('activity-logs.index');

    Route::get('/system-settings', [AdminSupportController::class, 'systemSettings'])->name('system-settings.index');
    Route::post('/system-settings', [AdminSupportController::class, 'saveSystemSettings'])->name('system-settings.save');

    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'support'])->name('index');
        Route::get('/create', [AdminSupportController::class, 'createSupport'])->name('create');
        Route::post('/', [AdminSupportController::class, 'storeSupport'])->name('store');
    });

    Route::prefix('cms')->name('cms.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'cms'])->name('index');
        Route::get('/create', [AdminSupportController::class, 'createCms'])->name('create');
        Route::post('/', [AdminSupportController::class, 'storeCms'])->name('store');
    });

    Route::prefix('website')->name('website.')->group(function () {
        Route::get('/home', [AdminWebsiteController::class, 'home'])->name('home');
        Route::post('/home', [AdminWebsiteController::class, 'updateHome'])->name('home.update');
    });

    Route::prefix('kyc-verification')->name('kyc.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'kycVerifications'])->name('index');
        Route::post('/{kyc}/approve', [AdminSupportController::class, 'approveKyc'])->name('approve');
        Route::post('/{kyc}/reject', [AdminSupportController::class, 'rejectKyc'])->name('reject');
    });

    Route::prefix('refunds')->name('refunds.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'refunds'])->name('index');
        Route::get('/create', [AdminSupportController::class, 'createRefund'])->name('create');
        Route::post('/', [AdminSupportController::class, 'storeRefund'])->name('store');
    });

    Route::prefix('visitor-checkins')->name('visitor-checkins.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'visitorCheckins'])->name('index');
        Route::get('/create', [AdminSupportController::class, 'createVisitorCheckin'])->name('create');
        Route::post('/', [AdminSupportController::class, 'storeVisitorCheckin'])->name('store');
    });

    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'leads'])->name('index');
        Route::get('/create', [AdminSupportController::class, 'createLead'])->name('create');
        Route::post('/', [AdminSupportController::class, 'storeLead'])->name('store');
    });

    Route::prefix('meetings')->name('meetings.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'meetings'])->name('index');
        Route::post('/{id}/cancel', [AdminSupportController::class, 'cancelMeeting'])->name('cancel');
        Route::get('/{id}/reschedule', [AdminSupportController::class, 'rescheduleMeetingForm'])->name('reschedule.form');
        Route::post('/{id}/reschedule', [AdminSupportController::class, 'rescheduleMeeting'])->name('reschedule');
    });

    Route::prefix('flow-diagrams')->name('flow-diagrams.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'flowDiagrams'])->name('index');
        Route::get('/create', [AdminSupportController::class, 'createFlowDiagram'])->name('create');
        Route::post('/', [AdminSupportController::class, 'storeFlowDiagram'])->name('store');
    });

    Route::get('/occupancy-analytics', [AdminSupportController::class, 'occupancyAnalytics'])->name('occupancy-analytics.index');
    Route::get('/revenue-breakdown', [AdminSupportController::class, 'revenueBreakdown'])->name('revenue-breakdown.index');

    Route::prefix('booth-approvals')->name('booth-approvals.')->group(function () {
        Route::get('/', [BoothApprovalController::class, 'index'])->name('index');
        Route::get('/preview', [BoothApprovalController::class, 'preview'])->name('preview');
        Route::get('/{publishRequest}', [BoothApprovalController::class, 'show'])->name('show');
        Route::post('/{publishRequest}/approve', [BoothApprovalController::class, 'approve'])->name('approve');
        Route::post('/{publishRequest}/reject', [BoothApprovalController::class, 'reject'])->name('reject');
    });

    Route::prefix('event-approvals')->name('event-approvals.')->group(function () {
        Route::get('/', [EventApprovalController::class, 'index'])->name('index');
        Route::get('/preview', [EventApprovalController::class, 'preview'])->name('preview');
        Route::get('/{publishRequest}', [EventApprovalController::class, 'show'])->name('show');
        Route::post('/{publishRequest}/approve', [EventApprovalController::class, 'approve'])->name('approve');
        Route::post('/{publishRequest}/reject', [EventApprovalController::class, 'reject'])->name('reject');
        Route::post('/{publishRequest}/publish', [EventApprovalController::class, 'publish'])->name('publish');
        Route::post('/{publishRequest}/unpublish', [EventApprovalController::class, 'unpublish'])->name('unpublish');
    });

    Route::prefix('booth-bookings')->name('booth-bookings.')->group(function () {
        Route::get('/', [AdminBoothBookingController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminBoothBookingController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [AdminBoothBookingController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminBoothBookingController::class, 'reject'])->name('reject');
    });

    Route::get('/{page}', [AdminContentController::class, 'resolveImportedPage'])
        ->where('page', '[A-Za-z0-9_]+(?:\.html)?')
        ->name('frontend.pages.show');

    }); // End admin middleware group

});
