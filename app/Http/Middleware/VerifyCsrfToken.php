<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	private $openRoutes = [];
	
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Disable CSRF control for xHttp Requests
		if($request->isXmlHttpRequest())	
		{
			return $next($request);
		}
		
		return parent::handle($request, $next);
	}

}
