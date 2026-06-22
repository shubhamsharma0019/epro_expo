@extends('layouts.frontend')

@section('title', 'Database Unavailable')

@section('content')
<section class="bg-[#FBFAFF] px-5 py-16 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[760px] rounded-[20px] border border-[#E7EAF3] bg-white p-8 text-center shadow-[0_14px_34px_rgba(7,16,68,0.07)] sm:p-10">
        <div class="mx-auto mb-6 grid h-16 w-16 place-items-center rounded-full bg-[#F4F0FF] text-[#5b2eff]">
            <i class="fa-solid fa-database text-[24px]"></i>
        </div>
        <h1 class="text-[28px] font-bold text-[#071044]">Database connection unavailable</h1>
        <p class="mt-4 text-[15px] font-medium leading-7 text-[#5A6480]">
            MySQL is not running on this machine, so live exhibition and event data cannot be loaded right now.
        </p>
        <div class="mt-6 rounded-xl border border-[#E7EAF3] bg-[#FBFAFF] p-5 text-left text-[14px] font-medium leading-7 text-[#34405F]">
            <p class="font-bold text-[#071044]">Start MySQL, then refresh:</p>
            <ol class="mt-3 list-decimal space-y-2 pl-5">
                <li>Right-click <code class="rounded bg-white px-2 py-0.5">scripts/start_mysql_admin.bat</code> and run as Administrator</li>
                <li>Or run <code class="rounded bg-white px-2 py-0.5">net start MySQL80</code> in an elevated terminal</li>
                <li>Then run <code class="rounded bg-white px-2 py-0.5">php artisan db:sync-project-data --migrate</code> if this is a fresh setup</li>
            </ol>
        </div>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ $retryUrl ?? url('/') }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[14px] font-bold text-white">Retry</a>
            <a href="{{ url('/') }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-[#E7EAF3] px-6 text-[14px] font-bold text-[#071044]">Go to Home</a>
        </div>
    </div>
</section>
@endsection
