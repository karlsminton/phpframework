<?php

declare(strict_types=1);

namespace Phpframework\Core\Handler;

/**
 * Class used to standardise access of json data across app
 */
class Json
{
    /**
     * @param string $json
     * @return array
//     * @throws \JsonException
     */
    public function jsonToData(string $json): array
    {
//        return json_decode(
//            $json,
//            true,
//            512,
//            JSON_THROW_ON_ERROR
//        );
        return json_decode($json, true);
    }

    /**
     * @param array $data
     * @return string
     * @throws \JsonException
     */
    public function dataToJson(array $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}