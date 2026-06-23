<?php

namespace App\Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Booth\Models\Booth;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothPublishRequest;
use App\Domain\Booth\Models\BoothSize;
use App\Domain\Company\Models\Company;
use App\Domain\Event\Models\CompanyEvent\CompanyEvent;
use App\Domain\Company\Models\Enquiry;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use App\Domain\Shared\Models\User;
use App\Domain\Visitor\Models\VisitorTicket;
use App\Domain\Admin\Services\DashboardMetrics;
use App\Support\AdminAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminContentController extends Controller
{
    public function dashboard(DashboardMetrics $dashboardMetrics): View
    {
        return view('backend.admin.dashboard.index', $dashboardMetrics->data());
    }

    public function companies(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = Company::query()
            ->when($status !== 'all', fn ($builder) => $builder->where('status', $status))
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($builder) use ($search) {
                    $builder->where('company_name', 'like', '%' . $search . '%')
                        ->orWhere('contact_person_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Company Management',
            'pageDescription' => 'Manage all registered companies on the platform.',
            'search' => $search,
            'status' => $status,
            'createUrl' => route('admin.companies.create'),
            'createLabel' => 'Add Company',
            'stats' => [
                ['label' => 'Total Companies', 'value' => Company::count(), 'tone' => 'indigo'],
                ['label' => 'Approved', 'value' => Company::where('status', 'approved')->count(), 'tone' => 'green'],
                ['label' => 'Pending', 'value' => Company::whereIn('status', ['pending', 'submitted', 'pending_review'])->count(), 'tone' => 'amber'],
                ['label' => 'Rejected', 'value' => Company::where('status', 'rejected')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'all' => 'All Status',
                'approved' => 'Approved',
                'pending' => 'Pending',
                'submitted' => 'Submitted',
                'pending_review' => 'Pending Review',
                'rejected' => 'Rejected',
            ],
            'columns' => ['Company Name', 'Contact Person', 'Email', 'Status', 'Registered On'],
            'rows' => $query->paginate(12)->through(function (Company $company) {
                return [
                    'url' => route('admin.companies.manage', $company),
                    'cells' => [
                        $company->company_name,
                        $company->contact_person_name,
                        $company->email,
                        $this->badge($company->status),
                        $company->created_at?->format('M d, Y') ?? 'N/A',
                    ],
                    'actions' => [[
                        'label' => 'Manage',
                        'href' => route('admin.companies.manage', $company),
                    ]],
                ];
            }),
        ]);
    }

    public function companyApprovals(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $rows = Company::query()
            ->whereIn('status', ['pending', 'submitted', 'pending_review', 'rejected'])
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($builder) use ($search) {
                    $builder->where('company_name', 'like', '%' . $search . '%')
                        ->orWhere('contact_person_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(12)
            ->through(function (Company $company) {
                return [
                    'url' => null,
                    'cells' => [
                        $company->company_name,
                        $company->contact_person_name,
                        $company->email,
                        $this->badge($company->status),
                        $company->created_at?->format('M d, Y') ?? 'N/A',
                    ],
                    'actions' => [
                        [
                            'label' => 'Approve',
                            'href' => route('admin.company-approval.approve', $company),
                            'method' => 'POST',
                            'variant' => 'success',
                        ],
                        [
                            'label' => 'Reject',
                            'href' => route('admin.company-approval.reject', $company),
                            'method' => 'POST',
                            'variant' => 'danger',
                        ],
                    ],
                ];
            });

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Company Approval',
            'pageDescription' => 'Review pending and rejected company registrations.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Pending', 'value' => Company::whereIn('status', ['pending', 'submitted', 'pending_review'])->count(), 'tone' => 'amber'],
                ['label' => 'Approved', 'value' => Company::where('status', 'approved')->count(), 'tone' => 'green'],
                ['label' => 'Rejected', 'value' => Company::where('status', 'rejected')->count(), 'tone' => 'rose'],
            ],
            'filters' => [],
            'columns' => ['Company Name', 'Contact Person', 'Email', 'Status', 'Registered On'],
            'rows' => $rows,
        ]);
    }

    public function approveCompany(Company $company): RedirectResponse
    {
        $company->update([
            'status' => 'approved',
            'approved_by' => session('admin_id'),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        AdminAudit::log('company_approved', 'companies', 'company', $company->id, [
            'status' => 'approved',
        ]);

        return back()->with('status', 'Company approved successfully.');
    }

    public function rejectCompany(Company $company): RedirectResponse
    {
        $company->update([
            'status' => 'rejected',
            'rejection_reason' => 'Rejected by admin',
        ]);

        AdminAudit::log('company_rejected', 'companies', 'company', $company->id, [
            'status' => 'rejected',
        ]);

        return back()->with('status', 'Company rejected.');
    }

    public function createCompany(): View
    {
        return view('backend.admin.resources.form', [
            'pageTitle' => 'Add Company',
            'pageDescription' => 'Register a new company on the platform.',
            'submitUrl' => route('admin.companies.store'),
            'submitLabel' => 'Create Company',
            'fields' => [
                ['name' => 'company_name', 'label' => 'Company Name', 'type' => 'text', 'required' => true],
                ['name' => 'contact_person_name', 'label' => 'Contact Person', 'type' => 'text', 'required' => true],
                ['name' => 'email', 'label' => 'Company Email', 'type' => 'email', 'required' => true],
                ['name' => 'phone', 'label' => 'Phone', 'type' => 'text'],
                ['name' => 'website', 'label' => 'Website', 'type' => 'text'],
                ['name' => 'industry', 'label' => 'Industry', 'type' => 'text'],
                ['name' => 'city', 'label' => 'City', 'type' => 'text'],
                ['name' => 'country', 'label' => 'Country', 'type' => 'text'],
                ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'required' => true, 'placeholder' => 'Set company login password'],
                [
                    'name' => 'status',
                    'label' => 'Status',
                    'type' => 'select',
                    'options' => ['approved' => 'Approved', 'pending' => 'Pending', 'rejected' => 'Rejected'],
                    'value' => 'approved',
                ],
            ],
        ]);
    }

    public function storeCompany(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_person_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:companies,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'website' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        Company::create($data + ['password' => Hash::make($data['password'])]);

        $company = Company::where('email', $data['email'])->latest('id')->first();
        AdminAudit::log('company_created', 'companies', 'company', $company?->id, [
            'email' => $data['email'],
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.companies.index')->with('status', 'Company created successfully.');
    }

    public function exhibitions(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = Exhibition::query()
            ->withCount('pavilions')
            ->when($status !== 'all', fn ($builder) => $builder->where('status', $status))
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($builder) use ($search) {
                    $builder->where('title', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%');
                });
            })
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Exhibition Management',
            'pageDescription' => 'Manage all exhibitions on the platform.',
            'search' => $search,
            'status' => $status,
            'createUrl' => route('admin.exhibitions.create'),
            'createLabel' => 'Add Exhibition',
            'stats' => [
                ['label' => 'Total Exhibitions', 'value' => Exhibition::count(), 'tone' => 'indigo'],
                ['label' => 'Live on Website', 'value' => \App\Support\LiveContent::exhibitionQuery()->count(), 'tone' => 'green'],
                ['label' => 'Draft', 'value' => Exhibition::where('status', 'draft')->count(), 'tone' => 'rose'],
                ['label' => 'Pending Publish', 'value' => Exhibition::where('approval_status', 'approved')->where('publish_status', '!=', 'published')->count(), 'tone' => 'amber'],
            ],
            'filters' => [
                'all' => 'All Status',
                'active' => 'Active',
                'published' => 'Published',
                'live' => 'Live',
                'draft' => 'Draft',
            ],
            'columns' => ['Title', 'Location', 'Dates', 'Pavilions', 'Status'],
            'rows' => $query->paginate(12)->through(function (Exhibition $exhibition) {
                $actions = [];
                if ($exhibition->approval_status !== 'approved') {
                    $actions[] = [
                        'label' => 'Approve',
                        'href' => route('admin.exhibitions.approve', $exhibition),
                        'method' => 'POST',
                        'variant' => 'success',
                    ];
                }
                if ($exhibition->approval_status === 'approved' && $exhibition->publish_status !== 'published') {
                    $actions[] = [
                        'label' => 'Publish',
                        'href' => route('admin.exhibitions.publish', $exhibition),
                        'method' => 'POST',
                        'variant' => 'success',
                    ];
                }
                if ($exhibition->publish_status === 'published') {
                    $actions[] = [
                        'label' => 'Unpublish',
                        'href' => route('admin.exhibitions.unpublish', $exhibition),
                        'method' => 'POST',
                        'variant' => 'danger',
                    ];
                }

                return [
                    'cells' => [
                        $exhibition->title ?: $exhibition->name,
                        $exhibition->location ?: ($exhibition->venue ?: 'N/A'),
                        trim(($exhibition->start_date?->format('M d, Y') ?? 'TBD') . ' - ' . ($exhibition->end_date?->format('M d, Y') ?? 'TBD')),
                        (string) $exhibition->pavilions_count,
                        $this->badge($exhibition->status) . ' ' . $this->badge($exhibition->publish_status ?: 'draft'),
                    ],
                    'actions' => $actions,
                ];
            }),
        ]);
    }

    public function createExhibition(): View
    {
        return view('backend.admin.resources.form', [
            'pageTitle' => 'Add Exhibition',
            'pageDescription' => 'Create a new exhibition record.',
            'submitUrl' => route('admin.exhibitions.store'),
            'submitLabel' => 'Create Exhibition',
            'fields' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
                ['name' => 'location', 'label' => 'Location', 'type' => 'text'],
                ['name' => 'start_date', 'label' => 'Start Date', 'type' => 'date'],
                ['name' => 'end_date', 'label' => 'End Date', 'type' => 'date'],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Active', 'draft' => 'Draft', 'published' => 'Published'], 'value' => 'active'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
            ],
        ]);
    }

    public function storeExhibition(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $counter = 2;
        while (Exhibition::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // Force the exhibition to be published and live so that companies and visitors can access it
        $status = $data['status'];
        if ($status === 'draft') {
            $status = 'active';
        }

        $exhibition = Exhibition::create(array_merge($data, [
            'slug' => $slug,
            'name' => $data['title'],
            'venue' => $data['location'] ?? null,
            'status' => $status,
            'approval_status' => 'approved',
            'publish_status' => 'published',
            'published_at' => now(),
            'approved_at' => now(),
        ]));

        AdminAudit::log('exhibition_created', 'exhibitions', 'exhibition', $exhibition->id, [
            'title' => $data['title'],
            'status' => $status,
        ]);

        return redirect()->route('admin.exhibitions.index')->with('status', 'Exhibition created and published successfully.');
    }

    public function approveExhibition(Exhibition $exhibition): RedirectResponse
    {
        $exhibition->update([
            'approval_status' => 'approved',
            'approved_at' => now(),
        ]);

        AdminAudit::log('exhibition_approved', 'exhibitions', 'exhibition', $exhibition->id);

        return back()->with('status', 'Exhibition approved.');
    }

    public function publishExhibition(Exhibition $exhibition): RedirectResponse
    {
        if ($exhibition->approval_status !== 'approved') {
            return back()->withErrors(['publish' => 'Exhibition must be approved before publishing.']);
        }

        $exhibition->update([
            'publish_status' => 'published',
            'published_at' => now(),
            'status' => in_array($exhibition->status, ['draft'], true) ? 'active' : $exhibition->status,
        ]);

        AdminAudit::log('exhibition_published', 'exhibitions', 'exhibition', $exhibition->id);

        return back()->with('status', 'Exhibition is now live for companies and visitors.');
    }

    public function unpublishExhibition(Exhibition $exhibition): RedirectResponse
    {
        $exhibition->update([
            'publish_status' => 'unpublished',
            'status' => in_array($exhibition->status, ['active', 'published', 'live'], true) ? 'inactive' : $exhibition->status,
        ]);

        AdminAudit::log('exhibition_unpublished', 'exhibitions', 'exhibition', $exhibition->id);

        return back()->with('status', 'Exhibition has been unpublished.');
    }

    public function pavilions(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = Pavilion::query()
            ->with('exhibition')
            ->withCount(['halls', 'booths'])
            ->when($search !== '', fn ($builder) => $builder->where('title', 'like', '%' . $search . '%'))
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Pavilion Management',
            'pageDescription' => 'Manage pavilions linked to exhibitions.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => route('admin.pavilions.create'),
            'createLabel' => 'Add Pavilion',
            'stats' => [
                ['label' => 'Total Pavilions', 'value' => Pavilion::count(), 'tone' => 'indigo'],
                ['label' => 'Active', 'value' => Pavilion::where('status', 'active')->count(), 'tone' => 'green'],
                ['label' => 'Halls', 'value' => Hall::count(), 'tone' => 'amber'],
            ],
            'filters' => [],
            'columns' => ['Pavilion', 'Exhibition', 'Halls', 'Booths', 'Status'],
            'rows' => $query->paginate(12)->through(function (Pavilion $pavilion) {
                return [
                    'cells' => [
                        $pavilion->title,
                        $pavilion->exhibition?->title ?? 'N/A',
                        (string) $pavilion->halls_count,
                        (string) ($pavilion->booths_count ?? 0),
                        $this->badge($pavilion->status),
                    ],
                    'actions' => [
                        [
                            'label' => 'Edit',
                            'href' => route('admin.pavilions.edit', $pavilion->id),
                            'method' => 'GET',
                        ],
                    ],
                ];
            }),
        ]);
    }

    public function createPavilion(): View
    {
        return view('backend.admin.resources.form', [
            'pageTitle' => 'Add Pavilion',
            'pageDescription' => 'Create a new pavilion inside an exhibition.',
            'submitUrl' => route('admin.pavilions.store'),
            'submitLabel' => 'Create Pavilion',
            'fields' => [
                ['name' => 'exhibition_id', 'label' => 'Exhibition', 'type' => 'select', 'required' => true, 'options' => Exhibition::orderBy('title')->pluck('title', 'id')->all()],
                ['name' => 'title', 'label' => 'Pavilion Title', 'type' => 'text', 'required' => true],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Active', 'inactive' => 'Inactive'], 'value' => 'active'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
            ],
        ]);
    }

    public function storePavilion(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'exhibition_id' => ['required', 'exists:exhibitions,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $slug = Str::slug($data['title']);
        $pavilion = Pavilion::create($data + ['slug' => $slug, 'total_halls' => 0, 'total_booths' => 0]);

        AdminAudit::log('pavilion_created', 'pavilions', 'pavilion', $pavilion->id, [
            'title' => $data['title'],
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.pavilions.index')->with('status', 'Pavilion created successfully.');
    }

    public function editPavilion(Pavilion $pavilion): View
    {
        return view('backend.admin.resources.form', [
            'pageTitle' => 'Edit Pavilion',
            'pageDescription' => 'Edit the pavilion details.',
            'submitUrl' => route('admin.pavilions.update', $pavilion->id),
            'submitLabel' => 'Update Pavilion',
            'method' => 'PUT',
            'fields' => [
                ['name' => 'exhibition_id', 'label' => 'Exhibition', 'type' => 'select', 'required' => true, 'options' => Exhibition::orderBy('title')->pluck('title', 'id')->all(), 'value' => $pavilion->exhibition_id],
                ['name' => 'title', 'label' => 'Pavilion Title', 'type' => 'text', 'required' => true, 'value' => $pavilion->title],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Active', 'inactive' => 'Inactive'], 'value' => $pavilion->status],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => $pavilion->description],
            ],
        ]);
    }

    public function updatePavilion(Request $request, Pavilion $pavilion): RedirectResponse
    {
        $data = $request->validate([
            'exhibition_id' => ['required', 'exists:exhibitions,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $slug = Str::slug($data['title']);
        $pavilion->update($data + ['slug' => $slug]);

        AdminAudit::log('pavilion_updated', 'pavilions', 'pavilion', $pavilion->id, [
            'title' => $data['title'],
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.pavilions.index')->with('status', 'Pavilion updated successfully.');
    }

    public function halls(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = Hall::query()
            ->with(['pavilion.exhibition'])
            ->withCount('booths')
            ->when($search !== '', fn ($builder) => $builder->where('title', 'like', '%' . $search . '%'))
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Hall Management',
            'pageDescription' => 'Manage halls and booth capacity under each pavilion.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => route('admin.halls.create'),
            'createLabel' => 'Add Hall',
            'stats' => [
                ['label' => 'Total Halls', 'value' => Hall::count(), 'tone' => 'indigo'],
                ['label' => 'Booths', 'value' => Booth::count(), 'tone' => 'green'],
            ],
            'filters' => [],
            'columns' => ['Hall', 'Pavilion', 'Exhibition', 'Booths', 'Status'],
            'rows' => $query->paginate(12)->through(function (Hall $hall) {
                return [
                    'cells' => [
                        $hall->title,
                        $hall->pavilion?->title ?? 'N/A',
                        $hall->pavilion?->exhibition?->title ?? 'N/A',
                        (string) $hall->booths_count,
                        $this->badge($hall->status),
                    ],
                    'actions' => [
                        [
                            'label' => 'Edit',
                            'href' => route('admin.halls.edit', $hall->id),
                            'method' => 'GET',
                        ],
                    ],
                ];
            }),
        ]);
    }

    public function createHall(): View
    {
        return view('backend.admin.resources.form', [
            'pageTitle' => 'Add Hall',
            'pageDescription' => 'Create a new hall under a pavilion.',
            'submitUrl' => route('admin.halls.store'),
            'submitLabel' => 'Create Hall',
            'fields' => [
                ['name' => 'pavilion_id', 'label' => 'Pavilion', 'type' => 'select', 'required' => true, 'options' => Pavilion::orderBy('title')->pluck('title', 'id')->all()],
                ['name' => 'title', 'label' => 'Hall Title', 'type' => 'text', 'required' => true],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Active', 'inactive' => 'Inactive'], 'value' => 'active'],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
            ],
        ]);
    }

    public function storeHall(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'pavilion_id' => ['required', 'exists:pavilions,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $hall = Hall::create($data + ['slug' => Str::slug($data['title']), 'total_booths' => 0]);

        AdminAudit::log('hall_created', 'halls', 'hall', $hall->id, [
            'title' => $data['title'],
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.halls.index')->with('status', 'Hall created successfully.');
    }

    public function editHall(Hall $hall): View
    {
        return view('backend.admin.resources.form', [
            'pageTitle' => 'Edit Hall',
            'pageDescription' => 'Edit the hall details.',
            'submitUrl' => route('admin.halls.update', $hall->id),
            'submitLabel' => 'Update Hall',
            'method' => 'PUT',
            'fields' => [
                ['name' => 'pavilion_id', 'label' => 'Pavilion', 'type' => 'select', 'required' => true, 'options' => Pavilion::orderBy('title')->pluck('title', 'id')->all(), 'value' => $hall->pavilion_id],
                ['name' => 'title', 'label' => 'Hall Title', 'type' => 'text', 'required' => true, 'value' => $hall->title],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['active' => 'Active', 'inactive' => 'Inactive'], 'value' => $hall->status],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => $hall->description],
            ],
        ]);
    }

    public function updateHall(Request $request, Hall $hall): RedirectResponse
    {
        $data = $request->validate([
            'pavilion_id' => ['required', 'exists:pavilions,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $slug = Str::slug($data['title']);
        $hall->update($data + ['slug' => $slug]);

        AdminAudit::log('hall_updated', 'halls', 'hall', $hall->id, [
            'title' => $data['title'],
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.halls.index')->with('status', 'Hall updated successfully.');
    }

    public function booths(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', 'all');

        $query = Booth::query()
            ->with(['hall.pavilion.exhibition', 'boothSize'])
            ->when($status !== 'all', fn ($builder) => $builder->where('status', $status))
            ->when($search !== '', fn ($builder) => $builder->where('booth_number', 'like', '%' . $search . '%'))
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Booth Management',
            'pageDescription' => 'Manage booth inventory and assignment status.',
            'search' => $search,
            'status' => $status,
            'createUrl' => route('admin.booths.create'),
            'createLabel' => 'Add Booth',
            'stats' => [
                ['label' => 'Total Booths', 'value' => Booth::count(), 'tone' => 'indigo'],
                ['label' => 'Available', 'value' => Booth::where('status', 'available')->count(), 'tone' => 'green'],
                ['label' => 'Booked', 'value' => Booth::where('status', 'booked')->count(), 'tone' => 'amber'],
            ],
            'filters' => [
                'all' => 'All Status',
                'available' => 'Available',
                'booked' => 'Booked',
                'reserved' => 'Reserved',
            ],
            'columns' => ['Booth', 'Hall', 'Pavilion', 'Size', 'Price', 'Status'],
            'rows' => $query->paginate(12)->through(function (Booth $booth) {
                return [
                    'cells' => [
                        $booth->booth_number,
                        $booth->hall?->title ?? 'N/A',
                        $booth->hall?->pavilion?->title ?? 'N/A',
                        $booth->boothSize?->title ?? 'N/A',
                        $this->money($booth->price),
                        $this->badge($booth->status),
                    ],
                    'actions' => [
                        [
                            'label' => 'Edit',
                            'href' => route('admin.booths.edit', $booth->id),
                            'method' => 'GET',
                        ],
                    ],
                ];
            }),
        ]);
    }

    public function createBooth(): View
    {
        $hallOptions = Hall::query()
            ->with('pavilion.exhibition')
            ->orderBy('title')
            ->get()
            ->mapWithKeys(function (Hall $hall) {
                $exhibitionTitle = $hall->pavilion?->exhibition?->title ?? 'No exhibition';
                $pavilionTitle = $hall->pavilion?->title ?? 'No pavilion';

                return [$hall->id => "{$exhibitionTitle} - {$pavilionTitle} - {$hall->title}"];
            })
            ->all();

        return view('backend.admin.resources.form', [
            'pageTitle' => 'Add Booth',
            'pageDescription' => 'Create a booth slot inside a hall.',
            'submitUrl' => route('admin.booths.store'),
            'submitLabel' => 'Create Booth',
            'fields' => [
                ['name' => 'hall_id', 'label' => 'Hall', 'type' => 'select', 'required' => true, 'options' => $hallOptions],
                ['name' => 'booth_size_id', 'label' => 'Booth Size', 'type' => 'select', 'options' => ['' => 'Select size'] + BoothSize::orderBy('title')->pluck('title', 'id')->all()],
                ['name' => 'booth_number', 'label' => 'Booth Number', 'type' => 'text', 'required' => true],
                ['name' => 'price', 'label' => 'Price', 'type' => 'number', 'step' => '0.01', 'value' => '0'],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['available' => 'Available', 'booked' => 'Booked', 'reserved' => 'Reserved'], 'value' => 'available'],
            ],
        ]);
    }

    public function storeBooth(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'hall_id' => ['required', 'exists:halls,id'],
            'booth_size_id' => ['nullable', 'exists:booth_sizes,id'],
            'booth_number' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $booth = Booth::create($data);

        AdminAudit::log('booth_created', 'booths', 'booth', $booth->id, [
            'booth_number' => $data['booth_number'],
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.booths.index')->with('status', 'Booth created successfully.');
    }

    public function editBooth(Booth $booth): View
    {
        $hallOptions = Hall::query()
            ->with('pavilion.exhibition')
            ->orderBy('title')
            ->get()
            ->mapWithKeys(function (Hall $hall) {
                $exhibitionTitle = $hall->pavilion?->exhibition?->title ?? 'No exhibition';
                $pavilionTitle = $hall->pavilion?->title ?? 'No pavilion';

                return [$hall->id => "{$exhibitionTitle} - {$pavilionTitle} - {$hall->title}"];
            })
            ->all();

        return view('backend.admin.resources.form', [
            'pageTitle' => 'Edit Booth',
            'pageDescription' => 'Edit the booth slot details.',
            'submitUrl' => route('admin.booths.update', $booth->id),
            'submitLabel' => 'Update Booth',
            'method' => 'PUT',
            'fields' => [
                ['name' => 'hall_id', 'label' => 'Hall', 'type' => 'select', 'required' => true, 'options' => $hallOptions, 'value' => $booth->hall_id],
                ['name' => 'booth_size_id', 'label' => 'Booth Size', 'type' => 'select', 'options' => ['' => 'Select size'] + BoothSize::orderBy('title')->pluck('title', 'id')->all(), 'value' => $booth->booth_size_id],
                ['name' => 'booth_number', 'label' => 'Booth Number', 'type' => 'text', 'required' => true, 'value' => $booth->booth_number],
                ['name' => 'price', 'label' => 'Price', 'type' => 'number', 'step' => '0.01', 'value' => $booth->price],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['available' => 'Available', 'booked' => 'Booked', 'reserved' => 'Reserved'], 'value' => $booth->status],
            ],
        ]);
    }

    public function updateBooth(Request $request, Booth $booth): RedirectResponse
    {
        $data = $request->validate([
            'hall_id' => ['required', 'exists:halls,id'],
            'booth_size_id' => ['nullable', 'exists:booth_sizes,id'],
            'booth_number' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric'],
            'status' => ['required', 'string', 'max:50'],
        ]);

        $booth->update($data);

        AdminAudit::log('booth_updated', 'booths', 'booth', $booth->id, [
            'booth_number' => $data['booth_number'],
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.booths.index')->with('status', 'Booth updated successfully.');
    }

    public function events(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = CompanyEvent::query()
            ->with(['company', 'ticketTypes'])
            ->when($search !== '', fn ($builder) => $builder->where('title', 'like', '%' . $search . '%'))
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Event Management',
            'pageDescription' => 'Review company-created event inventory.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Total Events', 'value' => CompanyEvent::count(), 'tone' => 'indigo'],
                ['label' => 'Live on Website', 'value' => \App\Support\LiveContent::companyEventQuery()->count(), 'tone' => 'green'],
                ['label' => 'Draft', 'value' => CompanyEvent::where('status', 'draft')->count(), 'tone' => 'amber'],
            ],
            'filters' => [],
            'columns' => ['Event', 'Company', 'Mode', 'Starts', 'Status'],
            'rows' => $query->paginate(12)->through(function (CompanyEvent $event) {
                return [
                    'cells' => [
                        $event->title,
                        $event->company?->company_name ?? 'N/A',
                        ucfirst((string) $event->event_mode),
                        $event->starts_at?->format('M d, Y H:i') ?? 'TBD',
                        $this->badge($event->status),
                    ],
                ];
            }),
        ]);
    }

    public function tickets(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = VisitorTicket::query()
            ->with(['user', 'companyEvent', 'ticketType'])
            ->when($search !== '', fn ($builder) => $builder->where('order_number', 'like', '%' . $search . '%'))
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Ticket Management',
            'pageDescription' => 'Track booked event tickets and attendee allocations.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Total Tickets', 'value' => VisitorTicket::count(), 'tone' => 'indigo'],
                ['label' => 'Paid', 'value' => VisitorTicket::whereIn('status', ['paid', 'confirmed', 'completed'])->count(), 'tone' => 'green'],
                ['label' => 'Pending', 'value' => VisitorTicket::where('status', 'pending')->count(), 'tone' => 'amber'],
            ],
            'filters' => [],
            'columns' => ['Order', 'Attendee', 'Event', 'Ticket', 'Amount', 'Status'],
            'rows' => $query->paginate(12)->through(function (VisitorTicket $ticket) {
                return [
                    'cells' => [
                        $ticket->order_number ?: ('TKT-' . $ticket->id),
                        $ticket->attendee_name ?: ($ticket->user?->name ?? 'Visitor'),
                        $ticket->companyEvent?->title ?? 'N/A',
                        $ticket->ticket_name ?: ($ticket->ticketType?->name ?? 'General'),
                        $this->money($ticket->total_amount),
                        $this->badge($ticket->status),
                    ],
                ];
            }),
        ]);
    }

    public function payments(): View
    {
        $boothPayments = BoothBooking::query()
            ->with(['company', 'exhibition'])
            ->where('payment_status', 'paid')
            ->latest()
            ->take(10)
            ->get()
            ->map(function (BoothBooking $booking) {
                return [
                    'cells' => [
                        'Booth Booking',
                        $booking->company?->company_name ?? 'Company',
                        $booking->exhibition?->title ?? 'Exhibition',
                        $this->money($booking->total_amount),
                        $this->badge($booking->admin_status ?: 'pending'),
                    ],
                ];
            });

        $ticketPayments = VisitorTicket::query()
            ->with(['user', 'companyEvent'])
            ->whereIn('status', ['paid', 'confirmed', 'completed'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function (VisitorTicket $ticket) {
                return [
                    'cells' => [
                        'Event Ticket',
                        $ticket->attendee_name ?: ($ticket->user?->name ?? 'Visitor'),
                        $ticket->companyEvent?->title ?? 'Event',
                        $this->money($ticket->total_amount),
                        $this->badge($ticket->status),
                    ],
                ];
            });

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Payments',
            'pageDescription' => 'Monitor incoming revenue across booth bookings and ticket sales.',
            'search' => '',
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Booth Revenue', 'value' => $this->money((float) BoothBooking::where('payment_status', 'paid')->sum('total_amount')), 'tone' => 'green'],
                ['label' => 'Ticket Revenue', 'value' => $this->money((float) VisitorTicket::whereIn('status', ['paid', 'confirmed', 'completed'])->sum('total_amount')), 'tone' => 'indigo'],
            ],
            'filters' => [],
            'columns' => ['Type', 'Customer', 'Item', 'Amount', 'Status'],
            'rows' => $boothPayments->concat($ticketPayments),
        ]);
    }

    public function enquiries(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = Enquiry::query()
            ->with(['company', 'visitor'])
            ->when($search !== '', fn ($builder) => $builder->where('subject', 'like', '%' . $search . '%'))
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Enquiries',
            'pageDescription' => 'Track all platform enquiries sent to companies.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Total Enquiries', 'value' => Enquiry::count(), 'tone' => 'indigo'],
                ['label' => 'New', 'value' => Enquiry::where('status', 'new')->count(), 'tone' => 'amber'],
                ['label' => 'Replied', 'value' => Enquiry::where('status', 'replied')->count(), 'tone' => 'green'],
            ],
            'filters' => [],
            'columns' => ['Subject', 'Company', 'Visitor', 'Email', 'Status'],
            'rows' => $query->paginate(12)->through(function (Enquiry $enquiry) {
                return [
                    'cells' => [
                        $enquiry->subject ?: 'General Enquiry',
                        $enquiry->company?->company_name ?? 'N/A',
                        $enquiry->name ?: ($enquiry->visitor?->name ?? 'Visitor'),
                        $enquiry->email,
                        $this->badge($enquiry->status),
                    ],
                ];
            }),
        ]);
    }

    public function users(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = User::query()
            ->when($search !== '', fn ($builder) => $builder->where('name', 'like', '%' . $search . '%'))
            ->latest();

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Users',
            'pageDescription' => 'Review registered user accounts and visitor roles.',
            'search' => $search,
            'status' => 'all',
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Total Users', 'value' => User::count(), 'tone' => 'indigo'],
                ['label' => 'Companies Linked', 'value' => Company::whereNotNull('user_id')->count(), 'tone' => 'green'],
            ],
            'filters' => [],
            'columns' => ['Name', 'Email', 'Phone', 'Role', 'Joined'],
            'rows' => $query->paginate(12)->through(function (User $user) {
                return [
                    'cells' => [
                        $user->name,
                        $user->email,
                        $user->phone ?: 'N/A',
                        ucfirst((string) ($user->role ?: 'user')),
                        $user->created_at?->format('M d, Y') ?? 'N/A',
                    ],
                ];
            }),
        ]);
    }

    public function exhibitionLifecycle(Request $request): View
    {
        $request->merge(['status' => $request->query('status', 'all')]);

        $view = $this->exhibitions($request);
        $data = $view->getData();
        $data['pageTitle'] = 'Exhibition Lifecycle';
        $data['pageDescription'] = 'Track exhibition status from draft through publish and completion.';

        return view('backend.admin.resources.index', $data);
    }

    public function boothEngineeringReview(Request $request): View
    {
        $status = (string) $request->query('status', 'pending');

        $rows = BoothPublishRequest::query()
            ->with(['boothBooking.company', 'boothBooking.booth'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(12)
            ->through(function (BoothPublishRequest $request) {
                $booking = $request->boothBooking;

                return [
                    'cells' => [
                        $booking?->company?->company_name ?? 'Company',
                        $booking?->booth?->booth_number ?? 'Booth',
                        $this->badge($request->status),
                        $request->updated_at?->format('M d, Y') ?? 'N/A',
                    ],
                    'actions' => [[
                        'label' => 'Review',
                        'href' => route('admin.booth-approvals.show', $request),
                    ]],
                ];
            });

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Booth Engineering Review',
            'pageDescription' => 'Engineering and compliance review for submitted booth setups.',
            'search' => '',
            'status' => $status,
            'createUrl' => null,
            'createLabel' => null,
            'stats' => [
                ['label' => 'Pending Engineering', 'value' => BoothPublishRequest::where('status', 'pending')->count(), 'tone' => 'amber'],
                ['label' => 'Approved', 'value' => BoothPublishRequest::where('status', 'approved')->count(), 'tone' => 'green'],
                ['label' => 'Rejected', 'value' => BoothPublishRequest::where('status', 'rejected')->count(), 'tone' => 'rose'],
            ],
            'filters' => [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'all' => 'All',
            ],
            'columns' => ['Company', 'Booth', 'Status', 'Last Updated'],
            'rows' => $rows,
        ]);
    }

    public function eventLogisticsReview(Request $request): View
    {
        $status = (string) $request->query('status', 'pending');

        $rows = CompanyEvent::query()
            ->with('company')
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(12)
            ->through(function (CompanyEvent $event) {
                return [
                    'cells' => [
                        $event->title,
                        $event->company?->company_name ?? 'Company',
                        $event->venue ?: 'N/A',
                        $this->badge($event->status),
                        $event->start_date?->format('M d, Y') ?? 'TBD',
                    ],
                ];
            });

        return view('backend.admin.resources.index', [
            'pageTitle' => 'Event Logistics Review',
            'pageDescription' => 'Review event logistics, venue, and operational readiness.',
            'search' => '',
            'status' => $status,
            'createUrl' => route('admin.event-approvals.index'),
            'createLabel' => 'Publish Requests',
            'stats' => [
                ['label' => 'Total Events', 'value' => CompanyEvent::count(), 'tone' => 'indigo'],
                ['label' => 'Live on Website', 'value' => \App\Support\LiveContent::companyEventQuery()->count(), 'tone' => 'green'],
                ['label' => 'Draft', 'value' => CompanyEvent::where('status', 'draft')->count(), 'tone' => 'amber'],
            ],
            'filters' => [
                'all' => 'All Status',
                'draft' => 'Draft',
                'published' => 'Published',
                'live' => 'Live',
            ],
            'columns' => ['Event', 'Company', 'Venue', 'Status', 'Start Date'],
            'rows' => $rows,
        ]);
    }

    public function reports(DashboardMetrics $dashboardMetrics): View
    {
        $data = $dashboardMetrics->data();

        return view('backend.admin.reports.dynamic', $data);
    }

    public function resolveImportedPage(string $page): RedirectResponse|View
    {
        $page = preg_replace('/\.html$/', '', $page) ?: $page;

        $aliases = [
            'login' => route('admin.login'),
            'admin_dashboard' => route('admin.dashboard'),
            'companies' => route('admin.companies.index'),
            'company_approval' => route('admin.company-approval.index'),
            'add_company' => route('admin.companies.create'),
            'exhibitions' => route('admin.exhibitions.index'),
            'add_exhibition' => route('admin.exhibitions.create'),
            'pavilions' => route('admin.pavilions.index'),
            'add_pavilion' => route('admin.pavilions.create'),
            'halls' => route('admin.halls.index'),
            'add_hall' => route('admin.halls.create'),
            'booths' => route('admin.booths.index'),
            'add_booth' => route('admin.booths.create'),
            'booth_management' => route('admin.booth-bookings.index'),
            'booth_setup_review' => route('admin.booth-approvals.index'),
            'booth_setup_review_details' => route('admin.booth-approvals.preview'),
            'events' => route('admin.events.index'),
            'event_approval' => route('admin.event-approvals.index'),
            'event_setup_review' => route('admin.event-approvals.preview'),
            'tickets' => route('admin.event-tickets.index'),
            'payments' => route('admin.payments.index'),
            'reports' => route('admin.reports.index'),
            'enquiries' => route('admin.enquiries.index'),
            'notifications' => route('admin.notifications.index'),
            'cms' => route('admin.cms.index'),
            'support' => route('admin.support.index'),
            'users' => route('admin.users.index'),
            'roles' => route('admin.roles.index'),
            'settings' => route('admin.settings.index'),
            'system_settings' => route('admin.system-settings.index'),
            'activity_logs' => route('admin.activity-logs.index'),
            'sidebar' => asset('admin-flow/sidebar.html'),
            '01_login' => route('admin.login'),
            '02_admin_dashboard' => route('admin.dashboard'),
            '03_companies' => route('admin.companies.index'),
            '04_company_approval' => route('admin.company-approval.index'),
            '06_add_company' => route('admin.companies.create'),
            '07_exhibitions' => route('admin.exhibitions.index'),
            '08_add_exhibition' => route('admin.exhibitions.create'),
            '10_pavilions' => route('admin.pavilions.index'),
            '11_add_pavilion' => route('admin.pavilions.create'),
            '12_halls' => route('admin.halls.index'),
            '13_add_hall' => route('admin.halls.create'),
            '14_booths' => route('admin.booths.index'),
            '15_add_booth' => route('admin.booths.create'),
            '16_booth_management' => route('admin.booth-bookings.index'),
            '17_booth_setup_review' => route('admin.booth-approvals.index'),
            '18_booth_setup_review_details' => route('admin.booth-approvals.preview'),
            '20_events' => route('admin.events.index'),
            '21_event_approval' => route('admin.event-approvals.index'),
            '22_event_setup_review' => route('admin.event-approvals.preview'),
            '27_tickets' => route('admin.event-tickets.index'),
            '28_payments' => route('admin.payments.index'),
            '30_reports' => route('admin.reports.index'),
            '31_revenue_breakdown_reports' => route('admin.revenue-breakdown.index'),
            '32_occupancy_analytics' => route('admin.occupancy-analytics.index'),
            '33_enquiries' => route('admin.enquiries.index'),
            '34_notifications' => route('admin.notifications.index'),
            '35_cms' => route('admin.cms.index'),
            '36_support' => route('admin.support.index'),
            '37_users' => route('admin.users.index'),
            '38_roles' => route('admin.roles.index'),
            '39_settings' => route('admin.settings.index'),
            '40_system_settings' => route('admin.system-settings.index'),
            '41_activity_logs' => route('admin.activity-logs.index'),
            '42_flow_diagrams' => route('admin.flow-diagrams.index'),
            '05_kyc_verification' => route('admin.kyc.index'),
            '09_exhibition_lifecycle' => route('admin.exhibition-lifecycle.index'),
            '19_booth_engineering_review' => route('admin.booth-engineering.index'),
            '23_event_logistics_review' => route('admin.event-logistics.index'),
            '24_visitor_checkin_analytics' => route('admin.visitor-checkins.index'),
            '25_lead_management' => route('admin.leads.index'),
            '26_meeting_management' => route('admin.meetings.index'),
            '29_refund_management' => route('admin.refunds.index'),
        ];

        if (isset($aliases[$page])) {
            return redirect($aliases[$page]);
        }

        $legacyView = 'backend.admin.legacy.' . $page;
        $view = view()->exists($legacyView) ? $legacyView : 'backend.admin.' . $page;
        abort_unless(view()->exists($view), 404);

        return view($view);
    }

    private function badge(?string $value): string
    {
        $value = $value ?: 'unknown';
        $tone = match ($value) {
            'approved', 'active', 'published', 'live', 'paid', 'confirmed', 'completed', 'available', 'open', 'replied' => 'green',
            'pending', 'submitted', 'pending_review', 'reserved', 'draft', 'new' => 'amber',
            'rejected', 'inactive', 'cancelled', 'failed', 'refunded', 'booked' => 'rose',
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

    private function money(float|int|string|null $value): string
    {
        return 'Rs. ' . number_format((float) $value, 2);
    }
}
