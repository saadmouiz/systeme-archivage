<?php

namespace App\Http\Middleware;

use App\Support\CdcSchemaEnsurer;
use Closure;
use Illuminate\Http\Request;

class EnsureCdcSchema
{
    public function handle(Request $request, Closure $next)
    {
        CdcSchemaEnsurer::ensure();

        return $next($request);
    }
}
