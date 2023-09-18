<?php

namespace App\Enum;


enum ArticleStatus: string
{

    use EnumSerializer;

    case Pending = 'pending';
    case Published = 'published';
    case Unpublished = 'unpublished';
}
