<?php

use App\Console\Commands\CheckUnresolvedIssues;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CheckUnresolvedIssues::class)->everyMinute();