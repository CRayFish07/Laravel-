<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $member = $request->session()->get('member', '');
        if($member == '') {
            $referer = $_SERVER['HTTP_REFERER'];
            return redirect('/login?return_url='.urlencode($referer));
        }

        return $next($request);
    }

}
