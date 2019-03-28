<?php
namespace Splio\Serialize;

interface SplioSerializeInterface
{
    public function jsonSerialize();
    public static function jsonUnserialize(object $data);
}