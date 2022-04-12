<?php

namespace App\Core\Config;

class DotEnv
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected $path;

    /**
     * Locate the .env file.
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }
        $this->path = $path;
    }

    /**
     * Load the .env file.
     */
    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        for ($i = 0; $i < 6; $i++) {
            if (strpos(trim($lines[$i]), '#') === 0) {
                continue;
            }

            list($key, $value) = explode('=', $lines[$i]);
            $key = trim($key);
            $value = trim($value);

            if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                putenv(sprintf('%s=%s', $key, $value));
                $_ENV[$key] = $value;
            }
        }
    }
}
