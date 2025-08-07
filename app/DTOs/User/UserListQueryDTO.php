<?php

namespace App\DTOs\User;

class UserListQueryDTO
{
    public function __construct(
        public readonly int $perPage = 10,
        public readonly int $page = 1
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            perPage: $data['per_page'] ?? 10,
            page: $data['page'] ?? 1
        );
    }
}