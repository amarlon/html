<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 */

class analytics_model extends CI_Model {

    /**
     *  ANALYTICS MODEL.
     *
     */

    public function get_num_lessons( $course_id ) {

        return $this->db
            ->where('course_id', $course_id)
            ->count_all_results('course_lessons');

    }

    public function get_num_course_students( $course_id ) {

        return $this->db
            ->where('course_id', $course_id)
            ->count_all_results('course_students');

    }

    public function get_num_course_lectures( $course_id ) {

        $num_lectures = 0;

        $query = $this->db
            ->from('course_lessons')
            ->where('course_id', $course_id)
            ->get();

        $lessons = $query->result_array();

        foreach( $lessons as $lesson ) {
            $query = $this->db
                ->from('lesson_lectures')
                ->where('lesson_id', $lesson['id'])
                ->get();

            $lectures = $query->result_array();
            $num_lectures += count($lectures);
        }

        return $num_lectures;

    }


}