<?php

namespace App\Enums;

enum UserGender: string
{
    case OTHER = 'Khác';
    case MALE = 'Nam';
    case FEMALE = 'Nữ';

    public function toVN(): string
    {
        return match ($this) {
            self::MALE => 'Nam',
            self::FEMALE => 'Nữ',
            self::OTHER => 'Khác',
        };
    }

    public function toEN(): string
    {
        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
            self::OTHER => 'Other',
        };
    }
}
