<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFoundException extends Exception
{
    public function render() {
        $explodedResourcePath = explode("\\", $this->getMessage());
        $resourceName = end($explodedResourcePath);

        return response()->json([
            'message' => "$resourceName not found",
            'error' => true
        ], 404);
    }
}
