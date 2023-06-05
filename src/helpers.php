<?php

function std_out_write(string $data): void
{
    if (getenv('APP_ENV') === 'testing') {
        return;
    }

    fwrite(STDOUT, $data . PHP_EOL . PHP_EOL);
}

function std_err_write(string $data): void
{
    if (getenv('APP_ENV') === 'testing') {
        return;
    }

    fwrite(STDERR, $data . PHP_EOL . PHP_EOL);
}
