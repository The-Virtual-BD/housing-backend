<?php

use App\Models\Admin;
use App\Models\Approver;
use App\Models\Executive;
use App\Models\Manager;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Str;

function isStaff(){
    return auth()->check() && auth()->user() instanceof Staff;
}

function isExecutive(){
    return auth()->check() && auth()->user() instanceof Executive;
}

function isAdmin(){
    return auth()->check() && auth()->user() instanceof Admin;
}

function isApprover(){
    return auth()->check() && (auth()->user() instanceof Approver);
}

function isManager(){
    return auth()->check() && auth()->user() instanceof Manager;
}

function isUser(){
    return auth()->check() && auth()->user() instanceof User;
}
