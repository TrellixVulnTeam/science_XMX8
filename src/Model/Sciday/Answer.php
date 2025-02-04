<?php
namespace App\Model\Sciday;

use App\Database\DbSciDay;

class Answer extends DbSciDay {
    public function InsertAnswer($answer) {
        $sql = "
            INSERT INTO tb_answer (
                id, 
                school, 
                level_id, 
                student_id, 
                teacher_id, 
                tel, 
                file_register,
                user_id
            ) VALUES (
                NULL, 
                :school, 
                :level_id, 
                :student_id, 
                :teacher_id, 
                :tel, 
                :file_register,
                :user_id
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($answer);
        return $this->pdo->lastInsertId();

    }
    public function getAnswerByUser($user) {
        $sql = "
            SELECT 
                a.id,
                a.school,
                a.level_id,
                a.student_id,
                a.teacher_id,
                a.tel,
                a.file_register,
                a.user_id,
                l.name as level
            FROM
                tb_answer AS a
                LEFT JOIN tb_level AS l ON a.level_id = l.id 
            WHERE
                a.user_id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user]);
        $data = $stmt->fetchAll();
        return $data;
    }
    public function getAnswerById($id) {
        $sql = "
            SELECT 
                a.id,
                a.school,
                a.level_id,
                a.student_id,
                a.teacher_id,
                a.tel,
                a.file_register,
                a.user_id,
                l.name as level
            FROM
                tb_answer AS a
                LEFT JOIN tb_level AS l ON a.level_id = l.id 
            WHERE
                a.id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetchAll();
        return $data[0];
    }
    public function UpdateAnswer($answer) {
        $sql = "
        UPDATE 
            tb_answer 
        SET 
            school=:school,
            level_id=:level_id,
            student_id=:student_id,
            teacher_id=:teacher_id,
            tel=:tel,
            file_register=:file_register
        WHERE 
            id=:answer_id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($answer);
        return true;
    }
    public function getAnswerByLevel($level) {
        $sql = "
            SELECT 
                a.id as answer_id,
                a.school,
                a.level_id,
                a.student_id,
                a.teacher_id,
                a.tel,
                a.file_register,
                a.user_id,
                l.name AS level
            FROM 
                tb_answer AS a 
                LEFT JOIN tb_level AS l ON a.level_id = l.id
            WHERE
                a.level_id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$level]);
        $data = $stmt->fetchAll();
        return $data;
    }
    public function delAnswerById($id) {
        $sql ="
            DELETE
            FROM
                tb_answer
            WHERE
                id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return true;
        
    }
    public function CertificateRound($round){
        $sql="
            SELECT
                p.id as project_id,
                t.name as stutitle,
                s.sname as stuname,
                s.ssurname as stusurname,
                p.school,
                ac.name as activity,
                l.name as level,
                p.tel,
                r.num as round	
            FROM 
                tb_round AS r
                LEFT JOIN tb_answer AS p ON r.project_id = p.id
                LEFT JOIN tb_level AS l ON r.level_id = l.id
                LEFT JOIN tb_student AS s ON s.student_id = p.student_id
                LEFT JOIN tb_title AS t ON t.id = s.stitle
                LEFT JOIN tb_activity AS ac ON ac.id = r.activity_id
            WHERE
                r.level_id = 7 AND
                r.num = ? AND
                r.activity_id = 4 
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$round]);
        $data = $stmt->fetchAll();
        return $data;
    }

}