<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCollection;
use App\Models\Blog;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Blog API", version="0.1")
 * @OA\Server(url="/api/v1", description="V1")
 * @OAS\SecurityScheme(securityScheme="bearerAuth",type="http",scheme="bearer"
)
 */
class ApiController extends Controller
{

}
