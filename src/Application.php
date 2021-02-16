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

namespace OmegaCode\FWord;

use OmegaCode\FWord\Service\ArgumentParser;
use OmegaCode\FWord\Service\ContentAnalyser;
use OmegaCode\FWord\Service\FileFinder;
use OmegaCode\FWord\Utility\ConsoleUtility;

class Application
{
    public function run(string $rootPath, array $arguments): void
    {
        $argumentParser = new ArgumentParser($arguments, $rootPath);
        $targetStrings = $argumentParser->getTargetStrings();
        ConsoleUtility::writeLine('==============================================================================');
        ConsoleUtility::writeLine('Searching for f-words...');
        ConsoleUtility::writeLine('------------------------------------------------------------------------------');
        ConsoleUtility::writeLine('Looking for: ' . implode(', ', $targetStrings));
        ConsoleUtility::writeLine('In path: ' . $argumentParser->getTargetDirectoryPath());
        ConsoleUtility::writeLine('==============================================================================');

        // Scan file system
        $finder = new FileFinder();
        $files = $finder->getFiles($argumentParser->getTargetDirectoryPath());

        // Analyse files and collect errors.
        $analyser = new ContentAnalyser($targetStrings);
        $errors = [];
        foreach ($files as $absoluteFilePath) {
            $fileErrors = $analyser->analyse($absoluteFilePath);
            if (count($fileErrors) > 0) {
                $errors = array_merge($errors, $fileErrors);
            }
        }

        ConsoleUtility::writeLine('Checked ' . count($files) . ' files.');
        ConsoleUtility::writeLine('==============================================================================');

        // Print errors if given.
        if (count($errors) > 0) {
            ConsoleUtility::writeErrorLine('[Error] Found f-words!');
            foreach ($errors as $errorMessage) {
                echo $errorMessage;
            }
            exit(1);
        }
        ConsoleUtility::writeSuccessLine('[Success] Found no f-words!');

        exit(0);
    }
}
