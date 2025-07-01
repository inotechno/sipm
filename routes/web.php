<?php

use App\Http\Controllers\IClockController;
use App\Http\Controllers\ReceiptController;
use App\Livewire\Activity\ActivityDependencyForm;
use App\Livewire\Activity\ActivityForm;
use App\Livewire\Activity\ActivityImport;
use App\Livewire\Activity\ActivityIndex;
use App\Livewire\Announcement\AnnouncementForm;
use App\Livewire\Announcement\AnnouncementIndex;
use App\Livewire\Area\AreaIndex;
use App\Livewire\Attendance\AttendanceIndex;
use App\Livewire\Auth\Login;
use App\Livewire\CategoryDependency\CategoryDependencyIndex;
use App\Livewire\CategoryInventory\CategoryInventoryIndex;
use App\Livewire\Dashboard\DashboardActivity;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Dashboard\Inventory\DashboardInventoryIndex;
use App\Livewire\Employee\EmployeeIndex;
use App\Livewire\FileManager\FileManagerIndex;
use App\Livewire\Group\GroupIndex;
use App\Livewire\Inbound\InboundForm;
use App\Livewire\Inventory\InventoryForm;
use App\Livewire\Inventory\InventoryImport;
use App\Livewire\Inventory\InventoryIndex;
use App\Livewire\MonitoringPresent\MonitoringPresentIndex;
use App\Livewire\Outbound\OutboundForm;
use App\Livewire\Permission\PermissionIndex;
use App\Livewire\Position\PositionIndex;
use App\Livewire\Profile\ProfileIndex;
use App\Livewire\Receipt\ReceiptIndex;
use App\Livewire\Report\Progress\ReportProgressIndex;
use App\Livewire\Report\ReportIndex;
use App\Livewire\ReportAttendance\ReportAttendanceIndex;
use App\Livewire\Role\RoleIndex;
use App\Livewire\Scope\ScopeIndex;
use App\Livewire\ShiftEmployee\ShiftEmployeeIndex;
use App\Livewire\User\UserIndex;
use App\Livewire\CollectionImage\CollectionImageIndex;
use App\Livewire\Warehouse\WarehouseIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)->name('login')->middleware('guest');
Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::get('/iclock/cdata', [IClockController::class, 'handshake']);
Route::post('/iclock/cdata', [IClockController::class, 'receiveRecords']);
Route::post('/test-attendance', [IClockController::class, 'testAttendance']);

Route::get('/iclock/test', [IClockController::class, 'test']);
Route::get('/iclock/getrequest', [IClockController::class, 'getrequest']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');
    Route::get('/dashboard-activity', DashboardActivity::class)->name('dashboard.activity');
    Route::get('/profile', ProfileIndex::class)->name('profile');
    Route::get('/roles', RoleIndex::class)->name('master.roles');
    Route::get('/permissions', PermissionIndex::class)->name('master.permissions');
    Route::get('/users', UserIndex::class)->name('master.users');
    Route::get('/groups', GroupIndex::class)->name('master.groups');
    Route::get('/positions', PositionIndex::class)->name('master.positions');
    Route::get('/employees', EmployeeIndex::class)->name('master.employees');
    Route::get('/scopes', ScopeIndex::class)->name('master.scopes');
    Route::get('/areas', AreaIndex::class)->name('master.areas');
    Route::get('/category-dependencies', CategoryDependencyIndex::class)->name('master.category-dependencies');
    Route::get('/shifts', ShiftEmployeeIndex::class)->name('master.shifts');
    Route::get('/collection-images', CollectionImageIndex::class)->name('collection.images');

    Route::get('/attendances', AttendanceIndex::class)->name('attendance');
    Route::get('/activities', ActivityIndex::class)->name('activity');
    Route::get('/activities/create', ActivityForm::class)->name('activity.create');
    Route::get('/activities/import', ActivityImport::class)->name('activity.import');
    Route::get('/activities/edit/{activity_id}', ActivityForm::class)->name('activity.edit');
    Route::get('/activities/issues/{activity_id}', ActivityDependencyForm::class)->name('activity.issues');
    Route::get('/monitoring-present', MonitoringPresentIndex::class)->name('monitoring.present');

    Route::get('/announcements', AnnouncementIndex::class)->name('announcement');
    Route::get('/announcements/create', AnnouncementForm::class)->name('announcement.create');
    Route::get('/files', FileManagerIndex::class)->name('files');
    Route::get('/files/{slug}', FileManagerIndex::class)->name('files.category');

    Route::get('/report', ReportIndex::class)->name('activity.report');
    Route::get('/report-progress', ReportProgressIndex::class)->name('activity.report.progress');
    Route::get('/report/attendance', ReportAttendanceIndex::class)->name('attendance.report');
});

Route::prefix('inventory')->name('inventory.')->middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardInventoryIndex::class)->name('dashboard');
    Route::get('/categories', CategoryInventoryIndex::class)->name('category');
    Route::get('/inventories', InventoryIndex::class)->name('inventory');
    Route::get('/inventories/import', InventoryImport::class)->name('inventory.import');
    Route::get('/warehouse', WarehouseIndex::class)->name('warehouse');

    Route::get('/inventories/create', InventoryForm::class)->name('inventory.create');

    Route::get('/inbound', DashboardInventoryIndex::class)->name('inbound');
    Route::get('/outbound', OutboundForm::class)->name('outbound');
    Route::get('/inbound', InboundForm::class)->name('inbound');

    Route::get('/transaction/receipt/outbound/{uuid}', [ReceiptController::class, 'index'])->name('receipt');
    Route::get('/transaction/receipt/inbound', [ReceiptController::class, 'inbound'])->name('receipt.inbound');
});
