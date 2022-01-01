<?php

declare(strict_types=1);

namespace Phpframework\Core;

use Phpframework\Core\NodeInterface;

class NodeRenderer
{
    public const KEY_NODE = 'viewmodel';

    public const KEY_TEMPLATE = 'template';

    /**
     * @param array $data
     * @return string
     */
    public function renderNode(array $data): string
    {
        $html = '';
        try {
            $template = $this->getTemplate($data);
            $node = $this->getNode($data);
            ob_start();
            include $template;
        } catch (\Exception $e) {
            throw $e;
        }
        $html = ob_get_clean();
        return $html;
    }

    /**
     * @param array $data
     * @return \Phpframework\Core\NodeInterface
     */
    private function getNode(array $data): NodeInterface
    {
        if (isset($data[self::KEY_NODE])) {
            $viewmodel = $data[self::KEY_NODE];
            try {
                $node = new $viewmodel;
            } catch (\Exception $e) {
                die('Could not instantiate viewmodel.');
            }
        }
        return $node;
    }

    /**
     * @param array $data
     * @return string
     */
    private function getTemplate(array $data): string
    {
        if (isset($data[self::KEY_TEMPLATE])) {
            $name = $data[self::KEY_TEMPLATE];
            return PATHS['templates'] . '/' . $name;
        }
        die('Could not find template.');
    }
}