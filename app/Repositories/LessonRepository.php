<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository extends BaseRepository
{
    public function model()
    {
        return Lesson::class;
    }

    /**
     * check state attendance lesson
     * @param $scheduleId, $dateLearn
     * @return mixed
     */
    public function checkStateLesson($lessonId)
    {
        return $this->model
                    ->select('state')
                    ->where('id', $lessonId)
                    ->get();
    }
    
    /**
     * turn on attendance lesson
     * @param $lessonId, $radius, $latitude, $longitude
     * @return mixed
     */
    public function turnOnAttendance($lessonId, $radius, $latitude, $longitude)
    {
        return $this->model
                    ->where('id', $lessonId)
                    ->update(
                        [
                            'radius'   => $radius,
                            'latitude' => $latitude,
                            'longitude' => $longitude,
                            'state'    => 1
                        ]
                    );
    }

    /**
     * turn off attendance lesson
     * @param $lessonId
     * @return mixed
     */
    public function turnOffAttendance($lessonId)
    {
        return $this->model
                    ->where('id', $lessonId)
                    ->update(['state'=> 0]);
    }

}