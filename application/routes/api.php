<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Endpoints protegidos por JWT
Route::middleware('auth:api')->group(function () {
    Route::post('influencers', [InfluencerController::class, 'store']);
    Route::get('influencers', [InfluencerController::class, 'index']);
    Route::post('campaigns', [CampaignController::class, 'store']);
    Route::get('campaigns', [CampaignController::class, 'index']);
    Route::post('campaigns/{campaignId}/influencers', [CampaignController::class, 'addInfluencer']);
    Route::get('/users', [UserController::class, 'getUsers']);
});

