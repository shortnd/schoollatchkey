<?php

use Carbon\Carbon;

function startOfWeek()
{
    return Carbon::now()->startOfWeek();
}

function endOfWeek()
{
    return Carbon::now()->endOfWeek();
}
