@extends('layouts.company-event')

@section('title', 'Tickets / Pass Setup | eproexpo')

@section('content')
@php
    $attendeeFields = $companyEvent->ticket_attendee_fields ?: ['full_name', 'company', 'email', 'job_title', 'phone', 'country'];
    $allowGroupRegistrations = $companyEvent->allow_group_registrations ?? true;
    $showRemainingTicketCount = $companyEvent->show_remaining_ticket_count ?? true;
    $enableWaitingList = $companyEvent->enable_waiting_list ?? false;
@endphp
<div class="px-4 sm:px-6 md:px-10 py-8 max-w-[1250px] w-full flex flex-col">
            <!-- Add Ticket Button -->
            <div class="flex justify-end mb-6">
                <button id="add-ticket-btn" type="button" style="background-color: #4C10D0; color: #FFFFFF;" class="px-5 py-2.5 rounded-lg text-[13px] font-semibold flex items-center gap-2 hover:bg-[#3d0ba8] transition-colors shadow-sm focus:outline-none">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Add Ticket Type
                </button>
            </div>

            <!-- Table -->
            <div class="border border-gray-200 rounded-[16px] bg-white overflow-hidden mb-8 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="border-b border-gray-200 bg-white">
                                <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[25%]">Ticket Type</th>
                                <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[15%]">Price (INR)</th>
                                <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[15%]">Quantity</th>
                                <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[18%]">Sales Start</th>
                                <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[18%]">Sales End</th>
                                <th class="py-5 px-6 text-[13px] font-bold text-[#1C1364] w-[9%] text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tickets-tbody" class="text-[13px] text-[#1C1364] font-medium">
                            @forelse ($ticketTypes as $ticketType)
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors last:border-b-0">
                                    <td class="py-5 px-6 font-bold">{{ $ticketType->name }}</td>
                                    <td class="py-5 px-6 text-[#5B6B8A] font-medium">{{ ($ticketType->currency ?: 'INR') === 'INR' ? 'Rs.' : ($ticketType->currency ?: 'INR') }} {{ number_format((float) $ticketType->price, 2) }}</td>
                                    <td class="py-5 px-6 text-[#5B6B8A] font-medium">{{ $ticketType->quantity_total ?: 'Unlimited' }}</td>
                                    <td class="py-5 px-6 text-[#5B6B8A] font-medium">{{ optional($ticketType->sales_start_at)->format('M d, Y') ?: 'TBD' }}</td>
                                    <td class="py-5 px-6 text-[#5B6B8A] font-medium">{{ optional($ticketType->sales_end_at)->format('M d, Y') ?: 'TBD' }}</td>
                                    <td class="py-5 px-6">
                                        <div class="flex items-center justify-center gap-3">
                                            <button type="button" class="ticket-edit-btn text-[#4C10D0] hover:text-primary transition-colors"
                                                data-action="{{ route('company.event-company-flow.tickets.update', [$companyEvent, $ticketType]) }}"
                                                data-name="{{ $ticketType->name }}"
                                                data-price="{{ $ticketType->price }}"
                                                data-quantity="{{ $ticketType->quantity_total }}"
                                                data-sales-start="{{ optional($ticketType->sales_start_at)->format('Y-m-d\TH:i') }}"
                                                data-sales-end="{{ optional($ticketType->sales_end_at)->format('Y-m-d\TH:i') }}">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </button>
                                        <form method="POST" action="{{ route('company.event-company-flow.tickets.destroy', [$companyEvent, $ticketType]) }}" onsubmit="return confirm('Delete this ticket type?');" class="flex justify-center">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#EF4444] hover:text-red-600 transition-colors">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td colspan="6" class="py-8 px-6 text-center text-[#5B6B8A] font-medium">No ticket types added yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Settings Cards (Side by side) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-10">
                
                <!-- Attendee Information Fields -->
                <div class="border border-gray-200 rounded-[16px] p-8 bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <h3 class="text-[15px] font-bold text-[#1C1364] mb-6">Attendee Information Fields</h3>
                    <div class="grid grid-cols-2 gap-y-5 gap-x-4">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input form="ticket-settings-form" type="checkbox" name="ticket_attendee_fields[]" value="full_name" class="ticket-field-checkbox hidden" @checked(in_array('full_name', $attendeeFields, true))>
                            <div style="background-color: {{ in_array('full_name', $attendeeFields, true) ? '#4C10D0' : '#FFFFFF' }}; color: #FFFFFF;" class="ticket-field-box w-5 h-5 rounded {{ in_array('full_name', $attendeeFields, true) ? '' : 'border border-gray-300 bg-white group-hover:border-[#4C10D0]' }} text-white flex items-center justify-center shrink-0 transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Full Name</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input form="ticket-settings-form" type="checkbox" name="ticket_attendee_fields[]" value="company" class="ticket-field-checkbox hidden" @checked(in_array('company', $attendeeFields, true))>
                            <div style="background-color: {{ in_array('company', $attendeeFields, true) ? '#4C10D0' : '#FFFFFF' }}; color: #FFFFFF;" class="ticket-field-box w-5 h-5 rounded {{ in_array('company', $attendeeFields, true) ? '' : 'border border-gray-300 bg-white group-hover:border-[#4C10D0]' }} text-white flex items-center justify-center shrink-0 transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Company</span>
                        </label>
                        
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input form="ticket-settings-form" type="checkbox" name="ticket_attendee_fields[]" value="email" class="ticket-field-checkbox hidden" @checked(in_array('email', $attendeeFields, true))>
                            <div style="background-color: {{ in_array('email', $attendeeFields, true) ? '#4C10D0' : '#FFFFFF' }}; color: #FFFFFF;" class="ticket-field-box w-5 h-5 rounded {{ in_array('email', $attendeeFields, true) ? '' : 'border border-gray-300 bg-white group-hover:border-[#4C10D0]' }} text-white flex items-center justify-center shrink-0 transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Email Address</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input form="ticket-settings-form" type="checkbox" name="ticket_attendee_fields[]" value="job_title" class="ticket-field-checkbox hidden" @checked(in_array('job_title', $attendeeFields, true))>
                            <div style="background-color: {{ in_array('job_title', $attendeeFields, true) ? '#4C10D0' : '#FFFFFF' }}; color: #FFFFFF;" class="ticket-field-box w-5 h-5 rounded {{ in_array('job_title', $attendeeFields, true) ? '' : 'border border-gray-300 bg-white group-hover:border-[#4C10D0]' }} text-white flex items-center justify-center shrink-0 transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Job Title</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input form="ticket-settings-form" type="checkbox" name="ticket_attendee_fields[]" value="phone" class="ticket-field-checkbox hidden" @checked(in_array('phone', $attendeeFields, true))>
                            <div style="background-color: {{ in_array('phone', $attendeeFields, true) ? '#4C10D0' : '#FFFFFF' }}; color: #FFFFFF;" class="ticket-field-box w-5 h-5 rounded {{ in_array('phone', $attendeeFields, true) ? '' : 'border border-gray-300 bg-white group-hover:border-[#4C10D0]' }} text-white flex items-center justify-center shrink-0 transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium text-[#1C1364]">Phone Number</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input form="ticket-settings-form" type="checkbox" name="ticket_attendee_fields[]" value="country" class="ticket-field-checkbox hidden" @checked(in_array('country', $attendeeFields, true))>
                            <div style="background-color: {{ in_array('country', $attendeeFields, true) ? '#4C10D0' : '#FFFFFF' }}; color: #FFFFFF;" class="ticket-field-box w-5 h-5 rounded {{ in_array('country', $attendeeFields, true) ? '' : 'border border-gray-300 bg-white group-hover:border-[#4C10D0]' }} text-white flex items-center justify-center shrink-0 transition-colors">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <span class="text-[13px] font-medium {{ in_array('country', $attendeeFields, true) ? 'text-[#1C1364]' : 'text-[#5B6B8A]' }}">Country</span>
                        </label>
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="border border-gray-200 rounded-[16px] p-8 bg-white shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <h3 class="text-[15px] font-bold text-[#1C1364] mb-6">Additional Settings</h3>
                    <div class="flex flex-col gap-6">
                        <!-- Setting 1 -->
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-medium text-[#5B6B8A]">Allow group registrations</span>
                            <input form="ticket-settings-form" id="allow-group-registrations-input" type="hidden" name="allow_group_registrations" value="{{ $allowGroupRegistrations ? 1 : 0 }}">
                            <div id="toggle-group-reg" style="background-color: {{ $allowGroupRegistrations ? '#4C10D0' : '#E5E7EB' }};" class="relative w-10 h-5 {{ $allowGroupRegistrations ? 'bg-[#4C10D0]' : 'bg-gray-200' }} rounded-full cursor-pointer">
                                <div id="ball-group-reg" class="absolute {{ $allowGroupRegistrations ? 'right-[2px]' : 'left-[2px]' }} top-[2px] w-4 h-4 bg-white rounded-full transition-transform {{ $allowGroupRegistrations ? '' : 'border border-gray-100 shadow-sm' }}"></div>
                            </div>
                        </div>
                        <!-- Setting 2 -->
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-medium text-[#5B6B8A]">Show remaining ticket count</span>
                            <input form="ticket-settings-form" id="show-remaining-ticket-count-input" type="hidden" name="show_remaining_ticket_count" value="{{ $showRemainingTicketCount ? 1 : 0 }}">
                            <div id="toggle-remaining-count" style="background-color: {{ $showRemainingTicketCount ? '#4C10D0' : '#E5E7EB' }};" class="relative w-10 h-5 {{ $showRemainingTicketCount ? 'bg-[#4C10D0]' : 'bg-gray-200' }} rounded-full cursor-pointer">
                                <div id="ball-remaining-count" class="absolute {{ $showRemainingTicketCount ? 'right-[2px]' : 'left-[2px]' }} top-[2px] w-4 h-4 bg-white rounded-full transition-transform {{ $showRemainingTicketCount ? '' : 'border border-gray-100 shadow-sm' }}"></div>
                            </div>
                        </div>
                        <!-- Setting 3 -->
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-medium text-[#5B6B8A]">Waiting list</span>
                            <input form="ticket-settings-form" id="enable-waiting-list-input" type="hidden" name="enable_waiting_list" value="{{ $enableWaitingList ? 1 : 0 }}">
                            <div id="toggle-waiting-list" style="background-color: {{ $enableWaitingList ? '#4C10D0' : '#E5E7EB' }};" class="relative w-10 h-5 {{ $enableWaitingList ? 'bg-[#4C10D0]' : 'bg-gray-200' }} rounded-full cursor-pointer">
                                <div id="ball-waiting-list" class="absolute {{ $enableWaitingList ? 'right-[2px]' : 'left-[2px]' }} top-[2px] w-4 h-4 bg-white rounded-full transition-transform {{ $enableWaitingList ? '' : 'border border-gray-100 shadow-sm' }}"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Actions -->
            <div class="flex justify-end gap-3 mt-auto pt-4">
                <a href="{{ route('company.event-company-flow.branding', $companyEvent) }}" class="px-8 py-3 border border-gray-200 text-[#1C1364] bg-white rounded-lg text-[14px] font-semibold hover:bg-gray-50 transition-colors shadow-sm inline-block">Back</a>
                <button id="save-tickets-btn" form="ticket-settings-form" type="submit" style="background-color: #4C10D0; color: #FFFFFF;" class="px-8 py-3 rounded-lg text-[14px] font-semibold shadow-sm hover:bg-[#3d0ba8] transition-colors focus:outline-none">Save & Continue</button>
            </div>

        </div>

<form id="ticket-settings-form" method="POST" action="{{ route('company.event-company-flow.tickets.settings.update', $companyEvent) }}" class="hidden">
    @csrf
</form>

<div id="ticket-modal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center">
    <form id="ticket-type-form" method="POST" action="{{ route('company.event-company-flow.tickets.store', $companyEvent) }}" data-store-action="{{ route('company.event-company-flow.tickets.store', $companyEvent) }}" class="bg-white rounded-[20px] p-8 w-[92%] max-w-[450px] shadow-2xl flex flex-col gap-5 border border-gray-100">
        @csrf
        <input id="ticket-type-method" type="hidden" name="_method" value="POST" disabled>
        <input type="hidden" name="next" value="stay">
        <div>
            <h3 id="ticket-modal-title" class="text-[18px] font-bold text-[#1C1364] mb-1">Add Ticket Type</h3>
            <p class="text-[12px] text-[#6B7280]">Fill in the ticket parameters below.</p>
        </div>
        <div class="flex flex-col gap-4">
            <label class="flex flex-col gap-1.5 text-[12px] font-bold text-[#1C1364]">
                Ticket Type Name
                <input id="ticket-name-input" name="name" required class="w-full rounded-[8px] border border-gray-200 px-4 py-2.5 text-[13px] font-medium text-[#1C1364] focus:border-[#4C10D0] focus:outline-none" placeholder="e.g. Early Bird Pass">
            </label>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="flex flex-col gap-1.5 text-[12px] font-bold text-[#1C1364]">
                    Price (INR)
                    <input id="ticket-price-input" name="price" type="number" min="0" step="0.01" class="w-full rounded-[8px] border border-gray-200 px-4 py-2.5 text-[13px] font-medium text-[#1C1364] focus:border-[#4C10D0] focus:outline-none" placeholder="99.00">
                </label>
                <label class="flex flex-col gap-1.5 text-[12px] font-bold text-[#1C1364]">
                    Quantity
                    <input id="ticket-quantity-input" name="quantity_total" type="number" min="1" class="w-full rounded-[8px] border border-gray-200 px-4 py-2.5 text-[13px] font-medium text-[#1C1364] focus:border-[#4C10D0] focus:outline-none" placeholder="500">
                </label>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="flex flex-col gap-1.5 text-[12px] font-bold text-[#1C1364]">
                    Sales Start Date
                    <input id="ticket-sales-start-input" name="sales_start_at" type="datetime-local" class="w-full rounded-[8px] border border-gray-200 px-4 py-2.5 text-[13px] font-medium text-[#1C1364] focus:border-[#4C10D0] focus:outline-none">
                </label>
                <label class="flex flex-col gap-1.5 text-[12px] font-bold text-[#1C1364]">
                    Sales End Date
                    <input id="ticket-sales-end-input" name="sales_end_at" type="datetime-local" class="w-full rounded-[8px] border border-gray-200 px-4 py-2.5 text-[13px] font-medium text-[#1C1364] focus:border-[#4C10D0] focus:outline-none">
                </label>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <button type="button" id="modal-cancel-btn" class="rounded-[8px] border border-gray-200 px-5 py-2.5 text-[13px] font-semibold text-[#1C1364] hover:bg-gray-50">Cancel</button>
            <button type="submit" style="background-color: #4C10D0; color: #FFFFFF;" class="rounded-[8px] px-5 py-2.5 text-[13px] font-semibold hover:bg-[#3d0ba8]">Save Ticket</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const ticketModal = document.getElementById('ticket-modal');
    const ticketTypeForm = document.getElementById('ticket-type-form');
    const ticketTypeMethod = document.getElementById('ticket-type-method');
    const ticketModalTitle = document.getElementById('ticket-modal-title');
    const ticketNameInput = document.getElementById('ticket-name-input');
    const ticketPriceInput = document.getElementById('ticket-price-input');
    const ticketQuantityInput = document.getElementById('ticket-quantity-input');
    const ticketSalesStartInput = document.getElementById('ticket-sales-start-input');
    const ticketSalesEndInput = document.getElementById('ticket-sales-end-input');

    const openTicketModal = () => {
        ticketModal?.classList.remove('hidden');
        ticketModal?.classList.add('flex');
    };

    const closeTicketModal = () => {
        ticketModal?.classList.add('hidden');
        ticketModal?.classList.remove('flex');
    };

    const resetTicketForm = () => {
        if (! ticketTypeForm) return;

        ticketTypeForm.action = ticketTypeForm.dataset.storeAction;
        ticketTypeMethod.disabled = true;
        ticketTypeMethod.value = 'POST';
        ticketModalTitle.textContent = 'Add Ticket Type';
        ticketNameInput.value = '';
        ticketPriceInput.value = '';
        ticketQuantityInput.value = '';
        ticketSalesStartInput.value = '';
        ticketSalesEndInput.value = '';
    };

    document.getElementById('add-ticket-btn')?.addEventListener('click', () => {
        resetTicketForm();
        openTicketModal();
    });

    document.querySelectorAll('.ticket-edit-btn').forEach((button) => {
        button.addEventListener('click', () => {
            if (! ticketTypeForm) return;

            ticketTypeForm.action = button.dataset.action;
            ticketTypeMethod.disabled = false;
            ticketTypeMethod.value = 'PUT';
            ticketModalTitle.textContent = 'Edit Ticket Type';
            ticketNameInput.value = button.dataset.name || '';
            ticketPriceInput.value = button.dataset.price || '';
            ticketQuantityInput.value = button.dataset.quantity || '';
            ticketSalesStartInput.value = button.dataset.salesStart || '';
            ticketSalesEndInput.value = button.dataset.salesEnd || '';
            openTicketModal();
        });
    });

    document.getElementById('modal-cancel-btn')?.addEventListener('click', () => {
        closeTicketModal();
    });

    ticketModal?.addEventListener('click', (event) => {
        if (event.target === ticketModal) {
            closeTicketModal();
        }
    });

    const setToggleState = (toggleId, ballId, inputId, active) => {
        const toggle = document.getElementById(toggleId);
        const ball = document.getElementById(ballId);
        const input = document.getElementById(inputId);

        if (input) input.value = active ? '1' : '0';
        if (toggle) toggle.style.backgroundColor = active ? '#4C10D0' : '#E5E7EB';
        toggle?.classList.toggle('bg-[#4C10D0]', active);
        toggle?.classList.toggle('bg-gray-200', ! active);
        ball?.classList.toggle('right-[2px]', active);
        ball?.classList.toggle('left-[2px]', ! active);
        ball?.classList.toggle('border', ! active);
        ball?.classList.toggle('border-gray-100', ! active);
        ball?.classList.toggle('shadow-sm', ! active);
    };

    [
        ['toggle-group-reg', 'ball-group-reg', 'allow-group-registrations-input'],
        ['toggle-remaining-count', 'ball-remaining-count', 'show-remaining-ticket-count-input'],
        ['toggle-waiting-list', 'ball-waiting-list', 'enable-waiting-list-input'],
    ].forEach(([toggleId, ballId, inputId]) => {
        document.getElementById(toggleId)?.addEventListener('click', () => {
            const input = document.getElementById(inputId);
            setToggleState(toggleId, ballId, inputId, input?.value !== '1');
        });
    });

    document.querySelectorAll('.ticket-field-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            const box = checkbox.parentElement?.querySelector('.ticket-field-box');
            const label = checkbox.parentElement?.querySelector('span');

            if (box) {
                box.style.backgroundColor = checkbox.checked ? '#4C10D0' : '#FFFFFF';
                box.classList.toggle('border', ! checkbox.checked);
                box.classList.toggle('border-gray-300', ! checkbox.checked);
                box.classList.toggle('bg-white', ! checkbox.checked);
            }

            if (label && checkbox.value === 'country') {
                label.classList.toggle('text-[#1C1364]', checkbox.checked);
                label.classList.toggle('text-[#5B6B8A]', ! checkbox.checked);
            }
        });
    });

    // Prevent double submission of the ticket type form
    ticketTypeForm?.addEventListener('submit', () => {
        const submitBtn = ticketTypeForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = 'Saving...';
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';
        }
    });

    // Prevent double submission of settings form
    document.getElementById('ticket-settings-form')?.addEventListener('submit', () => {
        const submitBtn = document.getElementById('save-tickets-btn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = 'Saving...';
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';
        }
    });
</script>
@endpush
