<?php

use App\Http\Controllers\Api\V1\AboutUsController;
use App\Http\Controllers\Api\V1\AcknowledgmentController;
use App\Http\Controllers\Api\V1\AssignmentObservationController;
use App\Http\Controllers\Api\V1\AssignmentPhotoController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CommandController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\DisclaimerController;
use App\Http\Controllers\Api\V1\ExecutiveSummaryController;
use App\Http\Controllers\Api\V1\ExecutiveSummaryPhotoController;
use App\Http\Controllers\Api\V1\MarineVasController;
use App\Http\Controllers\Api\V1\MarketingController;
use App\Http\Controllers\Api\V1\MlceAssignmentController;
use App\Http\Controllers\Api\V1\MlceIndentController;
use App\Http\Controllers\Api\V1\MlceRecommendationController;
use App\Http\Controllers\Api\V1\MlceReportController;
use App\Http\Controllers\Api\V1\MlceScheduleController;
use App\Http\Controllers\Api\V1\MlceTypeController;
use App\Http\Controllers\Api\V1\NavigationReportManualController;
use App\Http\Controllers\Api\V1\PresentationController;
use App\Http\Controllers\Api\V1\PresentationViewController;
use App\Http\Controllers\Api\V1\ReportViewController;
use App\Http\Controllers\Api\V1\SopController;
use App\Http\Controllers\Api\V1\SopViewController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\VideoController;
use App\Http\Controllers\Api\V1\VideoViewController;
use App\Http\Controllers\Api\V1\WhyMlceController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    // open routes
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"])->name("login");
    Route::post("forgot-password", [AuthController::class, "forgotPassword"]);
    Route::post("reset-password", [AuthController::class, "resetPassword"]);

    // secure routes
    Route::middleware("auth:sanctum")->group(function () {
        Route::post("update-password", [AuthController::class, "updatePassword"]);
        Route::get("profile", [UserController::class, 'profile']);
        Route::post("logout", [AuthController::class, "logout"]);

        Route::apiResources([
            "users" => UserController::class,
            "acknowledgments" => AcknowledgmentController::class,
            "about-us" => AboutUsController::class,
            "marine-vas" => MarineVasController::class,
            "navigation-report-manuals" => NavigationReportManualController::class,
            "why-mlce" => WhyMlceController::class,
            "disclaimers" => DisclaimerController::class,
            "customers" => CustomerController::class,
            "mlce-types" => MlceTypeController::class,
            "mlce-indents" => MlceIndentController::class,
            "mlce-assignments" => MlceAssignmentController::class,
            "assignment-observations" => AssignmentObservationController::class,
            "mlce-recommendations" => MlceRecommendationController::class,
            "assignment-photos" => AssignmentPhotoController::class,
            "mlce-reports" => MlceReportController::class,
            "mlce-reports.views" => ReportViewController::class,
            "videos" => VideoController::class,
            "presentations" => PresentationController::class,
            "sops" => SopController::class,
            "marketings" => MarketingController::class,
            "mlce-schedules" => MlceScheduleController::class,
            "executive-summaries" => ExecutiveSummaryController::class,
            "mlce-indents.executive-summary-photos" => ExecutiveSummaryPhotoController::class,
        ], [
            // ⛔ do not delete or update this, else the updating will not work.
            'parameters' => [
                'about-us' => 'about_us',
                'marine-vas' => 'marine_vas',
            ]
        ]);

        Route::prefix("mlce-assignments/{mlce_assignment}")->group(function () {
            Route::controller(MlceAssignmentController::class)->group(function () {
                Route::patch("mobilise", "mobilise");
                Route::patch("start-survey", "startSurvey");
                Route::patch("complete-survey", "completeSurvey");
                Route::patch("demobilise", "demobilise");
                Route::patch("submit-recommendations", "submitRecommendations");
            });
        });

        Route::prefix("mlce-reports/{mlce_report}")->group(function () {
            Route::controller(MlceReportController::class)->group(function () {
                Route::patch("submit", "submit");
                Route::patch("approve", "approve");
            });

            Route::controller(ReportViewController::class)->group(function () {
                Route::get("view-stats", "stats");
                Route::get("report-wise-views", "reportWiseViews");
                Route::get("page-wise-views", "pageWiseViews");
            });
        });

        Route::patch("mlce-recommendations/{mlce_recommendation}/complete",
            [MlceRecommendationController::class, "complete"]);

        Route::prefix("videos/{video}/views")->controller(VideoViewController::class)
            ->group(function () {
                Route::post("", "store");
                Route::get("stats", "stats");
                Route::get("users/{user_id}", "getViewsByUser");
            });

        Route::prefix("presentations/{presentation}/views")->controller(PresentationViewController::class)
            ->group(function () {
                Route::post("", "store");
                Route::get("stats", "stats");
                Route::get("users/{user_id}", "getViewsByUser");
            });

        Route::prefix("sops/{sop}/views")->controller(SopViewController::class)
            ->group(function () {
                Route::post("", "store");
                Route::get("stats", "stats");
                Route::get("users/{user_id}", "getViewsByUser");
            });

        Route::get("dashboard", DashboardController::class);
    });

    // open route (only for backend use)
    Route::post("commands", CommandController::class);
});
