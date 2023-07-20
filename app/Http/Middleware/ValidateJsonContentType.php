<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateJsonContentType
{
    public function handle(Request $request, Closure $next)
    {
        $contentType = $request->header('Content-Type');

        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            if ($contentType !== 'application/json' && $contentType !== 'application/json;charset=UTF-8') {
                return response()->json(['error' => 'Invalid Content-Type. JSON expected.'], 415);
            }
        }

        return $next($request);
    }
}
