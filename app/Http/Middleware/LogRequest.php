<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequest
{
    private static $id;
    private static $elapsedTime;

    /**
     * handle
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        self::$id = rand();
        $requestInfo = $this->getRequestInfo($request);
        $path = $request->path();

        if (strncmp($path, 'static', 6) && strncmp($path, 'images', 6)) {
            \Log::info('request', $requestInfo);
        }

        $startTime = microtime(true);

        $response = $next($request);

        self::$elapsedTime = microtime(true) - $startTime;

        return $response;
    }

    /**
     * terminate
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Symfony\Component\HttpFoundation\Response $response
     *
     * @return void
     */
    public function terminate(Request $request, Response $response): void
    {
        \Log::info('response', [
            'id' => self::$id,
            'http-status' => $response->status(),
            'ellapsed-time' => self::$elapsedTime,
        ]);
    }

    /**
     * getRequestInfo
     * 
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    private function getRequestInfo($request): array
    {
        $info = [
            'id' => self::$id,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'path' => $request->path(),
            'ips' => implode(',', $request->ips()),
            'user-agent' => $request->header('User-Agent', ''),
        ];

        if (env('APP_DEBUG')) {
            $info['request-params'] = $request->all();
        }

        return $info;
    }
}
