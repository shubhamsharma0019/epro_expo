<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$path = $argv[1] ?? '/exhibitions/future-of-ai-expo';
$req = \Illuminate\Http\Request::create($path, 'GET');
$req->setLaravelSession($app['session']->driver());

try {
    $res = $kernel->handle($req);
    echo "path={$path} status=" . $res->getStatusCode() . PHP_EOL;
    if ($res->getStatusCode() >= 400) {
        $content = $res->getContent();
        if (preg_match('/class="exception-message[^"]*"[^>]*>([^<]+)/', $content, $m)) {
            echo 'message: ' . trim($m[1]) . PHP_EOL;
        }
        if (preg_match('/<!-- ([^:]+):(\d+) -->/', $content, $m)) {
            echo "at: {$m[1]}:{$m[2]}" . PHP_EOL;
        }
    }
} catch (\Throwable $e) {
    echo 'EX: ' . $e->getMessage() . PHP_EOL;
    echo $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

if (str_contains($path, '/my-meetings')) {
    try {
        $slug = explode('/', trim($path, '/'))[1] ?? '';
        $meetings = collect();
        view('frontend.exhibitions.visitor.meetings.index', [
            'slug' => $slug,
            'isPassActive' => false,
            'meetings' => $meetings,
        ])->render();
        echo "meetings_view=OK\n";
    } catch (\Throwable $e) {
        echo 'meetings_view_EX: ' . $e->getMessage() . PHP_EOL;
    }
    try {
        $controller = app(\App\Http\Controllers\Frontend\VisitorExhibitionController::class);
        $controller->meetings($slug ?? 'future-of-ai-expo');
        echo "controller_meetings=OK\n";
    } catch (\Throwable $e) {
        echo 'controller_EX: ' . $e->getMessage() . PHP_EOL;
        echo $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    }
}

// Also try rendering view directly when path matches exhibition show
if (str_contains($path, '/exhibitions/') && ! str_contains($path, '/my-meetings')) {
    try {
        $slug = basename($path);
        $exhibition = \App\Support\LiveContent::exhibitionQuery()->where('slug', $slug)->first();
        if ($exhibition) {
            $speakers = \App\Models\Speaker::where('exhibition_id', $exhibition->id)->get();
            $agenda = \App\Models\AgendaSession::where('exhibition_id', $exhibition->id)->get();
            $html = view('frontend.exhibitions.show', compact('slug', 'exhibition', 'speakers', 'agenda'))->render();
            echo "view_render=OK len=" . strlen($html) . PHP_EOL;
        }
    } catch (\Throwable $e) {
        echo 'view_EX: ' . $e->getMessage() . PHP_EOL;
        echo $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    }
}
