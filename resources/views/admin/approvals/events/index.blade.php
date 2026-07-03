@extends('layouts.admin')

@section('title', 'Event Approvals')
@section('page-title', 'Event Approvals')

@section('content')
    <section class="admin-page-section space-y-6 px-5 py-6 sm:px-8">
        <div>
            <h1 class="admin-page-title font-bold text-[#0B132C]">Event Approvals</h1>
            <p class="admin-page-description mt-2 text-gray-500">Review submitted company events and publish approved events live.</p>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="space-y-3 lg:hidden">
            @forelse ($publishRequests as $request)
                <article class="admin-mobile-card rounded-2xl border border-gray-100 p-4 shadow-sm">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400">Event</p>
                    <p class="mt-1 text-[15px] font-semibold text-[#0B132C]">{{ $request->companyEvent?->title ?? 'Event' }}</p>
                    <div class="mt-3 grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400">Company</p>
                            <p class="mt-1 text-[14px] text-gray-600">{{ $request->company?->company_name ?? 'Company' }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400">Tickets</p>
                            <p class="mt-1 text-[14px] text-gray-600">{{ $request->companyEvent?->ticketTypes?->count() ?? 0 }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-gray-400">Status</p>
                            <p class="mt-1 text-[14px] text-gray-600">{{ ucfirst(str_replace('_', ' ', $request->status)) }}</p>
                        </div>
                    </div>
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <a href="{{ route('admin.event-approvals.show', $request) }}" class="inline-flex h-10 w-full items-center justify-center rounded-xl bg-[#3723db] text-[13px] font-semibold text-white">
                            Review
                        </a>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-gray-100 bg-white px-4 py-8 text-center text-[14px] text-gray-500 shadow-sm">
                    No event approval requests yet.
                </div>
            @endforelse
        </div>

        <div class="hidden overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm lg:block">
            <div class="admin-table-scroll">
                <table class="divide-y divide-gray-100">
                    <thead class="bg-[#F8F9FC]">
                        <tr>
                            <th class="px-5 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Event</th>
                            <th class="px-5 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Company</th>
                            <th class="px-5 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Tickets</th>
                            <th class="px-5 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Status</th>
                            <th class="px-5 py-3 text-right text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($publishRequests as $request)
                            <tr class="hover:bg-gray-50/80">
                                <td class="px-5 py-4 text-[14px] font-semibold text-[#0B132C]">{{ $request->companyEvent?->title ?? 'Event' }}</td>
                                <td class="px-5 py-4 text-[14px] text-gray-600">{{ $request->company?->company_name ?? 'Company' }}</td>
                                <td class="px-5 py-4 text-[14px] text-gray-600">{{ $request->companyEvent?->ticketTypes?->count() ?? 0 }}</td>
                                <td class="px-5 py-4 text-[14px] text-gray-600">{{ ucfirst(str_replace('_', ' ', $request->status)) }}</td>
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.event-approvals.show', $request) }}" class="inline-flex h-9 items-center justify-center rounded-lg border border-[#E6E1FF] bg-[#F4F2FF] px-3 text-[12px] font-semibold text-[#3723db] hover:bg-[#ebe6ff]">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-[14px] text-gray-500">
                                    No event approval requests yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
