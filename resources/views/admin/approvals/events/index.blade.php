@extends('layouts.admin')

@section('title', 'Event Approvals')
@section('page-title', 'Event Approvals')

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        <h1 class="text-[28px] font-bold text-[#0B132C]">Event Approvals</h1>
        <p class="mt-2 text-[14px] text-gray-500">Review submitted company events and publish approved events live.</p>

        @if (session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[760px] divide-y divide-gray-100">
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
                                    <a href="{{ route('admin.event-approvals.show', $request) }}" class="inline-flex h-9 items-center justify-center rounded-lg px-3 text-[12px] font-semibold text-[#3723db] hover:underline">
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

