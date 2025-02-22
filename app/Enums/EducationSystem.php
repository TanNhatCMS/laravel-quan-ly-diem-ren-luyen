<?php

namespace App\Enums;

enum EducationSystem: string
{
    case TH = 'TH';
    case CD = 'CD';
    case CL = 'CL';

    public function getReadableStatus()
    {
        return match ($this) {
            EducationSystem::TH => 'Trung Cấp',
            EducationSystem::CD => 'Cao Đẳng',
            EducationSystem::CL => 'Cao Đẳng Liên Thông',
        };
    }

    public function toVN(): string
    {
        return match ($this) {
            self::TH => 'Trung Cấp',
            self::CD => 'Cao Đẳng',
            self::CL => 'Cao Đẳng Liên Thông',
        };
    }

    public function toEN(): string
    {
        return match ($this) {
            self::TH => 'Intermediate Level',
            self::CD => 'College',
            self::CL => 'College Transfer',
        };
    }
}
