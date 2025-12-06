import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:27
 * @route '/tasks'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/tasks',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:27
 * @route '/tasks'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:27
 * @route '/tasks'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\TaskController::index
 * @see app/Http/Controllers/TaskController.php:27
 * @route '/tasks'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TaskController::create
 * @see app/Http/Controllers/TaskController.php:130
 * @route '/tasks/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/tasks/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TaskController::create
 * @see app/Http/Controllers/TaskController.php:130
 * @route '/tasks/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\TaskController::create
 * @see app/Http/Controllers/TaskController.php:130
 * @route '/tasks/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\TaskController::create
 * @see app/Http/Controllers/TaskController.php:130
 * @route '/tasks/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TaskController::store
 * @see app/Http/Controllers/TaskController.php:141
 * @route '/tasks'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/tasks',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\TaskController::store
 * @see app/Http/Controllers/TaskController.php:141
 * @route '/tasks'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\TaskController::store
 * @see app/Http/Controllers/TaskController.php:141
 * @route '/tasks'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\TaskController::edit
 * @see app/Http/Controllers/TaskController.php:170
 * @route '/tasks/{task}/edit'
 */
export const edit = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/tasks/{task}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TaskController::edit
 * @see app/Http/Controllers/TaskController.php:170
 * @route '/tasks/{task}/edit'
 */
edit.url = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { task: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { task: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    task: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        task: typeof args.task === 'object'
                ? args.task.id
                : args.task,
                }

    return edit.definition.url
            .replace('{task}', parsedArgs.task.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TaskController::edit
 * @see app/Http/Controllers/TaskController.php:170
 * @route '/tasks/{task}/edit'
 */
edit.get = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\TaskController::edit
 * @see app/Http/Controllers/TaskController.php:170
 * @route '/tasks/{task}/edit'
 */
edit.head = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\TaskController::update
 * @see app/Http/Controllers/TaskController.php:187
 * @route '/tasks/{task}'
 */
export const update = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/tasks/{task}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\TaskController::update
 * @see app/Http/Controllers/TaskController.php:187
 * @route '/tasks/{task}'
 */
update.url = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { task: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { task: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    task: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        task: typeof args.task === 'object'
                ? args.task.id
                : args.task,
                }

    return update.definition.url
            .replace('{task}', parsedArgs.task.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TaskController::update
 * @see app/Http/Controllers/TaskController.php:187
 * @route '/tasks/{task}'
 */
update.put = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\TaskController::destroy
 * @see app/Http/Controllers/TaskController.php:219
 * @route '/tasks/{task}'
 */
export const destroy = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/tasks/{task}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\TaskController::destroy
 * @see app/Http/Controllers/TaskController.php:219
 * @route '/tasks/{task}'
 */
destroy.url = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { task: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { task: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    task: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        task: typeof args.task === 'object'
                ? args.task.id
                : args.task,
                }

    return destroy.definition.url
            .replace('{task}', parsedArgs.task.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TaskController::destroy
 * @see app/Http/Controllers/TaskController.php:219
 * @route '/tasks/{task}'
 */
destroy.delete = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\TaskController::toggleStatus
 * @see app/Http/Controllers/TaskController.php:237
 * @route '/tasks/{task}/toggle-status'
 */
export const toggleStatus = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: toggleStatus.url(args, options),
    method: 'patch',
})

toggleStatus.definition = {
    methods: ["patch"],
    url: '/tasks/{task}/toggle-status',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\TaskController::toggleStatus
 * @see app/Http/Controllers/TaskController.php:237
 * @route '/tasks/{task}/toggle-status'
 */
toggleStatus.url = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { task: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { task: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    task: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        task: typeof args.task === 'object'
                ? args.task.id
                : args.task,
                }

    return toggleStatus.definition.url
            .replace('{task}', parsedArgs.task.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TaskController::toggleStatus
 * @see app/Http/Controllers/TaskController.php:237
 * @route '/tasks/{task}/toggle-status'
 */
toggleStatus.patch = (args: { task: number | { id: number } } | [task: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: toggleStatus.url(args, options),
    method: 'patch',
})
const tasks = {
    index: Object.assign(index, index),
create: Object.assign(create, create),
store: Object.assign(store, store),
edit: Object.assign(edit, edit),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
toggleStatus: Object.assign(toggleStatus, toggleStatus),
}

export default tasks