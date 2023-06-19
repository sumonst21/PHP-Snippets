<?php
/**
 * function to get modified files since initial commit
 * @param string $path
 * @return array
 */
function getModifiedFilesSinceInitialCommit($path)
{
    $output = runCommand('git log --pretty=format:"%H" --reverse | head -n 1', $path);
    $initialCommit = trim($output);
    $output = runCommand('git diff --name-only ' . $initialCommit . ' HEAD', $path);
    $files = explode("\n", $output);
    return $files;
}

/**
 * function to get modified files since last commit
 * @param string $path
 * @return array
 */
function getModifiedFilesSinceLastCommit($path)
{
    $output = runCommand('git diff --name-only HEAD~1 HEAD', $path);
    $files = explode("\n", $output);
    return $files;
}

/**
 * function to get modified files since last tag
 * @param string $path
 * @return array
 */
function getModifiedFilesSinceLastTag($path)
{
    $output = runCommand('git describe --tags --abbrev=0', $path);
    $lastTag = trim($output);
    $output = runCommand('git diff --name-only ' . $lastTag . ' HEAD', $path);
    $files = explode("\n", $output);
    return $files;
}

/**
 * function to get modified files since last release
 * @param string $path
 * @return array
 */
function getModifiedFilesSinceLastRelease($path)
{
    $output = runCommand('git describe --tags --abbrev=0', $path);
    $lastRelease = trim($output);
    $output = runCommand('git diff --name-only ' . $lastRelease . ' HEAD', $path);
    $files = explode("\n", $output);
    return $files;
}
