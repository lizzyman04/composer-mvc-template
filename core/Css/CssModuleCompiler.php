<?php

namespace Core\Css;

class CssModuleCompiler
{
    public function compile(string $inputPath, string $outputPath): void
    {
        $css = file_get_contents($inputPath);
        $module = pathinfo($inputPath, PATHINFO_FILENAME);
        $compiled = $this->processCss($css, $module);

        file_put_contents($outputPath, $compiled);
        echo "✅ The {$module}.css stylesheet has been recompiled\n";
    }

    private function processCss(string $css, string $module): string
    {
        $preserved = [];

        $css = preg_replace_callback(
            '/(@(?:media|keyframes|supports)[^{]+\{(?:[^{}]++|(?R))*\})/i',
            function ($m) use (&$preserved) {
                $key = "__PRESERVED_" . count($preserved) . "__";
                $preserved[$key] = $m[0];
                return $key;
            },
            $css
        );

        $css = preg_replace_callback(
            '/\.css_([\w-]+)([^{]*)\{/i',
            function ($m) use ($module) {
                $component = $m[1];
                $rest = trim($m[2]);
                $space = $rest === '' || preg_match('/^[\.\[:]/', $rest) ? '' : ' ';
                return "[css=\"{$module}\"] [css=\"{$component}\"]{$space}{$rest} {";
            },
            $css
        );

        foreach ($preserved as $key => $block) {
            $block = preg_replace_callback(
                '/\.css_([\w-]+)([^{]*)\{/i',
                function ($m) use ($module) {
                    $component = $m[1];
                    $rest = trim($m[2]);
                    $space = $rest === '' || preg_match('/^[\.\[:]/', $rest) ? '' : ' ';
                    return "[css=\"{$module}\"] [css=\"{$component}\"]{$space}{$rest} {";
                },
                $block
            );
            $css = str_replace($key, $block, $css);
        }

        $css = preg_replace('!/\*.*?\*/!s', '', $css);
        $css = preg_replace('/\s*([{};:>,])\s*/', '$1', $css);
        $css = preg_replace('/\s+/', ' ', $css);

        return trim($css);
    }
}
