@extends('layouts.admin')

@section('title', 'Ticket Email Setup')
@section('page-title', 'Ticket Email Setup')

@section('content')
    <section class="space-y-6 px-5 py-6 sm:px-8">
        <div>
            <h2 class="text-[28px] font-bold text-[#0B132C]">Ticket Email Setup</h2>
            <p class="mt-2 text-[14px] text-gray-500">Save your Gmail App Password once — then send scanner/ticket emails without limits.</p>
        </div>

        @include('shared.mail-setup-form')
    </section>
@endsection
