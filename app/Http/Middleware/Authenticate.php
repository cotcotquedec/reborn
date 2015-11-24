<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Models\Acl;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // If no authentifiication
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }

            // is no access
        } elseif(!$this->auth->user()->isActive()) {
            return redirect()->route('no-access');
        } else {

            /**@var \Models\Db\User\User $user  */
            $user = $this->auth->user();

            if($user->isContributor()) {
                ruler()->addPermission(Acl::PERMISSION_CONTRIBUTOR);
            }

            if ($user->isAdmin()) {
                ruler()->addPermission(Acl::PERMISSION_ADMIN);
            }
        }



        return $next($request);
    }
}
