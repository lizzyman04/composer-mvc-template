<?php

namespace Core\Css;

class Watcher
{
    private string $inputDir;
    private string $outputDir;
    private int $interval;
    private array $lastModified = [];
    private CssModuleCompiler $compiler;
    private bool $isWatching = true;

    public function __construct(string $inputDir, string $outputDir, int $interval = 2000)
    {
        $this->inputDir = rtrim($inputDir, '/');
        $this->outputDir = rtrim($outputDir, '/');
        $this->interval = $interval;
        $this->compiler = new CssModuleCompiler();
    }

    public function start(): void
    {
        echo "👀 Watching CSS in '{$this->inputDir}' every {$this->interval}ms...\n";
        while ($this->isWatching) {
            $this->checkForChanges();
            usleep($this->interval * 1000);
        }
    }

    private function checkForChanges(): void
    {
        foreach (glob("{$this->inputDir}/*.css") as $file) {
            $filename = basename($file);
            $lastModified = filemtime($file);

            if (!isset($this->lastModified[$filename]) || $this->lastModified[$filename] < $lastModified) {
                $this->lastModified[$filename] = $lastModified;

                $outputPath = "{$this->outputDir}/{$filename}";
                $this->compiler->compile($file, $outputPath);
            }
        }
    }
}
