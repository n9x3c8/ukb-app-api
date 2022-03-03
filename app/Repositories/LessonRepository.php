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
                    ->where('id', $lessonId)
                    ->get();
    }

    /**
     * enableAttendance function
     * @param array $data
     * @return mixed
     */
    public function enableAttendance(array $data)
    {
        return $this->model
                    ->where('id', $data['lessonId'])
                    ->where('radius', '>=', $data['radius'])
                    ->where('latitude', '=', $data['latitude'])
                    ->where('longitude', '=', $data['longitude'])
                    ->get();
    }

    /**
     * turn on attendance lesson
     * @param array $data
     * @return mixed
     */
    public function turnOnAttendance(array $data)
    {
        return $this->model
                    ->where('id', $data['lessonId'])
                    ->update(
                        [
                            'radius'   => $data['radius'],
                            'latitude' => $data['latitude'],
                            'longitude' => $data['longitude'],
                            'state'    => 2
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
                    ->update(['state'=> 3]);
    }
}
