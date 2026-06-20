<?php

namespace App\Domain\Admin\Services;

use App\Domain\Admin\Models\Admin;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothPublishRequest;
use App\Domain\Event\Models\CompanyEvent\CompanyEventPublishRequest;
use App\Domain\Company\Models\Enquiry;

class TopbarData
{
    public function data(): array
    {
        $admin = $this->currentAdmin();
        $name = $admin?->name ?: 'Admin User';
        $role = $admin?->role ?: 'Super Admin';

        return [
            'name' => $name,
            'role' => ucwords(str_replace('_', ' ', $role)),
            'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=3723db&color=fff',
            'notifications' => $admin ? $this->notificationCount() : 0,
            'messages' => $admin ? $this->messageCount() : 0,
            'search' => request('search', ''),
            'notifications_url' => route('admin.notifications.index'),
            'messages_url' => route('admin.enquiries.index'),
            'profile_url' => route('admin.settings.index'),
        ];
    }

    private function currentAdmin(): ?Admin
    {
        $adminId = session('admin_id');

        return $adminId ? Admin::query()->find($adminId) : null;
    }

    private function notificationCount(): int
    {
        return BoothBooking::query()
            ->where('payment_status', 'paid')
            ->where('admin_status', 'pending')
            ->count()
            + BoothPublishRequest::query()->where('status', 'pending')->count()
            + CompanyEventPublishRequest::query()->where('status', 'pending')->count();
    }

    private function messageCount(): int
    {
        return Enquiry::query()->whereIn('status', ['new', 'pending', 'open'])->count();
    }
}
