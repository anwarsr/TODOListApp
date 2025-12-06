import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
 * @route '/auth/google/restricted'
 */
export const restricted = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: restricted.url(options),
    method: 'get',
})

restricted.definition = {
    methods: ["get","head"],
    url: '/auth/google/restricted',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
 * @route '/auth/google/restricted'
 */
restricted.url = (options?: RouteQueryOptions) => {
    return restricted.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
 * @route '/auth/google/restricted'
 */
restricted.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: restricted.url(options),
    method: 'get',
})
/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
 * @route '/auth/google/restricted'
 */
restricted.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: restricted.url(options),
    method: 'head',
})
const google = {
    restricted: Object.assign(restricted, restricted),
}

export default google