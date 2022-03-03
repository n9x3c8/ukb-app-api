<?php

use App\Http\Controllers\Student\LeaveController as StudentLeaveController;
use App\Http\Controllers\Student\ScoreController as StudentScoreController;
use App\Http\Controllers\UserController;
use App\Models\AcademicDepartment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\ScheduleController as TeacherScheduleController;
use App\Http\Controllers\Teacher\LessonController as TeacherLessonController;
use App\Http\Controllers\Student\ScheduleController as StudentScheduleController;
use App\Http\Controllers\Student\attendanceController as StudentAttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:student'])->group(function() {
    Route::get('user', function() {
        $user = AcademicDepartment::find(1)->classes()->get();
        // $user = User::whereHasMorph('userable', [Department::class])->get();
        // $user = Department::first();
        dd($user);
    });

    Route::get('scores/{schedule_id}', [StudentScoreController::class, 'showScores']);

    Route::group(['prefix'=>'leave'],function(){
        Route::post('/subjects_current', [StudentLeaveController::class, 'getSubjectsInSemesterCurrent']);
        
        Route::post('/test', function() {
            return 'ok';
        });

        Route::post('/create', [StudentLeaveController::class, 'create']);
    });

    Route::group(['prefix'=>'attendance'],function() {
        Route::get('info-lesson', [StudentScheduleController::class, 'getInfoLessonOfStudent']);
        Route::post('attendance', [StudentAttendanceController::class, 'attendance']);
    });

});

Route::middleware(['auth:sanctum', 'role:teacher'])->group(function() {
    //route teacher
    Route::group(['prefix'=>'attendance'],function() {
        Route::get('get-info-lesson', [TeacherScheduleController::class, 'getInfoLesson']);
        Route::get('check-state-lesson', [TeacherLessonController::class, 'checkStateLesson']);
        Route::post('turn-on-attendance', [TeacherLessonController::class, 'turnOnAttendance']);
        Route::get('turn-off-attendance', [TeacherLessonController::class, 'turnOffAttendance']);
    });
    
});

Route::middleware(['auth:sanctum', 'role:homeroom_teacher'])->group(function() {
    //route homeroom_teacher
});








