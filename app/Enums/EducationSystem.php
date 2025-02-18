<?php

namespace App\Enums;

enum EducationSystem: string
{
    case th = 'TH';
    case cd = 'CD';
    case cl = 'CL';

    public function toVN(): string
    {
        return match($this) {
            self::th => 'Trung Cấp',
            self::cd => 'Cao Đẳng',
            self::cl => 'Cao Đẳng Liên Thông',
        };
    }

    public function toEN(): string
    {
        return match($this) {
            self::th => 'Intermediate Level',
            self::cd => 'College',
            self::cl => 'College Transfer',
        };
    }
}
