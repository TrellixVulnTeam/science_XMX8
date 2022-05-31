<?php
namespace App\Model\Sciday;

use App\Database\DbSciDay;

class Teacher extends DbSciDay {
    public function InsertTeacher($teacher) {
        $sql = "
            INSERT INTO tb_teacher (
                id, 
                teacher_id, 
                ttitle, 
                tname, 
                tsurname, 
                project_id, 
                school
            ) VALUES (
                NULL, 
                :teacher_id, 
                :ttitle, 
                :tname, 
                :tsurname, 
                :project_id, 
                :school
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($teacher);
        return $this->pdo->lastInsertId();

    }
    public function getTeacherById($id) {
        $sql = "
        SELECT 
            t.name AS stitle,
            s.tname,
            s.tsurname,
            s.id 
        FROM 
            tb_teacher AS s 
            LEFT JOIN tb_title AS t ON s.ttitle = t.id
        WHERE 
            s.teacher_id = ?
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetchAll();
        return $data;
    }




}

?>