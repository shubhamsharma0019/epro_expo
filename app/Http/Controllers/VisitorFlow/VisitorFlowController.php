<?php

namespace App\Http\Controllers\VisitorFlow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class VisitorFlowController extends Controller
{
    /**
     * Serve visitor flow blade views dynamically for requested .html filenames.
     */
    public function servePage($page)
    {
        $pageName = str_replace('.html', '', $page);
        
        $viewPath = "frontend.visitor-flow.{$pageName}";

        if (View::exists($viewPath)) {
            return view($viewPath);
        }

        abort(404, "Page {$pageName} not found under visitor-flow.");
    }
}
