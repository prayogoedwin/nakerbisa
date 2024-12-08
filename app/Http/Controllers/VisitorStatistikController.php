<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorStatistikController extends Controller
{
    public function index()
    {
        $dailyVisitors = Visitor::whereDate('visited_at', now())->count();
        $monthlyVisitors = Visitor::whereMonth('visited_at', now()->month)->count();
        $yearlyVisitors = Visitor::whereYear('visited_at', now()->year)->count();

        return view('visitor-statistics', compact('dailyVisitors', 'monthlyVisitors', 'yearlyVisitors'));
    }
}

