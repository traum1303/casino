<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('gambling', function () {
    return true;
});
