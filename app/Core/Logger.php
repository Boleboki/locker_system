<?php

namespace App\Core;

class Logger
{
    protected static string $logDir = __DIR__ . '/../../storage/logs';

    protected static function write(string $level, string $message): void
    {
        if (!file_exists(self::$logDir)) {
            mkdir(self::$logDir, 0777, true);
        }

        // Pre nego što pišemo log, obriši stare logove
        self::deleteOldLogs();

        $timestamp = date("Y-m-d H:i:s");
        $filename = self::$logDir . '/' . date("Y-m-d") . '.log';
        $entry = "[$timestamp] [$level] $message" . PHP_EOL;

        file_put_contents($filename, $entry, FILE_APPEND);
    }

    protected static function deleteOldLogs(): void
    {
        $files = glob(self::$logDir . '/*.log');
        $now = time();

        foreach ($files as $file) {
            // Dobijamo vreme poslednje izmene fajla
            $filemtime = filemtime($file);

            // Ako je fajl stariji od LOG_RETENTION_DAYS dana, brišemo ga
            if ($filemtime !== false && ($now - $filemtime) > LOG_RETENTION_DAYS * 86400) {
                unlink($file);
            }
        }
    }

    public static function info(string $message): void
    {
        self::write('INFO', $message);
    }

    public static function error(string $message): void
    {
        self::write('ERROR', $message);
    }

    public static function warning(string $message): void
    {
        self::write('WARNING', $message);
    }

    public static function debug(string $message): void
    {
        self::write('DEBUG', $message);
    }
}
