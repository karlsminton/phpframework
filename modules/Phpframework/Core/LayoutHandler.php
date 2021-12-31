<?php

declare(strict_types=1);

namespace Phpframework\Core;

use UnexpectedValueException;

class LayoutHandler
{
    /**
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public function getCombinedLayoutByName(string $name): string
    {
        $layouts = $this->getLayoutsByName($name);
        $jsonHandler = new \Phpframework\Core\Handler\Json();

        $data = [];
        foreach ($layouts as $path => $layout) {
            $contents = file_get_contents($layout);
            try {
                $data[$path] = $jsonHandler->jsonToData($contents);
            } catch (\JsonException $e) {
                $msg = sprintf('Unable to decode layout at path %$1s', $path);
                throw new \Exception($msg);
            }
        }

        // todo implement layout merging functionality
        // this does nothing currently
        $merged = $this->mergeLayouts($data);
        $html = $this->recursiveLayoutRenderer($merged);

//        echo "<pre><code>";
//        var_dump($html);
//        echo "</code></pre>";
//        die();
        echo $html;
        die();
        return $html;
    }

    /**
     * @param string $name
     * @return array
     */
    public function getLayoutsByName(string $name): array
    {
        $paths = $this->getLayoutFilePaths();
        $filtered = array_filter($paths, function ($path) use ($name) {
            if (strpos($path, $name)) {
                return $path;
            }
            return false;
        });

        return $filtered;
    }

    /**
     * Gets paths to all json files in modules directory
     *
     * @return array
     */
    private function getLayoutFilePaths(): array
    {
        $paths = [];
        $modulesDir = PATHS['modules'];
        try {
            $directory = new \RecursiveDirectoryIterator($modulesDir);
            $iterator = new \RecursiveIteratorIterator($directory);
            foreach ($iterator as $iteration) {
                if (
                    $iteration->isDir()
                    || strpos($iteration->getRealPath(), 'json') === false
                ) {
                    continue;
                }
                $paths[$iteration->getRealPath()] = $iteration->getRealPath();
            }
        } catch (UnexpectedValueException $e) {
            return [];
        }
        return $paths;
    }

    /**
     * This is unfinished - we want to merge this data
     * currently just returning the first option
     *
     * @param array $layouts
     * @return array
     */
    private function mergeLayouts(array $layouts): array
    {
        $key = array_keys($layouts)[0];
        return $layouts[$key];
    }

    /**
     * @param array $data
     * @return string
     */
    private function recursiveLayoutRenderer(array $data): string
    {
        $html = "";
        foreach ($data as $name => $datum) {
            if (isset($datum['element']) && $datum['element'] === true) {
                $toElement = true;
            } else {
                $toElement = false;
            }

            if (
                isset($datum['children'])
                && is_array($datum['children'])
                && !empty($datum['children'])
            ) {
                $shouldRecurse = true;
            } else {
                $shouldRecurse = false;
            }

            if ($toElement) {
                $html .= "<$name>";
            }

            if (isset($datum['value'])) {
                $html .= $datum['value'];
            }

            if ($shouldRecurse) {
                foreach ($datum['children'] as $child) {
                    $html .= $this->recursiveLayoutRenderer($child);
                }
            }
            if ($toElement) {
                $html .= "</$name>";
            }
        }
        return $html;
    }
}