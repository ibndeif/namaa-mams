<?php

namespace App\Enum;


enum ArticleStatus: string
{

    use EnumSerializer;

    case Draft = 'draft';
    case Published = 'published';
    case Unpublished = 'unpublished';
}
