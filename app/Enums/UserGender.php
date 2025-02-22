<?php

namespace App\Enums;

enum UserGender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    public function getReadableStatus()
    {
        return match ($this) {
            UserGender::MALE => 'Nam',
            UserGender::FEMALE => 'Nữ',
            UserGender::OTHER => 'Khác',
        };
    }

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
