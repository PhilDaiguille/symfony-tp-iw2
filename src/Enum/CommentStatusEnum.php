<?php

namespace App\Enum;

enum CommentStatusEnum: string
{
    case PENDING = 'pending';
    case VALIDATED = 'validated';
    case WAITING = 'waiting';
    case REJECTED = 'rejected';
}
