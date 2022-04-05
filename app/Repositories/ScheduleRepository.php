<?php

namespace App\Repositories;

use App\Models\Schedule;
class ScheduleRepository extends BaseRepository
{

    public function model()
    {
        return Schedule::class;
    }
    
    /**
     * get subjects in semester current
     * @return mixed
     */
    public function getSubjectsInSemesterCurrent($classId, $semester)
    {
        return $this->model
            ->where('class_id', $classId)
            ->where('semester', $semester)
            ->with('subject')
            ->withCount('lessons')
            ->get();
    }
    
    /**
     * teacher, student check Schedule 
     * @param $field, $id, $date, $session
     * @return mixed
     */
    public function checkSchedule($field, $id, $date, $session, $year)
    {
        return $this->model
            ->select('id')
            ->where($field, $id)
            ->where('session', $session)
            ->whereYear('date_start', $year)
            ->whereRaw("DATEDIFF(?, date_start)%7 = 0", $date)
            ->orWhereHas('leaves', function($query) use ($date){
                $query->where('date_change', $date);
            })
            ->get();
    }

    /**
     * isLeave of student
     * @param $classId, $date
     * @return mixed
     */
    public function isLeave($classId, $date)
    {
        return $this->model
            ->where('class_id', $classId)
            ->whereHas('leaves', function($query) use ($date){
                $query->where('date_want', $date);
            })
            ->get();
    }
    
    /**
     * getSemesters function
     *
     * @param array $data
     * @return mixed
     */
    public function getSemesters(array $data)
    {
        return $this->model
            ->where('class_id', $data['classId'])
            ->where('date_start', '<=', $data['date'])
            ->with('subject')
            ->get();
    }

    public function yearLearn($userId)
    {
        return $this->model
        ->where('user_id', $userId)
        ->get();
    }
    
}
