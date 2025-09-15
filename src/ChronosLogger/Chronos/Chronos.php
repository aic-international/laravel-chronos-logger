<?php

namespace App\Logging;

use Http;
use Illuminate\Http\Client\ConnectionException;
use Log;

class Chronos {
    public static function log($url = null, $token = null, $labels = null, $level = 'debug', $title = null, $content = null, $context = null, $channel = 'chronos', $created = null): void {
        $channel = "logging.channels.$channel";
        $token ??= config($channel . '.token');
        $url ??= config($channel . '.url');
        $labels ??= config($channel . '.labels');
        $data = [
            'token' => $token,
            'title' => $title,
            'content' => json_encode($content),
            'level' => $level,
            'labels' => $labels ?? null,
            'context' => $context ?? null,
            'created' => $created ?? now()->format('Y-m-d H:i:s'),
        ];

        try {
            Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($url . '/api/log', $data);
        } catch (ConnectionException $e) {
            Log::channel('single')->error($e->getMessage());
        }
    }

    public static function emergency(string $title, mixed $content = '', array $labels = [], $context = null, $channel = 'chronos'): void {
        self::log(null, null, $labels, 'emergency', $title, $content, $context, $channel);
    }

    public static function alert(string $title, mixed $content = '', array $labels = [], $context = null, $channel = 'chronos'): void {
        self::log(null, null, $labels, 'alert', $title, $content, $context, $channel);
    }

    public static function critical(string $title, mixed $content = '', array $labels = [], $context = null, $channel = 'chronos'): void {
        self::log(null, null, $labels, 'critical', $title, $content, $context, $channel);
    }

    public static function error(string $title, mixed $content = '', array $labels = [], $context = null, $channel = 'chronos'): void {
        self::log(null, null, $labels, 'error', $title, $content, $context, $channel);
    }

    public static function warning(string $title, mixed $content = '', array $labels = [], $context = null, $channel = 'chronos'): void {
        self::log(null, null, $labels, 'warning', $title, $content, $context, $channel);
    }

    public static function notice(string $title, mixed $content = '', array $labels = [], $context = null, $channel = 'chronos'): void {
        self::log(null, null, $labels, 'notice', $title, $content, $context, $channel);
    }

    public static function info(string $title, mixed $content = '', array $labels = [], $context = null, $channel = 'chronos'): void {
        self::log(null, null, $labels, 'info', $title, $content, $context, $channel);
    }

    public static function debug(string $title, mixed $content = '', array $labels = [], $context = null, $channel = 'chronos'): void {
        self::log(null, null, $labels, 'debug', $title, $content, $context, $channel);
    }
}
