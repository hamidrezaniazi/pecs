<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Throwable;

trait UnitTestHelper
{
    private Logger $logger;

    protected function random(array $cases): mixed
    {
        return $cases[array_rand($cases)];
    }

    protected function setLogger(): void
    {
        $this->logger = new Logger(name: 'test', handlers: [new class () extends AbstractProcessingHandler {
            public array $messages = [];

            protected function write(array $record): void
            {
                $this->messages[] = $record['message'];
            }
        }]);
    }

    protected function getCliMessages(): array
    {
        $handler = $this->logger->getHandlers()[0];

        return $handler->messages ?? [];
    }

    protected function removeDirectoryRecursive(string $storingPath): void
    {
        try {
            $files = glob($storingPath . '/*');
            if ($files !== false) {
                foreach ($files as $file) {
                    if (is_dir($file)) {
                        $this->removeDirectoryRecursive($file);
                    } else {
                        unlink($file);
                    }
                }
            }

            rmdir($storingPath);

            $parentDir = dirname($storingPath);
            if ($parentDir !== '.') {
                $parentFiles = glob($parentDir . '/*');
                if ($parentFiles !== false && is_array($parentFiles) && count($parentFiles) === 0) {
                    rmdir($parentDir);
                }
            }
        } catch (Throwable) {
            // Do nothing
        }
    }
}
