<?php

declare(strict_types=1);

namespace Phpframework\Core;

use Phpframework\Core\Handler\Json;
use UnexpectedValueException;

class LayoutHandler
{
    /**
     * @var Json
     */
    private $jsonHandler;

    /**
     * @var NodeRenderer
     */
    private $nodeRenderer;

    /**
     * @param Json $jsonHandler
     * @param NodeRenderer $nodeRenderer
     */
    public function __construct(
        Json $jsonHandler,
        NodeRenderer $nodeRenderer
    ) {
        $this->jsonHandler = $jsonHandler;
        $this->nodeRenderer = $nodeRenderer;
    }
    /**
     * @param string $name
     * @return string
     * @throws \Exception
     */
    public function getCombinedLayoutByName(string $name): string
    {
        $layouts = $this->getLayoutsByName($name);

        $data = [];
        foreach ($layouts as $path => $layout) {
            $contents = file_get_contents($layout);
            try {
                $data[$path] = $this->jsonHandler->jsonToData($contents);
            } catch (\JsonException $e) {
                $msg = sprintf('Unable to decode layout at path %$1s', $path);
                throw new \Exception($msg);
            }
        }

        // todo implement layout merging functionality
        // this does nothing currently
        $merged = $this->mergeLayouts($data);
        $html = $this->recursiveLayoutRenderer($merged);
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
     * @throws \Exception
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

            if (!$toElement) {
                $html .= $this->nodeRenderer->renderNode($datum);
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