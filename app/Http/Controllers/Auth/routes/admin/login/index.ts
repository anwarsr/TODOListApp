import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\AdminController::post
 * @see app/Http/Controllers/AdminController.php:35
 * @route '/admin/login'
 */
export const post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: post.url(options),
    method: 'post',
})

post.definition = {
    methods: ["post"],
    url: '/admin/login',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AdminController::post
 * @see app/Http/Controllers/AdminController.php:35
 * @route '/admin/login'
 */
post.url = (options?: RouteQueryOptions) => {
    return post.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AdminController::post
 * @see app/Http/Controllers/AdminController.php:35
 * @route '/admin/login'
 */
post.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: post.url(options),
    method: 'post',
})
const login = {
    post: Object.assign(post, post),
}

export default login