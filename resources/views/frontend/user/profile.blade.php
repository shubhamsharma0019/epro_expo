@extends('layouts.visitor-portal')

@section('title', 'eproexpo — Profile')
@section('shell-class', 'shell--passes')
@section('visitorNavActive', 'profile')

@section('page-styles')
<style>
.profile-grid{display:grid; gap:16px; grid-template-columns:minmax(0,1fr);}
@media(min-width:1000px){.profile-grid{grid-template-columns:300px minmax(0,1fr);}}
.profile-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:24px; box-shadow:var(--shadow); text-align:center;
}
.profile-card .avatar{
  width:88px; height:88px; border-radius:22px; margin:0 auto;
  background:var(--grad); color:#fff; font-size:32px; font-weight:800;
  display:flex; align-items:center; justify-content:center;
}
.profile-card h2{font-size:20px; font-weight:800; margin-top:16px;}
.profile-card .email{font-size:13px; color:var(--muted); margin-top:6px; word-break:break-all;}
.stat-pair{display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:20px;}
.stat-pair .box{
  background:var(--ivory); border-radius:12px; padding:14px;
}
.stat-pair .box span{display:block; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--muted);}
.stat-pair .box strong{display:block; margin-top:6px; font-size:22px; font-weight:800; color:var(--ink);}
.form-card{
  background:var(--card); border:1px solid var(--line); border-radius:var(--radius);
  padding:24px; box-shadow:var(--shadow);
}
.form-card .tag{
  display:inline-flex; padding:6px 12px; border-radius:999px;
  background:var(--grad-soft); color:var(--violet);
  font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:.06em;
}
.form-card h2{font-size:24px; font-weight:800; margin-top:14px;}
.form-card p{font-size:13px; color:var(--muted); margin-top:8px; line-height:1.6;}
.field-grid{display:grid; gap:14px; margin-top:22px;}
@media(min-width:700px){.field-grid{grid-template-columns:1fr 1fr;}}
.field label{display:block; font-size:13px; font-weight:700; color:var(--ink-soft); margin-bottom:6px;}
.field input{
  width:100%; height:46px; border-radius:11px; border:1px solid var(--line);
  background:var(--ivory); padding:0 14px; font-size:14px; font-weight:500;
}
.field input:focus{outline:none; border-color:var(--violet);}
.field input:disabled{background:#EEF0F6; color:var(--muted);}
.save-btn{
  margin-top:22px; height:46px; padding:0 22px; border:none; border-radius:11px;
  background:var(--grad); color:#fff; font-size:14px; font-weight:700; cursor:pointer;
  box-shadow:var(--shadow);
}
.alert-success{
  margin-bottom:16px; padding:12px 14px; border-radius:12px;
  background:#E9FAF1; border:1px solid #B8EFD4; color:#1D9E75;
  font-size:13px; font-weight:600;
}
</style>
@endsection

@section('portal-content')
<main class="main">
    <div class="welcome-banner">
        <div>
            <h1>Profile</h1>
            <p>Manage your visitor information for tickets and passes.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="profile-grid">
        <aside class="profile-card">
            <div class="avatar">{{ strtoupper(substr($user->name ?? 'V', 0, 1)) }}</div>
            <h2>{{ $user->name }}</h2>
            <p class="email">{{ $user->email }}</p>
            <div class="stat-pair">
                <div class="box">
                    <span>Event Tickets</span>
                    <strong>{{ $eventTicketCount }}</strong>
                </div>
                <div class="box">
                    <span>Exhibition Passes</span>
                    <strong>{{ $passCount }}</strong>
                </div>
            </div>
        </aside>

        <form method="POST" action="{{ route('frontend.user.profile.update') }}" class="form-card">
            @csrf
            <span class="tag">Profile Details</span>
            <h2>Manage visitor information</h2>
            <p>This information is used for tickets, e-passes, enquiries, and meeting requests.</p>
            <div class="field-grid">
                <div class="field">
                    <label for="name">Name</label>
                    <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" value="{{ $user->email }}" disabled>
                </div>
                <div class="field">
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                </div>
            </div>
            <button type="submit" class="save-btn">Save Profile</button>
        </form>
    </div>
</main>
@endsection
