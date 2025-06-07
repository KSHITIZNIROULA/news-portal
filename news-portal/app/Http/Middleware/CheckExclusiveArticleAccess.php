<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckExclusiveArticleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
        $article = $request->route('article');

        if ($article->is_exclusive) {
            $user = auth()->user();
            if (!$user || (!$user->hasPermissionTo('view exclusive articles') && !$user->isSubscribedTo($article->author))) {
                abort(403, 'You need an active subscription to view this article.');
            }
        }

        return $next($request);
    }
}
