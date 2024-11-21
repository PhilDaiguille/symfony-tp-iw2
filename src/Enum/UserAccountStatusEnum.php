<?php

namespace App\Enum;

enum UserAccountStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BLOCKED = 'blocked';
    case BANNED = 'banned';
}
