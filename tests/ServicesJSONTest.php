<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use XoopsModules\Xcontent\ServicesJSON;

final class ServicesJSONTest extends TestCase
{
    public function testEncodeUnsafeWithAssociativeArray(): void
    {
        $json = new ServicesJSON();
        $payload = ['foo' => 'bar', 'baz' => 123, 'nested' => ['value' => true]];

        $encoded = $json->encodeUnsafe($payload);

        self::assertSame(json_encode($payload), $encoded);
    }

    public function testDecodeReturnsLooseTypeArray(): void
    {
        $json = new ServicesJSON(SERVICES_JSON_LOOSE_TYPE);
        $source = json_encode(['count' => 5, 'label' => 'items']);

        $decoded = $json->decode($source);

        self::assertIsArray($decoded);
        self::assertSame(5, $decoded['count']);
        self::assertSame('items', $decoded['label']);
    }

    public function testReduceStringStripsComments(): void
    {
        $json = new ServicesJSON();
        $input = "// comment\n" . '{"foo": "bar"}/* trailing */';

        $reduced = $json->reduce_string($input);

        self::assertSame('{"foo": "bar"}', $reduced);
    }
}
