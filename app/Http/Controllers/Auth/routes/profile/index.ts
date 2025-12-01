import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\AuthController::edit
 * @see app/Http/Controllers/AuthController.php:138
 * @route '/profile/edit'
 */
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/profile/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AuthController::edit
 * @see app/Http/Controllers/AuthController.php:138
 * @route '/profile/edit'
 */
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::edit
 * @see app/Http/Controllers/AuthController.php:138
 * @route '/profile/edit'
 */
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\AuthController::edit
 * @see app/Http/Controllers/AuthController.php:138
 * @route '/profile/edit'
 */
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AuthController::update
 * @see app/Http/Controllers/AuthController.php:114
 * @route '/profile'
 */
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/profile',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\AuthController::update
 * @see app/Http/Controllers/AuthController.php:114
 * @route '/profile'
 */
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::update
 * @see app/Http/Controllers/AuthController.php:114
 * @route '/profile'
 */
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\AuthController::deleteMethod
 * @see app/Http/Controllers/AuthController.php:146
 * @route '/profile'
 */
export const deleteMethod = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteMethod.url(options),
    method: 'delete',
})

deleteMethod.definition = {
    methods: ["delete"],
    url: '/profile',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\AuthController::deleteMethod
 * @see app/Http/Controllers/AuthController.php:146
 * @route '/profile'
 */
deleteMethod.url = (options?: RouteQueryOptions) => {
    return deleteMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AuthController::deleteMethod
 * @see app/Http/Controllers/AuthController.php:146
 * @route '/profile'
 */
deleteMethod.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteMethod.url(options),
    method: 'delete',
})
const profile = {
    edit: Object.assign(edit, edit),
update: Object.assign(update, update),
delete: Object.assign(deleteMethod, deleteMethod),
}

export default profile