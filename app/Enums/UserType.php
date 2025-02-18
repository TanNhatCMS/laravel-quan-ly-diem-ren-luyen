<?php

namespace App\Enums;

enum UserType: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case OTHER = 'other';

    public function toVN(): string
    {
        return match ($this) {
            self::STUDENT => 'Sinh viên',
            self::TEACHER => 'Giáo viên',
            self::OTHER => 'Khác',
        };
    }

    public function toEN(): string
    {
        return match ($this) {
            self::STUDENT => 'Student',
            self::TEACHER => 'Teacher',
            self::OTHER => 'Other',
        };
    }
}
