@extends('layouts.admin')

@section('title', 'Booth Approvals')
@section('page-title', 'Booth Approvals')

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        <h1 class="text-[28px] font-bold text-[#0B132C]">Booth Approvals</h1>

        @if (session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[600px] divide-y divide-gray-100">
                    <thead class="bg-[#F8F9FC]">
                        <tr>
                            <th class="px-5 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Company</th>
                            <th class="px-5 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Booth</th>
                            <th class="px-5 py-3 text-left text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Status</th>
                            <th class="px-5 py-3 text-right text-[12px] font-semibold uppercase tracking-[0.12em] text-gray-500 whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($publishRequests as $request)
                            <tr class="hover:bg-gray-50/80">
                                <td class="px-5 py-4 text-[14px] font-semibold text-[#0B132C]">{{ $request->boothBooking->company->company_name ?? 'Company' }}</td>
                                <td class="px-5 py-4 text-[14px] text-gray-600">{{ $request->boothBooking->booth->booth_number ?? 'Booth' }}</td>
                                <td class="px-5 py-4 text-[14px] text-gray-600">{{ ucfirst($request->status) }}</td>
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.booth-approvals.show', $request) }}" class="inline-flex h-9 items-center justify-center rounded-lg px-3 text-[12px] font-semibold text-[#3723db] hover:underline">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-[14px] text-gray-500">
                                    No booth approval requests yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

