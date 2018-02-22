<?php
namespace Fluffy\Assistance;

use Fluffy\Assistance\Contracts\Filesystem\FilesystemContract;
use Psr\Log\AbstractLogger;

/**
 * Class Logger
 *
 * @package Fluffy\Assistance
 */
class Logger extends AbstractLogger
{

    /**
     * @var \Fluffy\Assistance\Contracts\Filesystem\FilesystemContract
     */
    private $filesystem;

    /**
     * Logger constructor.
     *
     * @param \Fluffy\Assistance\Contracts\Filesystem\FilesystemContract $filesystem
     */
    public function __construct(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $level = strtoupper($level);
        $date  = date('Y-m-d H:i:s', time());

        #TODO Configurable log path
        $this->filesystem->append(
            __ROOT__."/Logs/{$level}.log",
            $this->processMessage(
                "[{$level} - {$date}] {$message}".PHP_EOL,
                $context
            )
        );
    }

    /**
     * Process Log Message.
     * It replaces $message variables with those from $context
     *
     * @param string $message
     * @param array  $context
     *
     * @return string
     * @throws \ArgumentCountError
     */
    private function processMessage(string $message, array $context): string
    {
        $replaceCount  = 0;
        $contextLenght = sizeof($context);

        foreach ($context as $key => $value) {
            $message = str_replace("{".$key."}", $value, $message, $count);
            if ($count) {
                $replaceCount++;
            }
        }

        if ($replaceCount !== $contextLenght) {
            throw new \ArgumentCountError(
                "You passed {$contextLenght} arguments, but found only "
                .($replaceCount)
            );
        }

        return $message;
    }
}
