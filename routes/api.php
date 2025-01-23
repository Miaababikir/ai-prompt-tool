<?php

use App\Http\Controllers\Api\JobApplicationEmailGenerator;
use App\Http\Controllers\Api\VideoTitleGenerator;
use Illuminate\Support\Facades\Route;

Route::post("/prompts/video-title-generator", VideoTitleGenerator::class);
Route::post("/prompts/job-application-email-generator", JobApplicationEmailGenerator::class);
