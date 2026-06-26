@extends('layouts.company')

@section('title', 'Team Members | eproexpo')
@section('page-title', 'Team Members')

@section('content')
@php
    $editingMember = $teamMember ?? null;
    $action = $editingMember
        ? route('company.booth-setup.team-members.update', [$booking, $editingMember])
        : route('company.booth-setup.team-members.store', $booking);
    $photoUrl = $editingMember?->photo ? asset('storage/' . $editingMember->photo) : asset('assets/exhibition/images/avatar.png');
    $tagsValue = old('expertise_tags', $editingMember ? collect($editingMember->expertise_tags ?? [])->implode(', ') : '');
@endphp

<section class="px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[1400px] rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:p-6 lg:p-8">
        <div class="mb-6 flex flex-col justify-between gap-4 md:flex-row md:items-start lg:mb-8">
            <div>
                <h1 class="mb-2 text-[22px] font-bold tracking-tight text-[#1E1B4B] sm:text-[28px]">Team Members</h1>
                <p class="text-[15px] text-[#6B7280]">Add your team members who will represent your company at the event.</p>
            </div>
            <a href="{{ route('company.booth-setup.team-members.create', $booking) }}" class="flex items-center justify-center rounded-lg bg-[#4C1D95] px-6 py-2.5 text-[14px] font-semibold text-white transition-colors hover:bg-[#3b1774]">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Team Member
            </a>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">{{ $errors->first() }}</div>
        @endif

        @if ($editingMember || request()->routeIs('company.booth-setup.team-members.create'))
            <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="mb-8 rounded-xl border border-gray-100 bg-[#FAFAFA] p-6">
                @csrf
                @if ($editingMember)
                    @method('PUT')
                @endif
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                    <div class="lg:col-span-3">
                        <label class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Profile Image</label>
                        <label class="flex h-[170px] cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-[#8B5CF6] bg-white p-4">
                            <img id="team-photo-preview" src="{{ $photoUrl }}" class="mb-3 h-20 w-20 rounded-full object-cover" alt="Team member preview">
                            <span class="text-center text-[13px] font-semibold text-[#3D1B9B]">Upload photo</span>
                            <input id="team-photo-input" type="file" name="photo" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:col-span-9">
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Name</span><input name="name" value="{{ old('name', $editingMember?->name) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Designation</span><input name="designation" value="{{ old('designation', $editingMember?->designation) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Email</span><input type="email" name="email" value="{{ old('email', $editingMember?->email) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Phone</span><input name="phone" value="{{ old('phone', $editingMember?->phone) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Start Date</span><input type="date" name="availability_start_date" value="{{ old('availability_start_date', optional($editingMember?->availability_start_date)->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">End Date</span><input type="date" name="availability_end_date" value="{{ old('availability_end_date', optional($editingMember?->availability_end_date)->format('Y-m-d')) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Start Time</span><input type="time" name="availability_start_time" value="{{ old('availability_start_time', $editingMember?->availability_start_time) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">End Time</span><input type="time" name="availability_end_time" value="{{ old('availability_end_time', $editingMember?->availability_end_time) }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label class="md:col-span-2"><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Expertise Tags</span><input name="expertise_tags" value="{{ $tagsValue }}" placeholder="Business Dev, Technical, Partnerships" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"></label>
                        <label><span class="mb-2 block text-[14px] font-bold text-[#1E1B4B]">Status</span><select name="status" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-[14px] outline-none focus:border-[#3D1B9B]"><option value="active" @selected(old('status', $editingMember?->status ?? 'active') === 'active')>Active</option><option value="inactive" @selected(old('status', $editingMember?->status) === 'inactive')>Inactive</option></select></label>
                    </div>
                </div>
                <div class="mt-5 flex justify-end gap-3">
                    <a href="{{ route('company.booth-setup.team-members.index', $booking) }}" class="rounded-lg border border-gray-200 px-6 py-2.5 text-[14px] font-semibold text-[#3D1B9B] hover:bg-purple-50">Cancel</a>
                    <button class="rounded-lg bg-[#3D1B9B] px-6 py-2.5 text-[14px] font-bold text-white hover:bg-[#31167D]">{{ $editingMember ? 'Update Team Member' : 'Save Team Member' }}</button>
                </div>
            </form>
        @endif

        <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white">
            <div class="lg:min-w-[1000px]">
                <div class="hidden grid-cols-12 items-center gap-4 border-b border-gray-100 p-6 lg:grid">
                    <div class="col-span-4 text-[14px] font-bold text-[#1E1B4B]">Member</div>
                    <div class="col-span-2 text-[14px] font-bold text-[#1E1B4B]">Role & Expertise</div>
                    <div class="col-span-3 text-[14px] font-bold text-[#1E1B4B]">Contact</div>
                    <div class="col-span-2 text-[14px] font-bold text-[#1E1B4B]">Availability</div>
                    <div class="col-span-1 text-center text-[14px] font-bold text-[#1E1B4B]">Actions</div>
                </div>
                @forelse ($teamMembers as $member)
                    <div class="flex flex-col gap-4 border-b border-gray-100 p-4 last:border-b-0 lg:grid lg:grid-cols-12 lg:items-center lg:gap-4 lg:p-6">
                        <div class="flex items-center pr-4 lg:col-span-4">
                            <div class="mr-4 h-12 w-12 flex-shrink-0 overflow-hidden rounded-full bg-gray-100"><img src="{{ $member->photo ? asset('storage/' . $member->photo) : asset('assets/exhibition/images/avatar.png') }}" alt="{{ $member->name }}" class="h-full w-full object-cover"></div>
                            <div><h4 class="mb-0.5 text-[14px] font-bold text-[#1E1B4B]">{{ $member->name }}</h4><p class="text-[13px] text-[#6B7280]">{{ $member->designation }}</p></div>
                        </div>
                        <div class="flex flex-wrap items-start gap-2 lg:col-span-2 lg:flex-col">
                            <span class="mr-1 text-[13px] font-semibold text-[#1E1B4B] lg:hidden">Expertise:</span>
                            @forelse (collect($member->expertise_tags ?? [])->take(2) as $tag)
                                <span class="inline-flex rounded-md bg-[#F5F3FF] px-3 py-1 text-[11px] font-bold text-[#6D28D9]">{{ $tag }}</span>
                            @empty
                                <span class="text-[13px] text-[#6B7280]">-</span>
                            @endforelse
                        </div>
                        <div class="pr-2 lg:col-span-3">
                            <span class="mr-1 text-[13px] font-semibold text-[#1E1B4B] lg:hidden">Contact:</span>
                            <p class="mb-1.5 text-[13px] text-[#4B5563]">{{ $member->email }}</p>
                            <p class="text-[13px] text-[#4B5563]">{{ $member->phone ?: '-' }}</p>
                        </div>
                        <div class="pr-2 lg:col-span-2">
                            <span class="mr-1 text-[13px] font-semibold text-[#1E1B4B] lg:hidden">Availability:</span>
                            <p class="mb-1.5 text-[13px] text-[#4B5563]">{{ optional($member->availability_start_date)->format('M d') }} - {{ optional($member->availability_end_date)->format('M d, Y') }}</p>
                            <p class="text-[13px] text-[#4B5563]">{{ $member->availability_start_time ?: '--' }} - {{ $member->availability_end_time ?: '--' }}</p>
                        </div>
                        <div class="flex gap-2 lg:col-span-1 lg:justify-center">
                            <a href="{{ route('company.booth-setup.team-members.edit', [$booking, $member]) }}" class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 text-[#6D28D9] hover:bg-gray-50"><i class="ph ph-pencil-simple"></i></a>
                            <form method="POST" action="{{ route('company.booth-setup.team-members.destroy', [$booking, $member]) }}" onsubmit="return confirm('Delete this team member?');">@csrf @method('DELETE')<button class="flex h-8 w-8 items-center justify-center rounded border border-gray-200 text-[#EF4444] hover:bg-red-50"><i class="ph ph-trash"></i></button></form>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-[14px] text-[#6B7280]">No team members added yet.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-10 flex justify-end border-t border-gray-100 pt-8">
            <a href="{{ route('company.booth-setup.meetings.edit', $booking) }}" class="inline-flex rounded-lg bg-[#3D1B9B] px-8 py-3 text-[15px] font-bold text-white shadow-md transition-colors hover:bg-[#31167D]">Save & Continue <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('team-photo-input')?.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        const preview = document.getElementById('team-photo-preview');
        if (file && preview) preview.src = URL.createObjectURL(file);
    });
</script>
@endpush

