import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
 * @route '/auth/google/restricted'
 */
const Controller = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controller.url(options),
    method: 'get',
})

Controller.definition = {
    methods: ["get","head"],
    url: '/auth/google/restricted',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
 * @route '/auth/google/restricted'
 */
Controller.url = (options?: RouteQueryOptions) => {
    return Controller.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
 * @route '/auth/google/restricted'
 */
Controller.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Controller.url(options),
    method: 'get',
})
/**
* @see \Inertia\Controller::__invoke
 * @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
 * @route '/auth/google/restricted'
 */
Controller.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Controller.url(options),
    method: 'head',
})
export default Controller