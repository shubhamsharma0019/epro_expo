<?php

namespace App\Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Company\Models\CompanyMeeting;
use App\Domain\Company\Models\Enquiry;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Support\AdminAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminSupportController extends Controller
{
    public function notifications(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = DB::table('admin_notifications')
            ->when($status !== 'all', fn ($builder) => $builder->where('status', $status))
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($builder) use ($search) {
                    $builder->where('title', 'like', '%' . $search . '%')
                        ->orWhere('message', 'like', '%' . $search . '%')
                        ->orWhere('type', 'like', '%' . $search . '%');
                });
            })
            ->latest();

        return view('admin.resources.index', [
            'pageTitle' => 'Notifications',
            'pageDescription' => 'Track admin alerts, workflow updates, and important platform signals.',
            'search' => $search,
            'status' => $status,
            'createUrl' => route('admin.notifications.create'),
            'createLabel' => 'Add Notification',
            'stats' => [
                ['label' => 'Total', 'value' => DB::table('admin_notifications')->count(), 'tone' => 'indigo'],
                ['label' => 'Unread', 'value' => DB::table('admin_notifications')->where('status', 'unread')->count(), 'tone' => 'amber'],
                ['label' => 'High Priority', 'value' => DB::table('admin_notifications')->where('priority', 'high')->count(), 'tone' => 'rose'],
                ['label' => 'Today', 'value' => DB::table('admin_notifications')->whereDate('created_at', today())->count(), 'tone' => 'green'],
            ],
            'filters' => [
                'all' => 'All Status',
                'unread' => 'Unread',
                'read' => 'Read',
                'archived' => 'Archived',
            ],
            'columns' => ['Title', 'Type', 'Priority', 'Channel', 'Status', 'Created'],
            'rows' => $query->paginate(12)->through(function ($notification) {
                return [
                    'cells' => [
                        '<div><div class="font-semibold text-[#0B132C]">' . e($notification->title) . '</div><div class="mt-1 text-[12px] text-gray-500">' . e(Str::limit((string) $notification->message, 80)) . '</div></div>',
                        ucfirst((string) $notification->type),
                        $this->badge((string) $notification->priority),
                        ucfirst((string) $notification->channel),
                        $this->badge((string) $notification->status),
                        $this->formatDateTime($notification->created_at),
                    ],
                    'actions' => $notification->status === 'unread'
                        ? [[
                            'label' => 'Mark Read',
                            'href' => route('admin.notifications.read', $notification->id),
                            'method' => 'POST',
                            'variant' => 'success',
                        ]]
                        : [],
                ];
            }),
        ]);
    }

    public function createNotification(): View
    {
        return view('admin.resources.form', [
            'pageTitle' => 'Add Notification',
            'pageDescription' => 'Create an admin-facing notification entry.',
            'submitUrl' => route('admin.notifications.store'),
            'submitLabel' => 'Save Notification',
            'fields' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'type', 'label' => 'Type', 'type' => 'select', 'options' => ['system' => 'System', 'lead' => 'Lead', 'payment' => 'Payment', 'booking' => 'Booking'], 'value' => 'system'],
                ['name' => 'priority', 'label' => 'Priority', 'type' => 'select', 'options' => ['normal' => 'Normal', 'high' => 'High', 'urgent' => 'Urgent'], 'value' => 'normal'],
                ['name' => 'channel', 'label' => 'Channel', 'type' => 'select', 'options' => ['in_app' => 'In App', 'email' => 'Email'], 'value' => 'in_app'],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['unread' => 'Unread', 'read' => 'Read'], 'value' => 'unread'],
                ['name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => true],
            ],
        ]);
    }

    public function storeNotification(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'priority' => ['required', 'string', 'max:50'],
            'channel' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string'],
        ]);

        $id = DB::table('admin_notifications')->insertGetId($data + [
            'admin_id' => session('admin_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('notification_created', 'notifications', 'admin_notification', $id, $data);

        return redirect()->route('admin.notifications.index')->with('status', 'Notification created successfully.');
    }

    public function markNotificationRead(int $notification): RedirectResponse
    {
        DB::table('admin_notifications')
            ->where('id', $notification)
            ->update([
                'status' => 'read',
                'read_at' => now(),
                'updated_at' => now(),
            ]);

        AdminAudit::log('notification_marked_read', 'notifications', 'admin_notification', $notification);

        return back()->with('status', 'Notification marked as read.');
    }

    public function roles(Request $request): View
    {
        $this->ensureRoleCatalog();

        $search = trim((string) $request->query('search', ''));

        $query = DB::table('admin_roles')
            ->leftJoin('admin_role_permissions', 'admin_roles.id', '=', 'admin_role_permissions.admin_role_id')
            ->leftJoin('admin_role_assignments', 'admin_roles.id', '=', 'admin_role_assignments.admin_role_id')
            ->select(
                'admin_roles.id',
                'admin_roles.name',
                'admin_roles.description',
                'admin_roles.is_system',
                'admin_roles.is_active',
                DB::raw('COUNT(DISTINCT admin_role_permissions.admin_permission_id) as permission_count'),
                DB::raw('COUNT(DISTINCT admin_role_assignments.admin_id) as assignment_count')
            )
            ->when($search !== '', fn ($builder) => $builder->where('admin_roles.name', 'like', '%' . $search . '%'))
            ->groupBy('admin_roles.id', 'admin_roles.name', 'admin_roles.description', 'admin_roles.is_system', 'admin_roles.is_active')
            ->orderByDesc('admin_roles.is_system')
            ->orderBy('admin_roles.name');

        return view('admin.resources.index', [
            'pageTitle' => 'Roles & Permissions',
            'pageDescription' => 'Manage admin roles, permission coverage, and assignment visibility.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => route('admin.roles.create'),
            'createLabel' => 'Add Role',
            'stats' => [
                ['label' => 'Roles', 'value' => DB::table('admin_roles')->count(), 'tone' => 'indigo'],
                ['label' => 'Permissions', 'value' => DB::table('admin_permissions')->count(), 'tone' => 'green'],
                ['label' => 'Assignments', 'value' => DB::table('admin_role_assignments')->count(), 'tone' => 'amber'],
                ['label' => 'Active Roles', 'value' => DB::table('admin_roles')->where('is_active', true)->count(), 'tone' => 'green'],
            ],
            'filters' => [],
            'columns' => ['Role', 'Description', 'Permissions', 'Assigned Admins', 'System', 'Status'],
            'rows' => $query->paginate(12)->through(function ($role) {
                return [
                    'cells' => [
                        $role->name,
                        $role->description ?: 'N/A',
                        (string) $role->permission_count,
                        (string) $role->assignment_count,
                        $role->is_system ? 'Yes' : 'No',
                        $this->badge($role->is_active ? 'active' : 'inactive'),
                    ],
                ];
            }),
        ]);
    }

    public function createRole(): View
    {
        $this->ensureRoleCatalog();

        return view('admin.resources.form', [
            'pageTitle' => 'Add Role',
            'pageDescription' => 'Create a new admin role and map permissions by slug.',
            'submitUrl' => route('admin.roles.store'),
            'submitLabel' => 'Create Role',
            'fields' => [
                ['name' => 'name', 'label' => 'Role Name', 'type' => 'text', 'required' => true],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
                ['name' => 'permissions', 'label' => 'Permission Slugs (comma separated)', 'type' => 'textarea', 'value' => 'companies.view,companies.manage,reports.view'],
                ['name' => 'is_active', 'label' => 'Status', 'type' => 'select', 'options' => ['1' => 'Active', '0' => 'Inactive'], 'value' => '1'],
            ],
        ]);
    }

    public function storeRole(Request $request): RedirectResponse
    {
        $this->ensureRoleCatalog();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:admin_roles,name'],
            'description' => ['nullable', 'string'],
            'permissions' => ['nullable', 'string'],
            'is_active' => ['required', 'in:0,1'],
        ]);

        $slug = Str::slug($data['name']);
        $roleId = DB::table('admin_roles')->insertGetId([
            'name' => $data['name'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'is_system' => false,
            'is_active' => $data['is_active'] === '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permissionIds = DB::table('admin_permissions')
            ->whereIn('slug', $this->permissionSlugs((string) ($data['permissions'] ?? '')))
            ->pluck('id');

        foreach ($permissionIds as $permissionId) {
            DB::table('admin_role_permissions')->updateOrInsert(
                ['admin_role_id' => $roleId, 'admin_permission_id' => $permissionId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        AdminAudit::log('role_created', 'roles', 'admin_role', $roleId, $data, ['permission_ids' => $permissionIds->values()->all()]);

        return redirect()->route('admin.roles.index')->with('status', 'Role created successfully.');
    }

    public function settings(): View
    {
        $this->ensureGeneralSettings();

        return view('admin.configuration.index', [
            'pageTitle' => 'Settings',
            'pageDescription' => 'Manage business-facing platform settings without touching the UI shell.',
            'submitUrl' => route('admin.settings.save'),
            'submitLabel' => 'Save Settings',
            'sections' => $this->generalSettingsSections(),
        ]);
    }

    public function saveSettings(Request $request): RedirectResponse
    {
        $this->persistSettings('admin_settings', (array) $request->input('settings', []), 'group');
        AdminAudit::log('settings_updated', 'settings', 'admin_settings');

        return redirect()->route('admin.settings.index')->with('status', 'Settings saved successfully.');
    }

    public function systemSettings(): View
    {
        $this->ensureSystemSettings();

        return view('admin.configuration.index', [
            'pageTitle' => 'System Settings',
            'pageDescription' => 'Manage infrastructure-level keys and operational controls from the admin backend.',
            'submitUrl' => route('admin.system-settings.save'),
            'submitLabel' => 'Save System Settings',
            'sections' => $this->systemSettingsSections(),
        ]);
    }

    public function saveSystemSettings(Request $request): RedirectResponse
    {
        $this->persistSettings('admin_system_settings', (array) $request->input('settings', []), 'category');
        AdminAudit::log('system_settings_updated', 'system-settings', 'admin_system_settings');

        return redirect()->route('admin.system-settings.index')->with('status', 'System settings saved successfully.');
    }

    public function support(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = DB::table('support_tickets')
            ->leftJoin('companies', 'support_tickets.company_id', '=', 'companies.id')
            ->leftJoin('users', 'support_tickets.user_id', '=', 'users.id')
            ->select('support_tickets.*', 'companies.company_name', 'users.name as user_name')
            ->when($status !== 'all', fn ($builder) => $builder->where('support_tickets.status', $status))
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($builder) use ($search) {
                    $builder->where('support_tickets.ticket_number', 'like', '%' . $search . '%')
                        ->orWhere('support_tickets.subject', 'like', '%' . $search . '%')
                        ->orWhere('support_tickets.email', 'like', '%' . $search . '%');
                });
            })
            ->orderByDesc('support_tickets.created_at');

        return view('admin.resources.index', [
            'pageTitle' => 'Support',
            'pageDescription' => 'Monitor incoming support tickets from companies and users.',
            'search' => $search,
            'status' => $status,
            'createUrl' => route('admin.support.create'),
            'createLabel' => 'Add Ticket',
            'stats' => [
                ['label' => 'Open', 'value' => DB::table('support_tickets')->where('status', 'open')->count(), 'tone' => 'amber'],
                ['label' => 'In Progress', 'value' => DB::table('support_tickets')->where('status', 'in_progress')->count(), 'tone' => 'indigo'],
                ['label' => 'Resolved', 'value' => DB::table('support_tickets')->where('status', 'resolved')->count(), 'tone' => 'green'],
                ['label' => 'High Priority', 'value' => DB::table('support_tickets')->where('priority', 'high')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'all' => 'All Status',
                'open' => 'Open',
                'in_progress' => 'In Progress',
                'resolved' => 'Resolved',
                'closed' => 'Closed',
            ],
            'columns' => ['Ticket', 'Requester', 'Subject', 'Category', 'Priority', 'Status'],
            'rows' => $query->paginate(12)->through(function ($ticket) {
                $requester = $ticket->company_name ?: ($ticket->user_name ?: $ticket->name);

                return [
                    'cells' => [
                        $ticket->ticket_number,
                        $requester,
                        '<div><div class="font-semibold text-[#0B132C]">' . e($ticket->subject) . '</div><div class="mt-1 text-[12px] text-gray-500">' . e($ticket->email) . '</div></div>',
                        ucfirst((string) $ticket->category),
                        $this->badge((string) $ticket->priority),
                        $this->badge((string) $ticket->status),
                    ],
                ];
            }),
        ]);
    }

    public function createSupport(): View
    {
        return view('admin.resources.form', [
            'pageTitle' => 'Add Support Ticket',
            'pageDescription' => 'Create a support ticket from the admin backend.',
            'submitUrl' => route('admin.support.store'),
            'submitLabel' => 'Create Ticket',
            'fields' => [
                ['name' => 'requester_type', 'label' => 'Requester Type', 'type' => 'select', 'options' => ['company' => 'Company', 'user' => 'User'], 'value' => 'company'],
                ['name' => 'company_id', 'label' => 'Company', 'type' => 'select', 'options' => ['' => 'Select company'] + Company::orderBy('company_name')->pluck('company_name', 'id')->all()],
                ['name' => 'user_id', 'label' => 'User', 'type' => 'select', 'options' => ['' => 'Select user'] + User::orderBy('name')->pluck('name', 'id')->all()],
                ['name' => 'name', 'label' => 'Requester Name', 'type' => 'text', 'required' => true],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
                ['name' => 'subject', 'label' => 'Subject', 'type' => 'text', 'required' => true],
                ['name' => 'category', 'label' => 'Category', 'type' => 'select', 'options' => ['general' => 'General', 'payments' => 'Payments', 'technical' => 'Technical', 'events' => 'Events'], 'value' => 'general'],
                ['name' => 'priority', 'label' => 'Priority', 'type' => 'select', 'options' => ['normal' => 'Normal', 'high' => 'High', 'urgent' => 'Urgent'], 'value' => 'normal'],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['open' => 'Open', 'in_progress' => 'In Progress', 'resolved' => 'Resolved'], 'value' => 'open'],
                ['name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => true],
            ],
        ]);
    }

    public function storeSupport(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'requester_type' => ['required', 'string', 'max:50'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'category' => ['required', 'string', 'max:50'],
            'priority' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $id = DB::table('support_tickets')->insertGetId($data + [
            'ticket_number' => 'SUP-' . now()->format('Ymd') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT),
            'assigned_to' => session('admin_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('support_ticket_created', 'support', 'support_ticket', $id, $data);

        return redirect()->route('admin.support.index')->with('status', 'Support ticket created successfully.');
    }

    public function cms(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = DB::table('cms_pages')
            ->when($status !== 'all', fn ($builder) => $builder->where('status', $status))
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($builder) use ($search) {
                    $builder->where('title', 'like', '%' . $search . '%')
                        ->orWhere('slug', 'like', '%' . $search . '%');
                });
            })
            ->latest('updated_at');

        return view('admin.resources.index', [
            'pageTitle' => 'CMS',
            'pageDescription' => 'Manage static pages and editorial content blocks in the admin backend.',
            'search' => $search,
            'status' => $status,
            'createUrl' => route('admin.cms.create'),
            'createLabel' => 'Add Page',
            'stats' => [
                ['label' => 'Pages', 'value' => DB::table('cms_pages')->count(), 'tone' => 'indigo'],
                ['label' => 'Published', 'value' => DB::table('cms_pages')->where('status', 'published')->count(), 'tone' => 'green'],
                ['label' => 'Draft', 'value' => DB::table('cms_pages')->where('status', 'draft')->count(), 'tone' => 'amber'],
                ['label' => 'Landing Pages', 'value' => DB::table('cms_pages')->where('page_type', 'landing')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'all' => 'All Status',
                'draft' => 'Draft',
                'published' => 'Published',
                'archived' => 'Archived',
            ],
            'columns' => ['Title', 'Slug', 'Type', 'Status', 'Updated'],
            'rows' => $query->paginate(12)->through(function ($page) {
                return [
                    'cells' => [
                        $page->title,
                        $page->slug,
                        ucfirst((string) $page->page_type),
                        $this->badge((string) $page->status),
                        $this->formatDateTime($page->updated_at),
                    ],
                ];
            }),
        ]);
    }

    public function createCms(): View
    {
        return view('admin.resources.form', [
            'pageTitle' => 'Add CMS Page',
            'pageDescription' => 'Create a new page entry for the CMS.',
            'submitUrl' => route('admin.cms.store'),
            'submitLabel' => 'Create Page',
            'fields' => [
                ['name' => 'title', 'label' => 'Page Title', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
                ['name' => 'page_type', 'label' => 'Page Type', 'type' => 'select', 'options' => ['page' => 'Page', 'landing' => 'Landing', 'policy' => 'Policy'], 'value' => 'page'],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'], 'value' => 'draft'],
                ['name' => 'content', 'label' => 'Content', 'type' => 'textarea'],
            ],
        ]);
    }

    public function storeCms(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:cms_pages,slug'],
            'page_type' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
            'content' => ['nullable', 'string'],
        ]);

        $slug = $data['slug'] ?: Str::slug($data['title']);
        $id = DB::table('cms_pages')->insertGetId([
            'title' => $data['title'],
            'slug' => $slug,
            'page_type' => $data['page_type'],
            'content' => $data['content'] ?? null,
            'status' => $data['status'],
            'created_by' => session('admin_id'),
            'updated_by' => session('admin_id'),
            'published_at' => $data['status'] === 'published' ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('cms_page_created', 'cms', 'cms_page', $id, $data);

        return redirect()->route('admin.cms.index')->with('status', 'CMS page created successfully.');
    }

    public function activityLogs(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = DB::table('admin_activity_logs')
            ->leftJoin('admins', 'admin_activity_logs.admin_id', '=', 'admins.id')
            ->select('admin_activity_logs.*', 'admins.name as admin_name')
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($builder) use ($search) {
                    $builder->where('admin_activity_logs.action', 'like', '%' . $search . '%')
                        ->orWhere('admin_activity_logs.module', 'like', '%' . $search . '%')
                        ->orWhere('admins.name', 'like', '%' . $search . '%');
                });
            })
            ->latest('admin_activity_logs.created_at');

        return view('admin.resources.index', [
            'pageTitle' => 'Activity Logs',
            'pageDescription' => 'Audit trail of admin-side actions performed across the platform.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Today', 'value' => DB::table('admin_activity_logs')->whereDate('created_at', today())->count(), 'tone' => 'indigo'],
                ['label' => 'Companies', 'value' => DB::table('admin_activity_logs')->where('module', 'companies')->count(), 'tone' => 'amber'],
                ['label' => 'Approvals', 'value' => DB::table('admin_activity_logs')->whereIn('module', ['booth-approvals', 'event-approvals', 'kyc'])->count(), 'tone' => 'green'],
                ['label' => 'Total', 'value' => DB::table('admin_activity_logs')->count(), 'tone' => 'rose'],
            ],
            'filters' => [],
            'columns' => ['Action', 'Module', 'Admin', 'Subject', 'When'],
            'rows' => $query->paginate(15)->through(function ($log) {
                return [
                    'cells' => [
                        ucwords(str_replace('_', ' ', (string) $log->action)),
                        ucfirst(str_replace('-', ' ', (string) ($log->module ?: 'general'))),
                        $log->admin_name ?: 'System',
                        trim(($log->subject_type ?: 'N/A') . ' #' . ($log->subject_id ?: '-')),
                        $this->formatDateTime($log->created_at),
                    ],
                ];
            }),
        ]);
    }

    public function kycVerifications(Request $request): View
    {
        $this->ensureKycRows();
        $status = (string) $request->query('status', 'all');

        $query = DB::table('company_kyc_verifications')
            ->join('companies', 'company_kyc_verifications.company_id', '=', 'companies.id')
            ->select('company_kyc_verifications.*', 'companies.company_name')
            ->when($status !== 'all', fn ($builder) => $builder->where('company_kyc_verifications.status', $status))
            ->latest('company_kyc_verifications.updated_at');

        return view('admin.resources.index', [
            'pageTitle' => 'KYC Verification',
            'pageDescription' => 'Review company KYC records and mark verification outcomes.',
            'search' => '',
            'status' => $status,
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Pending', 'value' => DB::table('company_kyc_verifications')->where('status', 'pending')->count(), 'tone' => 'amber'],
                ['label' => 'Approved', 'value' => DB::table('company_kyc_verifications')->where('status', 'approved')->count(), 'tone' => 'green'],
                ['label' => 'Rejected', 'value' => DB::table('company_kyc_verifications')->where('status', 'rejected')->count(), 'tone' => 'rose'],
                ['label' => 'Avg Risk Score', 'value' => (string) round((float) DB::table('company_kyc_verifications')->avg('risk_score')), 'tone' => 'indigo'],
            ],
            'filters' => [
                'all' => 'All Status',
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ],
            'columns' => ['Company', 'GST', 'PAN', 'CIN', 'Risk Score', 'Status'],
            'rows' => $query->paginate(12)->through(function ($kyc) {
                return [
                    'cells' => [
                        $kyc->company_name,
                        $kyc->gst_number ?: 'N/A',
                        $kyc->pan_number ?: 'N/A',
                        $kyc->cin_number ?: 'N/A',
                        (string) $kyc->risk_score,
                        $this->badge((string) $kyc->status),
                    ],
                    'actions' => $kyc->status !== 'approved'
                        ? [[
                            'label' => 'Approve',
                            'href' => route('admin.kyc.approve', $kyc->id),
                            'method' => 'POST',
                            'variant' => 'success',
                        ], [
                            'label' => 'Reject',
                            'href' => route('admin.kyc.reject', $kyc->id),
                            'method' => 'POST',
                            'variant' => 'danger',
                        ]]
                        : [],
                ];
            }),
        ]);
    }

    public function approveKyc(int $kyc): RedirectResponse
    {
        DB::table('company_kyc_verifications')->where('id', $kyc)->update([
            'status' => 'approved',
            'reviewed_by' => session('admin_id'),
            'reviewed_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('kyc_approved', 'kyc', 'company_kyc_verification', $kyc);

        return back()->with('status', 'KYC approved successfully.');
    }

    public function rejectKyc(int $kyc): RedirectResponse
    {
        DB::table('company_kyc_verifications')->where('id', $kyc)->update([
            'status' => 'rejected',
            'reviewed_by' => session('admin_id'),
            'reviewed_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('kyc_rejected', 'kyc', 'company_kyc_verification', $kyc);

        return back()->with('status', 'KYC rejected.');
    }

    public function refunds(Request $request): View
    {
        $status = (string) $request->query('status', 'all');

        $query = DB::table('payment_refunds')
            ->leftJoin('booth_bookings', 'payment_refunds.booth_booking_id', '=', 'booth_bookings.id')
            ->leftJoin('visitor_tickets', 'payment_refunds.visitor_ticket_id', '=', 'visitor_tickets.id')
            ->select('payment_refunds.*', 'booth_bookings.booking_reference', 'visitor_tickets.order_number')
            ->when($status !== 'all', fn ($builder) => $builder->where('payment_refunds.status', $status))
            ->latest('payment_refunds.created_at');

        return view('admin.resources.index', [
            'pageTitle' => 'Refund Management',
            'pageDescription' => 'Track refund requests across booth bookings and event tickets.',
            'search' => '',
            'status' => $status,
            'createUrl' => route('admin.refunds.create'),
            'createLabel' => 'Add Refund',
            'stats' => [
                ['label' => 'Requested', 'value' => DB::table('payment_refunds')->where('status', 'requested')->count(), 'tone' => 'amber'],
                ['label' => 'Processed', 'value' => DB::table('payment_refunds')->where('status', 'processed')->count(), 'tone' => 'green'],
                ['label' => 'Rejected', 'value' => DB::table('payment_refunds')->where('status', 'rejected')->count(), 'tone' => 'rose'],
                ['label' => 'Refund Amount', 'value' => $this->money((float) DB::table('payment_refunds')->sum('amount')), 'tone' => 'indigo'],
            ],
            'filters' => [
                'all' => 'All Status',
                'requested' => 'Requested',
                'processed' => 'Processed',
                'rejected' => 'Rejected',
            ],
            'columns' => ['Type', 'Reference', 'Amount', 'Reason', 'Status', 'Created'],
            'rows' => $query->paginate(12)->through(function ($refund) {
                $reference = $refund->booking_reference ?: ($refund->order_number ?: 'Manual');

                return [
                    'cells' => [
                        ucfirst((string) $refund->refund_type),
                        $reference,
                        $this->money((float) $refund->amount),
                        $refund->reason ?: 'N/A',
                        $this->badge((string) $refund->status),
                        $this->formatDateTime($refund->created_at),
                    ],
                ];
            }),
        ]);
    }

    public function createRefund(): View
    {
        return view('admin.resources.form', [
            'pageTitle' => 'Add Refund',
            'pageDescription' => 'Create a refund request entry from the admin backend.',
            'submitUrl' => route('admin.refunds.store'),
            'submitLabel' => 'Create Refund',
            'fields' => [
                ['name' => 'refund_type', 'label' => 'Refund Type', 'type' => 'select', 'options' => ['ticket' => 'Ticket', 'booth' => 'Booth'], 'value' => 'ticket'],
                ['name' => 'visitor_ticket_id', 'label' => 'Visitor Ticket', 'type' => 'select', 'options' => ['' => 'Select ticket'] + VisitorTicket::orderByDesc('id')->limit(200)->get()->mapWithKeys(fn ($ticket) => [$ticket->id => ($ticket->order_number ?: ('TKT-' . $ticket->id))])->all()],
                ['name' => 'booth_booking_id', 'label' => 'Booth Booking', 'type' => 'select', 'options' => ['' => 'Select booking'] + BoothBooking::orderByDesc('id')->limit(200)->get()->mapWithKeys(fn ($booking) => [$booking->id => ($booking->booking_reference ?: ('BB-' . $booking->id))])->all()],
                ['name' => 'amount', 'label' => 'Amount', 'type' => 'number', 'step' => '0.01', 'required' => true],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['requested' => 'Requested', 'processed' => 'Processed', 'rejected' => 'Rejected'], 'value' => 'requested'],
                ['name' => 'reason', 'label' => 'Reason', 'type' => 'text'],
                ['name' => 'notes', 'label' => 'Notes', 'type' => 'textarea'],
            ],
        ]);
    }

    public function storeRefund(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'refund_type' => ['required', 'string', 'max:50'],
            'visitor_ticket_id' => ['nullable', 'exists:visitor_tickets,id'],
            'booth_booking_id' => ['nullable', 'exists:booth_bookings,id'],
            'amount' => ['required', 'numeric'],
            'status' => ['required', 'string', 'max:50'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $id = DB::table('payment_refunds')->insertGetId($data + [
            'currency' => 'INR',
            'processed_by' => in_array($data['status'], ['processed', 'rejected'], true) ? session('admin_id') : null,
            'processed_at' => in_array($data['status'], ['processed', 'rejected'], true) ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('refund_created', 'refunds', 'payment_refund', $id, $data);

        return redirect()->route('admin.refunds.index')->with('status', 'Refund created successfully.');
    }

    public function visitorCheckins(Request $request): View
    {
        $status = (string) $request->query('status', 'all');

        $query = DB::table('visitor_checkins')
            ->leftJoin('users', 'visitor_checkins.user_id', '=', 'users.id')
            ->leftJoin('visitor_tickets', 'visitor_checkins.visitor_ticket_id', '=', 'visitor_tickets.id')
            ->leftJoin('company_events', 'visitor_checkins.company_event_id', '=', 'company_events.id')
            ->leftJoin('exhibitions', 'visitor_checkins.exhibition_id', '=', 'exhibitions.id')
            ->select('visitor_checkins.*', 'users.name as user_name', 'visitor_tickets.order_number', 'company_events.title as event_title', 'exhibitions.title as exhibition_title')
            ->when($status !== 'all', fn ($builder) => $builder->where('visitor_checkins.status', $status))
            ->latest('visitor_checkins.checked_in_at');

        return view('admin.resources.index', [
            'pageTitle' => 'Visitor Check-in Analytics',
            'pageDescription' => 'See live visitor entry records across exhibitions and events.',
            'search' => '',
            'status' => $status,
            'createUrl' => route('admin.visitor-checkins.create'),
            'createLabel' => 'Add Check-in',
            'stats' => [
                ['label' => 'Today', 'value' => DB::table('visitor_checkins')->whereDate('checked_in_at', today())->count(), 'tone' => 'green'],
                ['label' => 'Total', 'value' => DB::table('visitor_checkins')->count(), 'tone' => 'indigo'],
                ['label' => 'Event Check-ins', 'value' => DB::table('visitor_checkins')->whereNotNull('company_event_id')->count(), 'tone' => 'amber'],
                ['label' => 'Exhibition Check-ins', 'value' => DB::table('visitor_checkins')->whereNotNull('exhibition_id')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'all' => 'All Status',
                'checked_in' => 'Checked In',
                'verified' => 'Verified',
            ],
            'columns' => ['Visitor', 'Ticket', 'Destination', 'Gate', 'Status', 'Checked In'],
            'rows' => $query->paginate(12)->through(function ($checkin) {
                return [
                    'cells' => [
                        $checkin->user_name ?: 'Visitor',
                        $checkin->order_number ?: 'N/A',
                        $checkin->event_title ?: ($checkin->exhibition_title ?: 'General Entry'),
                        $checkin->entry_gate ?: 'N/A',
                        $this->badge((string) $checkin->status),
                        $this->formatDateTime($checkin->checked_in_at),
                    ],
                ];
            }),
        ]);
    }

    public function createVisitorCheckin(): View
    {
        return view('admin.resources.form', [
            'pageTitle' => 'Add Check-in',
            'pageDescription' => 'Manually register a visitor check-in record.',
            'submitUrl' => route('admin.visitor-checkins.store'),
            'submitLabel' => 'Save Check-in',
            'fields' => [
                ['name' => 'user_id', 'label' => 'Visitor', 'type' => 'select', 'options' => ['' => 'Select visitor'] + User::orderBy('name')->limit(200)->pluck('name', 'id')->all()],
                ['name' => 'visitor_ticket_id', 'label' => 'Ticket', 'type' => 'select', 'options' => ['' => 'Select ticket'] + VisitorTicket::orderByDesc('id')->limit(200)->get()->mapWithKeys(fn ($ticket) => [$ticket->id => ($ticket->order_number ?: ('TKT-' . $ticket->id))])->all()],
                ['name' => 'company_event_id', 'label' => 'Event', 'type' => 'select', 'options' => ['' => 'Select event'] + CompanyEvent::orderBy('title')->limit(200)->pluck('title', 'id')->all()],
                ['name' => 'exhibition_id', 'label' => 'Exhibition', 'type' => 'select', 'options' => ['' => 'Select exhibition'] + Exhibition::orderBy('title')->limit(200)->pluck('title', 'id')->all()],
                ['name' => 'entry_gate', 'label' => 'Entry Gate', 'type' => 'text'],
                ['name' => 'checkin_type', 'label' => 'Check-in Type', 'type' => 'select', 'options' => ['qr' => 'QR', 'manual' => 'Manual'], 'value' => 'manual'],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['checked_in' => 'Checked In', 'verified' => 'Verified'], 'value' => 'checked_in'],
            ],
        ]);
    }

    public function storeVisitorCheckin(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'visitor_ticket_id' => ['nullable', 'exists:visitor_tickets,id'],
            'company_event_id' => ['nullable', 'exists:company_events,id'],
            'exhibition_id' => ['nullable', 'exists:exhibitions,id'],
            'entry_gate' => ['nullable', 'string', 'max:255'],
            'checkin_type' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $id = DB::table('visitor_checkins')->insertGetId($data + [
            'verified_by' => session('admin_id'),
            'checked_in_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('visitor_checkin_created', 'visitor-checkins', 'visitor_checkin', $id, $data);

        return redirect()->route('admin.visitor-checkins.index')->with('status', 'Visitor check-in added successfully.');
    }

    public function leads(Request $request): View
    {
        $this->syncLeadsFromEnquiries();

        $status = (string) $request->query('status', 'all');

        $query = DB::table('admin_leads')
            ->leftJoin('companies', 'admin_leads.company_id', '=', 'companies.id')
            ->leftJoin('enquiries', 'admin_leads.enquiry_id', '=', 'enquiries.id')
            ->leftJoin('visitor_meeting_bookings', 'admin_leads.visitor_meeting_booking_id', '=', 'visitor_meeting_bookings.id')
            ->select('admin_leads.*', 'companies.company_name', 'enquiries.subject')
            ->when($status !== 'all', fn ($builder) => $builder->where('admin_leads.lead_status', $status))
            ->latest('admin_leads.created_at');

        return view('admin.resources.index', [
            'pageTitle' => 'Lead Management',
            'pageDescription' => 'Track sales-qualified interest coming from enquiries and meeting activity.',
            'search' => '',
            'status' => $status,
            'createUrl' => route('admin.leads.create'),
            'createLabel' => 'Add Lead',
            'stats' => [
                ['label' => 'New', 'value' => DB::table('admin_leads')->where('lead_status', 'new')->count(), 'tone' => 'amber'],
                ['label' => 'Qualified', 'value' => DB::table('admin_leads')->where('lead_status', 'qualified')->count(), 'tone' => 'green'],
                ['label' => 'Converted', 'value' => DB::table('admin_leads')->where('lead_status', 'converted')->count(), 'tone' => 'indigo'],
                ['label' => 'Total', 'value' => DB::table('admin_leads')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'all' => 'All Status',
                'new' => 'New',
                'qualified' => 'Qualified',
                'contacted' => 'Contacted',
                'converted' => 'Converted',
                'lost' => 'Lost',
            ],
            'columns' => ['Company', 'Source', 'Linked Enquiry', 'Score', 'Status', 'Created'],
            'rows' => $query->paginate(12)->through(function ($lead) {
                return [
                    'cells' => [
                        $lead->company_name ?: 'Unassigned',
                        ucfirst((string) $lead->lead_source),
                        $lead->subject ?: 'N/A',
                        (string) $lead->lead_score,
                        $this->badge((string) $lead->lead_status),
                        $this->formatDate($lead->created_at),
                    ],
                ];
            }),
        ]);
    }

    public function createLead(): View
    {
        return view('admin.resources.form', [
            'pageTitle' => 'Add Lead',
            'pageDescription' => 'Create a lead record manually from the admin backend.',
            'submitUrl' => route('admin.leads.store'),
            'submitLabel' => 'Create Lead',
            'fields' => [
                ['name' => 'company_id', 'label' => 'Company', 'type' => 'select', 'options' => ['' => 'Select company'] + Company::orderBy('company_name')->pluck('company_name', 'id')->all()],
                ['name' => 'enquiry_id', 'label' => 'Linked Enquiry', 'type' => 'select', 'options' => ['' => 'Select enquiry'] + Enquiry::orderByDesc('id')->limit(200)->get()->mapWithKeys(fn ($enquiry) => [$enquiry->id => (($enquiry->subject ?: 'Enquiry') . ' #' . $enquiry->id)])->all()],
                ['name' => 'lead_source', 'label' => 'Lead Source', 'type' => 'select', 'options' => ['enquiry' => 'Enquiry', 'meeting' => 'Meeting', 'manual' => 'Manual'], 'value' => 'manual'],
                ['name' => 'lead_status', 'label' => 'Lead Status', 'type' => 'select', 'options' => ['new' => 'New', 'contacted' => 'Contacted', 'qualified' => 'Qualified', 'converted' => 'Converted', 'lost' => 'Lost'], 'value' => 'new'],
                ['name' => 'lead_score', 'label' => 'Lead Score', 'type' => 'number', 'value' => '50'],
                ['name' => 'notes', 'label' => 'Notes', 'type' => 'textarea'],
            ],
        ]);
    }

    public function storeLead(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_id' => ['nullable', 'exists:companies,id'],
            'enquiry_id' => ['nullable', 'exists:enquiries,id'],
            'lead_source' => ['required', 'string', 'max:50'],
            'lead_status' => ['required', 'string', 'max:50'],
            'lead_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $id = DB::table('admin_leads')->insertGetId($data + [
            'lead_score' => $data['lead_score'] ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('lead_created', 'leads', 'admin_lead', $id, $data);

        return redirect()->route('admin.leads.index')->with('status', 'Lead created successfully.');
    }

    public function meetings(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = CompanyMeeting::query()
            ->with('company')
            ->when($status !== 'all', fn ($builder) => $builder->where('status', $status))
            ->when($search !== '', fn ($builder) => $builder->where('title', 'like', '%' . $search . '%'))
            ->latest();

        return view('admin.resources.index', [
            'pageTitle' => 'Meeting Management',
            'pageDescription' => 'Review company-side meeting inventory and schedule status.',
            'search' => $search,
            'status' => $status,
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Total Meetings', 'value' => CompanyMeeting::count(), 'tone' => 'indigo'],
                ['label' => 'Scheduled', 'value' => CompanyMeeting::where('status', 'scheduled')->count(), 'tone' => 'green'],
                ['label' => 'Draft', 'value' => CompanyMeeting::where('status', 'draft')->count(), 'tone' => 'amber'],
                ['label' => 'Rejected', 'value' => CompanyMeeting::where('status', 'rejected')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'all' => 'All Status',
                'draft' => 'Draft',
                'scheduled' => 'Scheduled',
                'rejected' => 'Rejected',
                'completed' => 'Completed',
            ],
            'columns' => ['Meeting', 'Company', 'Type', 'Starts', 'Ends', 'Status'],
            'rows' => $query->paginate(12)->through(function (CompanyMeeting $meeting) {
                // Check conflicts for this meeting
                $hasConflict = false;
                if ($meeting->start_time && $meeting->end_time && in_array($meeting->status, ['confirmed', 'accepted', 'rescheduled', 'scheduled', 'pending'], true)) {
                    // Check if company has overlapping meetings
                    $companyOverlap = CompanyMeeting::where('company_id', $meeting->company_id)
                        ->where('id', '!=', $meeting->id)
                        ->whereIn('status', ['confirmed', 'accepted', 'rescheduled', 'scheduled', 'pending'])
                        ->where('start_time', '<', $meeting->end_time->toDateTimeString())
                        ->where('end_time', '>', $meeting->start_time->toDateTimeString())
                        ->exists();

                    // Check if any booking associated with this meeting has visitor overlaps
                    $visitorOverlap = false;
                    $booking = \App\Domain\Visitor\Models\VisitorMeetingBooking::where('company_meeting_id', $meeting->id)->first();
                    if ($booking && $booking->visitor_id) {
                        $visitorOverlap = \App\Domain\Visitor\Models\VisitorMeetingBooking::where('visitor_id', $booking->visitor_id)
                            ->where('company_meeting_id', '!=', $meeting->id)
                            ->whereIn('status', ['confirmed', 'accepted', 'rescheduled', 'scheduled', 'pending'])
                            ->whereHas('companyMeeting', function ($q) use ($meeting) {
                                $q->where('start_time', '<', $meeting->end_time->toDateTimeString())
                                  ->where('end_time', '>', $meeting->start_time->toDateTimeString());
                            })
                            ->exists();
                    }
                    $hasConflict = $companyOverlap || $visitorOverlap;
                }

                $statusLabel = $this->badge((string) $meeting->status);
                if ($hasConflict) {
                    $statusLabel .= ' <span class="inline-flex rounded-full bg-rose-100 px-2 py-0.5 text-[11px] font-bold text-rose-800 ml-1">Conflict Warning</span>';
                }

                $actions = [];
                if (in_array($meeting->status, ['pending', 'confirmed', 'accepted', 'rescheduled', 'scheduled'], true)) {
                    $actions[] = [
                        'label' => 'Reschedule',
                        'href' => route('admin.meetings.reschedule.form', $meeting->id),
                        'method' => 'GET',
                    ];
                    $actions[] = [
                        'label' => 'Cancel',
                        'href' => route('admin.meetings.cancel', $meeting->id),
                        'method' => 'POST',
                        'variant' => 'danger',
                    ];
                }

                return [
                    'cells' => [
                        $meeting->title,
                        $meeting->company?->company_name ?? 'N/A',
                        ucfirst((string) $meeting->meeting_type),
                        $meeting->start_time?->format('M d, Y H:i') ?? 'TBD',
                        $meeting->end_time?->format('M d, Y H:i') ?? 'TBD',
                        $statusLabel,
                    ],
                    'actions' => $actions,
                ];
            }),
        ]);
    }

    public function cancelMeeting(int $id): RedirectResponse
    {
        $meeting = CompanyMeeting::findOrFail($id);

        $visitorBookings = \App\Domain\Visitor\Models\VisitorMeetingBooking::where('company_meeting_id', $meeting->id)->get();

        $oldDate = $meeting->meeting_date?->format('Y-m-d');
        $oldTime = $meeting->meeting_time;
        if ($oldDate && $oldTime) {
            $oldSlot = \App\Domain\Booth\Models\BoothMeetingSlot::where('company_id', $meeting->company_id)
                ->where('date', $oldDate)
                ->where('start_time', $oldTime)
                ->first();
            if ($oldSlot) {
                $oldSlot->update(['status' => 'available']);
            }
        }

        $meeting->update(['status' => 'cancelled']);
        foreach ($visitorBookings as $booking) {
            $booking->update(['status' => 'cancelled']);

            DB::table('meeting_notifications')->insert([
                'visitor_id' => $booking->visitor_id,
                'company_id' => $meeting->company_id,
                'visitor_meeting_booking_id' => $booking->id,
                'type' => 'cancelled',
                'title' => 'Meeting Cancelled',
                'message' => 'The meeting has been cancelled by the administrator.',
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        AdminAudit::log('meeting_cancelled', 'meetings', 'company_meeting', $id);

        return back()->with('status', 'Meeting cancelled successfully.');
    }

    public function rescheduleMeetingForm(int $id): View
    {
        $meeting = CompanyMeeting::findOrFail($id);

        return view('admin.resources.form', [
            'pageTitle' => 'Reschedule Meeting',
            'pageDescription' => 'Select a new date and time slot for the meeting: ' . $meeting->title,
            'submitUrl' => route('admin.meetings.reschedule', $id),
            'submitLabel' => 'Submit Reschedule',
            'fields' => [
                [
                    'name' => 'meeting_date',
                    'label' => 'Preferred Date',
                    'type' => 'date',
                    'required' => true,
                    'value' => optional($meeting->meeting_date)->format('Y-m-d')
                ],
                [
                    'name' => 'meeting_time',
                    'label' => 'Preferred Time',
                    'type' => 'time',
                    'required' => true,
                    'value' => $meeting->meeting_time ? \Carbon\Carbon::parse($meeting->meeting_time)->format('H:i') : ''
                ],
            ],
        ]);
    }

    public function rescheduleMeeting(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'meeting_date' => ['required', 'date'],
            'meeting_time' => ['required', 'date_format:H:i'],
        ]);

        $meeting = CompanyMeeting::findOrFail($id);
        $visitorBooking = \App\Domain\Visitor\Models\VisitorMeetingBooking::where('company_meeting_id', $meeting->id)->first();
        $visitorId = $visitorBooking?->visitor_id;
        $visitorEmail = $visitorBooking?->visitor_email ?? '';

        $engine = new \App\Domain\Shared\Services\SmartSchedulingEngine();

        $exhibitionId = \App\Domain\Booth\Models\BoothBooking::where('company_id', $meeting->company_id)->first()?->exhibition_id ?? 1;

        $validation = $engine->validateMeetingRequest(
            (int) $meeting->company_id,
            $visitorId,
            $visitorEmail,
            $request->input('meeting_date'),
            $request->input('meeting_time'),
            $meeting->meeting_type ?? 'one-to-one',
            $exhibitionId
        );

        if (! $validation['valid']) {
            $errorMsg = $validation['conflict'];
            if ($validation['suggest_slot']) {
                $suggested = $validation['suggest_slot'];
                $sDate = \Carbon\Carbon::parse($suggested->date)->format('M d, Y');
                $sTime = \Carbon\Carbon::parse($suggested->start_time)->format('h:i A');
                $errorMsg .= " Suggested next available slot: {$sDate} at {$sTime}.";
            }
            return back()->withErrors(['error' => $errorMsg])->withInput();
        }

        $oldDate = $meeting->meeting_date?->format('Y-m-d');
        $oldTime = $meeting->meeting_time;
        if ($oldDate && $oldTime) {
            $oldSlot = \App\Domain\Booth\Models\BoothMeetingSlot::where('company_id', $meeting->company_id)
                ->where('date', $oldDate)
                ->where('start_time', $oldTime)
                ->first();
            if ($oldSlot) {
                $oldSlot->update(['status' => 'available']);
            }
        }

        $newSlot = \App\Domain\Booth\Models\BoothMeetingSlot::where('company_id', $meeting->company_id)
            ->where('date', $request->input('meeting_date'))
            ->where('start_time', $request->input('meeting_time'))
            ->first();
        if ($newSlot) {
            $newSlot->update(['status' => 'booked']);
        }

        $newStart = $request->input('meeting_date') . ' ' . $request->input('meeting_time');
        $newEnd = \Carbon\Carbon::parse($newStart)->addMinutes(30)->format('Y-m-d H:i:s');

        $meeting->update([
            'meeting_date' => $request->input('meeting_date'),
            'meeting_time' => $request->input('meeting_time'),
            'start_time' => $newStart,
            'end_time' => $newEnd,
            'status' => 'rescheduled',
        ]);

        if ($visitorBooking) {
            $visitorBooking->update([
                'preferred_date' => $request->input('meeting_date'),
                'preferred_time' => $request->input('meeting_time'),
                'status' => 'rescheduled',
            ]);

            DB::table('meeting_notifications')->insert([
                'visitor_id' => $visitorBooking->visitor_id,
                'company_id' => $meeting->company_id,
                'visitor_meeting_booking_id' => $visitorBooking->id,
                'type' => 'rescheduled',
                'title' => 'Meeting Rescheduled by Admin',
                'message' => 'The meeting has been rescheduled to ' . $request->input('meeting_date') . ' ' . $request->input('meeting_time') . ' by the administrator.',
                'status' => 'unread',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        AdminAudit::log('meeting_rescheduled', 'meetings', 'company_meeting', $id, [
            'meeting_date' => $request->input('meeting_date'),
            'meeting_time' => $request->input('meeting_time'),
        ]);

        return redirect()->route('admin.meetings.index')->with('status', 'Meeting rescheduled successfully.');
    }

    public function flowDiagrams(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = DB::table('admin_flow_diagrams')
            ->when($search !== '', fn ($builder) => $builder->where('title', 'like', '%' . $search . '%'))
            ->latest('updated_at');

        return view('admin.resources.index', [
            'pageTitle' => 'Flow Diagrams',
            'pageDescription' => 'Store process maps and operational flow diagrams for the admin team.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => route('admin.flow-diagrams.create'),
            'createLabel' => 'Add Diagram',
            'stats' => [
                ['label' => 'Diagrams', 'value' => DB::table('admin_flow_diagrams')->count(), 'tone' => 'indigo'],
                ['label' => 'Published', 'value' => DB::table('admin_flow_diagrams')->where('status', 'published')->count(), 'tone' => 'green'],
                ['label' => 'Draft', 'value' => DB::table('admin_flow_diagrams')->where('status', 'draft')->count(), 'tone' => 'amber'],
                ['label' => 'Process Maps', 'value' => DB::table('admin_flow_diagrams')->where('diagram_type', 'process')->count(), 'tone' => 'rose'],
            ],
            'filters' => [],
            'columns' => ['Title', 'Slug', 'Type', 'Status', 'Updated'],
            'rows' => $query->paginate(12)->through(function ($diagram) {
                return [
                    'cells' => [
                        $diagram->title,
                        $diagram->slug,
                        ucfirst((string) $diagram->diagram_type),
                        $this->badge((string) $diagram->status),
                        $this->formatDateTime($diagram->updated_at),
                    ],
                ];
            }),
        ]);
    }

    public function createFlowDiagram(): View
    {
        return view('admin.resources.form', [
            'pageTitle' => 'Add Flow Diagram',
            'pageDescription' => 'Create a new process or flow-diagram entry.',
            'submitUrl' => route('admin.flow-diagrams.store'),
            'submitLabel' => 'Create Diagram',
            'fields' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
                ['name' => 'diagram_type', 'label' => 'Diagram Type', 'type' => 'select', 'options' => ['process' => 'Process', 'journey' => 'Journey', 'approval' => 'Approval'], 'value' => 'process'],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['draft' => 'Draft', 'published' => 'Published'], 'value' => 'draft'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
                ['name' => 'diagram_content', 'label' => 'Diagram Content', 'type' => 'textarea'],
            ],
        ]);
    }

    public function storeFlowDiagram(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:admin_flow_diagrams,slug'],
            'diagram_type' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'diagram_content' => ['nullable', 'string'],
        ]);

        $id = DB::table('admin_flow_diagrams')->insertGetId([
            'title' => $data['title'],
            'slug' => $data['slug'] ?: Str::slug($data['title']),
            'diagram_type' => $data['diagram_type'],
            'status' => $data['status'],
            'description' => $data['description'] ?? null,
            'diagram_content' => $data['diagram_content'] ?? null,
            'created_by' => session('admin_id'),
            'updated_by' => session('admin_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        AdminAudit::log('flow_diagram_created', 'flow-diagrams', 'admin_flow_diagram', $id, $data);

        return redirect()->route('admin.flow-diagrams.index')->with('status', 'Flow diagram created successfully.');
    }

    public function occupancyAnalytics(): View
    {
        $hallRows = Hall::query()
            ->with(['pavilion.exhibition', 'booths'])
            ->get()
            ->map(function (Hall $hall) {
                $totalBooths = $hall->booths->count();
                $bookedBooths = $hall->booths->where('status', 'booked')->count();
                $rate = $totalBooths > 0 ? round(($bookedBooths / $totalBooths) * 100) : 0;

                return [
                    'cells' => [
                        $hall->title,
                        $hall->pavilion?->title ?? 'N/A',
                        $hall->pavilion?->exhibition?->title ?? 'N/A',
                        (string) $totalBooths,
                        (string) $bookedBooths,
                        $rate . '%',
                    ],
                ];
            });

        $totalBooths = Booth::count();
        $bookedBooths = Booth::where('status', 'booked')->count();

        return view('admin.resources.index', [
            'pageTitle' => 'Occupancy Analytics',
            'pageDescription' => 'See booth occupancy progress across halls and exhibitions.',
            'search' => '',
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Total Booths', 'value' => $totalBooths, 'tone' => 'indigo'],
                ['label' => 'Booked', 'value' => $bookedBooths, 'tone' => 'green'],
                ['label' => 'Available', 'value' => Booth::where('status', 'available')->count(), 'tone' => 'amber'],
                ['label' => 'Occupancy Rate', 'value' => ($totalBooths > 0 ? round(($bookedBooths / $totalBooths) * 100) : 0) . '%', 'tone' => 'rose'],
            ],
            'filters' => [],
            'columns' => ['Hall', 'Pavilion', 'Exhibition', 'Total Booths', 'Booked', 'Occupancy'],
            'rows' => $hallRows,
        ]);
    }

    public function revenueBreakdown(): View
    {
        $boothRevenue = (float) BoothBooking::where('payment_status', 'paid')->sum('total_amount');
        $ticketRevenue = (float) VisitorTicket::whereIn('status', ['paid', 'confirmed', 'completed'])->sum('total_amount');
        $refunds = (float) DB::table('payment_refunds')->where('status', 'processed')->sum('amount');

        return view('admin.resources.index', [
            'pageTitle' => 'Revenue Breakdown',
            'pageDescription' => 'Summarised revenue split for booth bookings, tickets, and refunds.',
            'search' => '',
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Booth Revenue', 'value' => $this->money($boothRevenue), 'tone' => 'green'],
                ['label' => 'Ticket Revenue', 'value' => $this->money($ticketRevenue), 'tone' => 'indigo'],
                ['label' => 'Processed Refunds', 'value' => $this->money($refunds), 'tone' => 'rose'],
                ['label' => 'Net Revenue', 'value' => $this->money($boothRevenue + $ticketRevenue - $refunds), 'tone' => 'amber'],
            ],
            'filters' => [],
            'columns' => ['Source', 'Transactions', 'Gross', 'Status', 'Notes'],
            'rows' => collect([
                [
                    'cells' => [
                        'Booth Bookings',
                        (string) BoothBooking::where('payment_status', 'paid')->count(),
                        $this->money($boothRevenue),
                        $this->badge('paid'),
                        'Confirmed paid booth-booking orders',
                    ],
                ],
                [
                    'cells' => [
                        'Event Tickets',
                        (string) VisitorTicket::whereIn('status', ['paid', 'confirmed', 'completed'])->count(),
                        $this->money($ticketRevenue),
                        $this->badge('confirmed'),
                        'Paid and confirmed ticket orders',
                    ],
                ],
                [
                    'cells' => [
                        'Refunds',
                        (string) DB::table('payment_refunds')->where('status', 'processed')->count(),
                        $this->money($refunds),
                        $this->badge('refunded'),
                        'Processed refund entries',
                    ],
                ],
            ]),
        ]);
    }

    private function generalSettingsSections(): array
    {
        $defaults = [
            'general' => [
                ['key' => 'site_name', 'label' => 'Site Name', 'type' => 'text', 'value' => 'EproExpo'],
                ['key' => 'site_tagline', 'label' => 'Site Tagline', 'type' => 'text', 'value' => 'All-in-One Expo & Event Management Platform'],
                ['key' => 'support_email', 'label' => 'Support Email', 'type' => 'email', 'value' => 'support@eproexpo.test'],
                ['key' => 'support_phone', 'label' => 'Support Phone', 'type' => 'text', 'value' => '+91 98765 43210'],
            ],
            'communications' => [
                ['key' => 'default_from_name', 'label' => 'Default From Name', 'type' => 'text', 'value' => 'EproExpo Admin'],
                ['key' => 'default_from_email', 'label' => 'Default From Email', 'type' => 'email', 'value' => 'no-reply@eproexpo.test'],
                ['key' => 'booking_alerts_enabled', 'label' => 'Booking Alerts', 'type' => 'select', 'options' => ['1' => 'Enabled', '0' => 'Disabled'], 'value' => '1'],
                ['key' => 'lead_alerts_enabled', 'label' => 'Lead Alerts', 'type' => 'select', 'options' => ['1' => 'Enabled', '0' => 'Disabled'], 'value' => '1'],
            ],
            'seo' => [
                ['key' => 'meta_title', 'label' => 'Meta Title', 'type' => 'text', 'value' => 'EproExpo'],
                ['key' => 'meta_description', 'label' => 'Meta Description', 'type' => 'textarea', 'value' => 'Manage exhibitions, booths, events, tickets, and admin workflows from one place.'],
            ],
        ];

        return $this->hydrateConfigurationSections('admin_settings', 'group', $defaults, [
            'general' => ['title' => 'General Settings', 'description' => 'Platform-facing identity and support information.'],
            'communications' => ['title' => 'Communication Settings', 'description' => 'Email sender defaults and notification toggles.'],
            'seo' => ['title' => 'SEO Settings', 'description' => 'Metadata used across indexed public pages.'],
        ]);
    }

    private function systemSettingsSections(): array
    {
        $defaults = [
            'platform' => [
                ['key' => 'app_env', 'label' => 'App Environment', 'type' => 'text', 'value' => config('app.env', 'local')],
                ['key' => 'app_timezone', 'label' => 'App Timezone', 'type' => 'text', 'value' => config('app.timezone', 'Asia/Calcutta')],
                ['key' => 'maintenance_mode', 'label' => 'Maintenance Mode', 'type' => 'select', 'options' => ['0' => 'Off', '1' => 'On'], 'value' => '0'],
            ],
            'integrations' => [
                ['key' => 'payment_gateway', 'label' => 'Payment Gateway', 'type' => 'text', 'value' => 'razorpay'],
                ['key' => 'mail_driver', 'label' => 'Mail Driver', 'type' => 'text', 'value' => 'smtp'],
                ['key' => 'queue_driver', 'label' => 'Queue Driver', 'type' => 'text', 'value' => 'sync'],
            ],
            'backup' => [
                ['key' => 'backup_frequency', 'label' => 'Backup Frequency', 'type' => 'select', 'options' => ['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'], 'value' => 'daily'],
                ['key' => 'backup_retention_days', 'label' => 'Retention Days', 'type' => 'number', 'value' => '14'],
            ],
        ];

        return $this->hydrateConfigurationSections('admin_system_settings', 'category', $defaults, [
            'platform' => ['title' => 'Platform Controls', 'description' => 'Environment and runtime defaults surfaced for admin operations.'],
            'integrations' => ['title' => 'Integration Settings', 'description' => 'Payment, mail, and queue metadata used by the backend.'],
            'backup' => ['title' => 'Backup Settings', 'description' => 'Scheduling defaults for operational backups and retention.'],
        ]);
    }

    private function hydrateConfigurationSections(string $table, string $groupColumn, array $defaults, array $meta): array
    {
        $values = DB::table($table)->pluck('value', 'key');

        return collect($defaults)->map(function (array $fields, string $group) use ($values, $meta) {
            return [
                'title' => $meta[$group]['title'],
                'description' => $meta[$group]['description'],
                'fields' => collect($fields)->map(function (array $field) use ($values) {
                    $field['value'] = (string) ($values[$field['key']] ?? $field['value'] ?? '');

                    return $field;
                })->all(),
            ];
        })->values()->all();
    }

    private function persistSettings(string $table, array $settings, string $groupColumn): void
    {
        foreach ($settings as $key => $value) {
            DB::table($table)->updateOrInsert(
                ['key' => $key],
                [
                    $groupColumn => $this->inferSettingGroup($key, $table === 'admin_system_settings'),
                    'value' => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string) $value,
                    'value_type' => 'string',
                    'updated_by' => session('admin_id'),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    private function inferSettingGroup(string $key, bool $system): string
    {
        return match (true) {
            str_contains($key, 'backup') => $system ? 'backup' : 'general',
            str_contains($key, 'mail'), str_contains($key, 'queue'), str_contains($key, 'payment') => $system ? 'integrations' : 'communications',
            str_contains($key, 'meta') => 'seo',
            default => $system ? 'platform' : 'general',
        };
    }

    private function ensureGeneralSettings(): void
    {
        foreach ($this->generalSettingsSections() as $section) {
            foreach ($section['fields'] as $field) {
                DB::table('admin_settings')->updateOrInsert(
                    ['key' => $field['key']],
                    [
                        'group' => $this->inferSettingGroup($field['key'], false),
                        'value' => (string) ($field['value'] ?? ''),
                        'value_type' => 'string',
                        'updated_by' => session('admin_id'),
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }

    private function ensureSystemSettings(): void
    {
        foreach ($this->systemSettingsSections() as $section) {
            foreach ($section['fields'] as $field) {
                DB::table('admin_system_settings')->updateOrInsert(
                    ['key' => $field['key']],
                    [
                        'category' => $this->inferSettingGroup($field['key'], true),
                        'value' => (string) ($field['value'] ?? ''),
                        'value_type' => 'string',
                        'updated_by' => session('admin_id'),
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }

    private function ensureRoleCatalog(): void
    {
        $permissions = [
            ['name' => 'View Companies', 'slug' => 'companies.view', 'module' => 'companies'],
            ['name' => 'Manage Companies', 'slug' => 'companies.manage', 'module' => 'companies'],
            ['name' => 'Manage Exhibitions', 'slug' => 'exhibitions.manage', 'module' => 'exhibitions'],
            ['name' => 'Manage Booths', 'slug' => 'booths.manage', 'module' => 'booths'],
            ['name' => 'Review Approvals', 'slug' => 'approvals.review', 'module' => 'approvals'],
            ['name' => 'View Reports', 'slug' => 'reports.view', 'module' => 'reports'],
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'module' => 'settings'],
        ];

        foreach ($permissions as $permission) {
            DB::table('admin_permissions')->updateOrInsert(
                ['slug' => $permission['slug']],
                $permission + ['created_at' => now(), 'updated_at' => now()]
            );
        }

        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super-admin', 'description' => 'Full platform access', 'is_system' => true, 'is_active' => true],
            ['name' => 'Operations Admin', 'slug' => 'operations-admin', 'description' => 'Handles approvals and daily operations', 'is_system' => true, 'is_active' => true],
            ['name' => 'Content Admin', 'slug' => 'content-admin', 'description' => 'Handles CMS and communication modules', 'is_system' => true, 'is_active' => true],
        ];

        foreach ($roles as $role) {
            DB::table('admin_roles')->updateOrInsert(
                ['slug' => $role['slug']],
                $role + ['created_at' => now(), 'updated_at' => now()]
            );
        }

        $superAdminId = DB::table('admin_roles')->where('slug', 'super-admin')->value('id');
        $permissionIds = DB::table('admin_permissions')->pluck('id');

        foreach ($permissionIds as $permissionId) {
            DB::table('admin_role_permissions')->updateOrInsert(
                ['admin_role_id' => $superAdminId, 'admin_permission_id' => $permissionId],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        if (session('admin_id') && $superAdminId) {
            DB::table('admin_role_assignments')->updateOrInsert(
                ['admin_id' => session('admin_id'), 'admin_role_id' => $superAdminId],
                ['assigned_by' => session('admin_id'), 'assigned_at' => now(), 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    private function ensureKycRows(): void
    {
        $existingCompanyIds = DB::table('company_kyc_verifications')->pluck('company_id')->all();

        Company::query()
            ->whereNotIn('id', $existingCompanyIds)
            ->get(['id'])
            ->each(function (Company $company) {
                DB::table('company_kyc_verifications')->insert([
                    'company_id' => $company->id,
                    'status' => 'pending',
                    'risk_score' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    private function syncLeadsFromEnquiries(): void
    {
        $existingEnquiryIds = DB::table('admin_leads')
            ->whereNotNull('enquiry_id')
            ->pluck('enquiry_id')
            ->all();

        Enquiry::query()
            ->whereNotIn('id', $existingEnquiryIds)
            ->get(['id', 'company_id'])
            ->each(function (Enquiry $enquiry) {
                DB::table('admin_leads')->insert([
                    'company_id' => $enquiry->company_id,
                    'enquiry_id' => $enquiry->id,
                    'lead_source' => 'enquiry',
                    'lead_status' => 'new',
                    'lead_score' => 50,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    private function permissionSlugs(string $value): array
    {
        return collect(explode(',', $value))
            ->map(fn ($slug) => trim($slug))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function badge(?string $value): string
    {
        $value = $value ?: 'unknown';
        $tone = match ($value) {
            'approved', 'active', 'published', 'live', 'paid', 'confirmed', 'completed', 'available', 'open', 'replied', 'processed', 'read', 'checked_in', 'verified', 'qualified', 'converted', 'resolved' => 'green',
            'pending', 'submitted', 'pending_review', 'reserved', 'draft', 'new', 'requested', 'normal', 'contacted', 'in_progress', 'system' => 'amber',
            'rejected', 'inactive', 'cancelled', 'failed', 'refunded', 'booked', 'urgent', 'high', 'archived', 'lost', 'closed' => 'rose',
            default => 'slate',
        };

        return '<span class="inline-flex rounded-full px-3 py-1 text-[12px] font-semibold ' . $this->badgeClass($tone) . '">' . e(ucfirst(str_replace('_', ' ', $value))) . '</span>';
    }

    private function badgeClass(string $tone): string
    {
        return match ($tone) {
            'green' => 'bg-green-50 text-green-700',
            'amber' => 'bg-amber-50 text-amber-700',
            'rose' => 'bg-rose-50 text-rose-700',
            default => 'bg-slate-100 text-slate-700',
        };
    }

    private function money(float $value): string
    {
        return 'Rs. ' . number_format($value, 2);
    }

    private function formatDateTime(mixed $value): string
    {
        return $value ? date('M d, Y H:i', strtotime((string) $value)) : 'N/A';
    }

    private function formatDate(mixed $value): string
    {
        return $value ? date('M d, Y', strtotime((string) $value)) : 'N/A';
    }
}
