<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('cleanup:activity-logs')->daily();
Schedule::command('cleanup:orders')->daily();
Schedule::command('cleanup:kitchen-orders')->daily();
