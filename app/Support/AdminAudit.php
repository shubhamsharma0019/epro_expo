<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Throwable;

class AdminAudit
{
    public static function log(
        string $action,
        ?string $module = null,
        ?string $subjectType = null,
        int|string|null $subjectId = null,
        array $changes = [],
        array $meta = []
    ): void {
        try {
            DB::table('admin_activity_logs')->insert([
                'admin_id' => session('admin_id'),
                'action' => $action,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId,
                'module' => $module,
                'changes' => empty($changes) ? null : json_encode($changes, JSON_UNESCAPED_UNICODE),
                'meta' => empty($meta) ? null : json_encode($meta, JSON_UNESCAPED_UNICODE),
                'ip_address' => request()->ip(),
                'user_agent' => substr((string) request()->userAgent(), 0, 255),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (Throwable) {
            // Keep admin flows working even if audit logging is temporarily unavailable.
        }
    }
}
