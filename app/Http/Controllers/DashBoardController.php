<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Phase;
use App\Models\User;
use Carbon\Carbon;

class DashBoardController extends Controller
{

   
    /**
     * Get DashBoard data.
     */
    public function index()
    {
        $user_tasks = User::with('tasks')->withCount('tasks')->get();
        $week_card = Task::whereBetween('completed_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $months_card = Task::whereMonth('completed_at', Carbon::now()->month)->count();
        $pending_card = Task::where('completed_at',null)->count();
        $dashboard_data = [
            'user' => $user_tasks,
            'week_count' => $week_card,
            'month_count' => $months_card,
            'pending_count' => $pending_card
        ]; 
       
        return $dashboard_data;
    }
}
