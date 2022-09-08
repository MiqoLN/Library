<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    private function wrapException(HttpException $e) : array
    {
        $exception = array();
        $exception['status_code'] = $e->getStatusCode();
        $exception['message'] = $e->getMessage();
        return $exception;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $log = array();
        $log['ip'] = $request->ip();
        $log['uri'] = $request->path();
        $log['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $log['request'] = json_encode($request->all());
        if(isset($response->exception)) {
            $log['response'] = json_encode($this->wrapException($response->exception));
        }
        else
            $log['response'] = json_encode($response);

        Log::create([
           'ip' => $log['ip'],
           'uri' => $log['uri'],
           'user_agent' => $log['user_agent'],
           'request' => $log['request'],
           'response' => $log['response'],
        ]);

        return $response;
    }
}
