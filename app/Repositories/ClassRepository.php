<?php

namespace App\Repositories;

use App\Models\Classroom;
use App\Models\Score;
use Illuminate\Http\Request;

class ClassRepository extends BaseRepository
{
    public function model()
    {
        return Classroom::class;
    }

    public function teacherGetClasses($scheduleId)
    {
        return $this->model
            ->whereHas('schedules', function($e) use ($scheduleId) {
                $e->where('id', $scheduleId);
            })
            ->get();
    }


}