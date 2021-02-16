<?php

/**
 * MIT License
 *
 * Copyright (c) 2021 Wolf Utz<wpu@hotmail.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace OmegaCode\FWord\Utility;

class ConsoleUtility
{
    public static function write(string $line): void
    {
        echo "$line";
    }

    public static function writeLine(string $line): void
    {
        echo self::write($line) . PHP_EOL;
    }

    public static function writeError(string $line): void
    {
        echo "\033[31m$line\033[0m";
    }

    public static function writeErrorLine(string $line): void
    {
        echo "\033[31m$line\033[0m" . PHP_EOL;
    }

    public static function writeSuccess(string $line): void
    {
        echo "\033[32m$line\033[0m";
    }

    public static function writeSuccessLine(string $line): void
    {
        echo "\033[32m$line\033[0m" . PHP_EOL;
    }
}
