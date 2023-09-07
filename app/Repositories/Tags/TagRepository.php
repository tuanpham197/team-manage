<?php

declare(strict_types=1);

namespace App\Repositories\Tags;

use App\Models\Tag;
use App\Repositories\AbstractEloquentRepository;

class TagRepository extends AbstractEloquentRepository implements TagInterface
{
    /**
     * Get model
     */
    public function getModel(): string
    {
        return Tag::class;
    }
}
