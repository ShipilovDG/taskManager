<?php

namespace App\Http\Enums;

enum TaskStatuses: int
{
    case CREATED = 0;
    case  DONE = 1;
    case  CLOSED = 2;

    /**
     * @return TaskStatuses[]
     */
    public static function all(): array
    {
        return [
          self::DONE->value,
          self::CREATED->value,
          self::CLOSED->value,
        ];
    }
}
