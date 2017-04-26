<?php
/**
 * Because Lumen has no config_path function, we need to add this function
 * to make JWT Auth works.
 */
if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     *
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath().'/config'.($path ? '/'.$path : $path);
    }
}

/**
 * Because Lumen has no storage_path function, we need to add this function
 * to make caching configuration works.
 */
if (!function_exists('storage_path')) {
    /**
     * Get the configuration path.
     *
     * @param string $path
     *
     * @return string
     */
    function storage_path($path = '')
    {
        return app()->basePath().'/storage'.($path ? '/'.$path : $path);
    }
}

if (!function_exists('get_user')) {
    /**
     * Get authenticated user.
     *
     * @return $user
     */
    function get_user()
    {
        return app('Dingo\Api\Auth\Auth')->user();
    }
}

if (! function_exists('get_offset')) {
    function get_offset($limit = 10)
    {
        $page = app('request')->input('page', 0);

        $offset = $page > 1 ? ($page - 1) * $limit : 0;

        return $offset;
    }
}

if (! function_exists('get_page_number')) {
    function get_page_number()
    {
        return app('request')->input('page', 0);
    }
}


if (! function_exists('get_post_data')) {
    function get_post_data()
    {
        return app('request')->json()->all();
    }
}

/** Faz a fusao de 2 arrays.
 * é mais um append, tipo, une dois arrays Ex:
 * [0 => "a", 1 => "b"] e [0 => "c"]
 * vai se tornar [0 => "a", 1 => "b", 2 => "c"]
 **/
if (! function_exists('merge_arrays')) {
    function merge_arrays(&$array_one, $array_two)
    {
        foreach ($array_two as $item) {
            array_push($array_one, $item);
        }
    }
}