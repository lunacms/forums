<?php

namespace Lunacms\Forums;

class Forums
{
	public static $mode = 'multi';

    public static function getMode()
    {
    	return config('forums.mode', static::$mode);
    }

    public static function runInSingleMode()
    {
    	static::setMode('single');

    	return static::$mode;
    }

    public static function runInMultiMode()
    {
        static::setMode('multi');

        return static::$mode;
    }

    public static function runningSingleMode()
    {
        return static::$mode === 'single';
    }

    public static function setMode($mode)
    {
    	static::$mode = $mode;
    }

    public static function resolveResourceClass($resource = null)
    {
        if ($resource instanceof \Illuminate\Http\Resources\MissingValue) {
            return value($resource);
        }

        $class = get_class($resource);

        $resourceClass = config('forums.resources.' . $class);

        if (!empty($resourceClass) && class_exists($resourceClass)) {
            return new $resourceClass($resource);
        }

        return value((new \Illuminate\Http\Resources\MissingValue));
    }
}
