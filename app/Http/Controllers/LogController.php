<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $log = Log::all();
        return view('admin.log', compact('log'));
    }

    public function store($log_name, $status, $action, $id = null)
    {
        if($status == 'success')
        {
            $message = $log_name . ' ' . $id . " "  . "$action" . ' successfully';
        } else {
            $message = $log_name . ' ' . $id . " "  . "$action" . ' failed';
        }

        $logData = [
            'log_name' => $log_name,
            'message' => $message,
        ];

        Log::create($logData);
    }
}
