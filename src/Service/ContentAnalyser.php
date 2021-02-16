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

namespace OmegaCode\FWord\Service;

use InvalidArgumentException;

class ContentAnalyser
{
    /**
     * @var array
     */
    private $targetStrings;

    public function __construct(array $targetStrings)
    {
        $this->targetStrings = $targetStrings;
    }

    public function analyse(string $filePath): array
    {
        $errors = [];
        $handle = fopen($filePath, 'r');
        if ($handle) {
            $lineNumber = 1;
            while (($line = fgets($handle)) !== false) {
                $validationResult = $this->validateLine($line);
                if ($validationResult['error']) {
                    $errors[] = $validationResult['message'] . ' in file ' . $filePath . ' on line ' . $lineNumber . '.' . PHP_EOL;
                }
                ++$lineNumber;
            }
            fclose($handle);

            return $errors;
        }
        throw new InvalidArgumentException("An error occurred while trying to read file \"$filePath\".");
    }

    private function validateLine(string $line): array
    {
        $result = ['error' => false];
        foreach ($this->targetStrings as $targetString) {
            if (strpos($line, $targetString) !== false) {
                $result['error'] = true;
                $result['message'] = "Found \"$targetString\"";
            }
        }

        return $result;
    }
}
