@extends('layouts.visitor-portal')

@section('title', 'eproexpo — Logout')
@section('shell-class', 'shell--passes shell--logout')

@php
    $firstName = explode(' ', $user->name ?? 'Visitor')[0];
    $initials = collect(explode(' ', $user->name ?? 'V'))->filter()->take(2)->map(fn ($w) => strtoupper(substr($w, 0, 1)))->implode('');
@endphp

@section('page-styles')
<style>
.shell--logout .portal-stack{display:flex;flex-direction:column;min-height:calc(100vh - 28px);}
.shell--logout .main--logout{
  display:flex;align-items:center;justify-content:center;
  flex:1;min-height:0;padding:20px 0;
}
.logout-card{
  background:var(--card);border:1px solid var(--line);
  border-radius:24px;padding:52px 48px;
  max-width:620px;width:100%;
  display:flex;flex-direction:column;align-items:center;
  box-shadow:0 20px 60px -20px rgba(40,20,90,.14);
  position:relative;overflow:hidden;
}
.logout-card::before{
  content:"";position:absolute;top:0;left:0;right:0;height:4px;
  background:var(--grad);
}
.avatar-ring{position:relative;width:88px;height:88px;margin-bottom:28px;}
.avatar-ring .ring{
  position:absolute;inset:-6px;border-radius:50%;
  background:var(--grad);opacity:.15;
  animation:ringPulse 2.5s ease-in-out infinite;
}
@keyframes ringPulse{
  0%,100%{transform:scale(1);opacity:.15;}
  50%{transform:scale(1.08);opacity:.07;}
}
.avatar-ring .inner{
  width:88px;height:88px;border-radius:50%;background:var(--grad);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:26px;font-weight:800;
  font-family:'Plus Jakarta Sans',sans-serif;
  position:relative;z-index:1;
}
.logout-card h2{
  font-size:20px;font-weight:800;color:var(--ink);
  text-align:center;margin-bottom:36px;
}
.btn-group{display:flex;gap:12px;width:100%;}
.btn-yes{
  flex:1;padding:15px;border-radius:13px;
  background:var(--grad);color:#fff;
  font-size:15px;font-weight:800;border:none;cursor:pointer;
  font-family:'Inter',sans-serif;
  box-shadow:0 8px 22px -8px rgba(79,45,200,.4);
  transition:opacity .15s,transform .12s;
}
.btn-yes:hover{opacity:.88;transform:translateY(-1px);}
.btn-yes:active{transform:translateY(0);}
.btn-no{
  flex:1;padding:15px;border-radius:13px;
  background:#fff;color:var(--ink-soft);
  font-size:15px;font-weight:800;
  border:1.5px solid var(--line);cursor:pointer;
  font-family:'Inter',sans-serif;transition:.15s;
  text-align:center;text-decoration:none;
  display:flex;align-items:center;justify-content:center;
}
.btn-no:hover{border-color:var(--indigo);color:var(--indigo);}
.logout-overlay{
  display:none;position:fixed;inset:0;z-index:9999;
  background:rgba(22,16,56,.72);backdrop-filter:blur(6px);
  align-items:center;justify-content:center;flex-direction:column;gap:20px;
}
.logout-overlay.show{display:flex;}
.logout-overlay .spinner{
  width:46px;height:46px;border-radius:50%;
  border:4px solid rgba(255,255,255,.15);border-top-color:#fff;
  animation:spin .7s linear infinite;
}
@keyframes spin{to{transform:rotate(360deg);}}
.logout-overlay p{color:#fff;font-size:14px;font-weight:700;opacity:.85;}
@media(max-width:600px){
  .logout-card{padding:36px 24px;}
  .btn-group{flex-direction:column;}
}
</style>
@endsection

@section('portal-content')
<main class="main main--logout">
    <div class="logout-card">
        <div class="avatar-ring">
            <div class="ring"></div>
            <div class="inner">{{ $initials }}</div>
        </div>

        <h2>Do you want to logout?</h2>

        <div class="btn-group">
            <button type="button" class="btn-yes" onclick="confirmLogout()">YES</button>
            <a href="{{ route('frontend.user.dashboard') }}" class="btn-no">NO</a>
        </div>
    </div>
</main>

<form id="logout-form" method="POST" action="{{ route('frontend.user.logout') }}" style="display:none;">
    @csrf
</form>

<div class="logout-overlay" id="logout-overlay">
    <div class="spinner"></div>
    <p>Signing you out securely…</p>
</div>
@endsection

@push('scripts')
<script>
function confirmLogout() {
    const overlay = document.getElementById('logout-overlay');
    const message = overlay.querySelector('p');
    const firstName = @js($firstName);

    overlay.classList.add('show');

    setTimeout(() => {
        message.textContent = 'See you next time, ' + firstName + ' 👋';
        setTimeout(() => {
            document.getElementById('logout-form').submit();
        }, 900);
    }, 1800);
}
</script>
@endpush
