<?php
namespace App\Repositories;

use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class AttendanceRepository {
    /**
     * @var Attendance
     */

    protected Attendance $attendance;

    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    public function checkSchedule($userCode, $dateCurrent, $session)
    {
        $scheduleId = DB::select("SELECT s.id
                                    FROM schedules s
                                    JOIN users u ON s.user_id = u.id
                                    JOIN leaves l ON l.schedule_id = s.id
                                    WHERE u.code = ?
                                    AND DATEDIFF(?, s.date_start)%7 = 0
                                    AND s.session = ?
                                    AND NOT EXISTS (SELECT * FROM leaves
                                                    WHERE leaves.schedule_id = s.id
                                                    AND leaves.date_want = ?
                                                    )
                                    OR (? NOT IN (SELECT leaves.date_want
                                                            FROM leaves
                                                            WHERE leaves.schedule_id = s.id )
                                        AND l.date_change = ?)
                                    LIMIT 1",
                                    [ $userCode, $dateCurrent, $session, 
                                    $dateCurrent, $dateCurrent, $dateCurrent]
                                );
        return $scheduleId;                    
    }

    public function getInfoLesson($userCode, $scheduleId, $dateCurrent)
    {
        $info = DB::select(
                        "SELECT u.name 'teacher_name', c.name 'class_name', 
                        sj.name 'subject_name', r.name 'room_name', 
                        ( SELECT COUNT(*) FROM lessons l1
                            JOIN schedules s1 ON l1.schedule_id = s1.id
                            WHERE s1.id = ?
                            AND l1.date_learn IS NOT NULL
                        ) 'number_lesson', l.content
                        FROM lessons l 
                        JOIN schedules s ON l.schedule_id = s.id
                        JOIN users u ON s.user_id = u.id
                        JOIN classes c ON s.class_id = c.id
                        JOIN subjects sj ON s.subject_id = sj.id
                        JOIN rooms r ON s.room_id = r.id
                        WHERE u.code = ?
                        AND s.id = ?
                        AND l.date_learn = ?",
                        [$scheduleId, $userCode, 
                        $scheduleId, $dateCurrent]);
        return $info;
    }
}