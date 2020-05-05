<?php

namespace Modules\Product\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ModelRelationMissingException extends Exception
{
    public static function missingImagesRelation(string $modelName): self
    {
        return new static('Method images() not exists on ' . $modelName . ' class', Response::HTTP_NOT_FOUND);
    }
}
