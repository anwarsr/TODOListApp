import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

export const edit = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: edit.url(options),
    method: 'put',
})

edit.definition = {
    methods: ["put","patch"],
    url: '/settings/profile',
} satisfies RouteDefinition<["put","patch"]>

edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

edit.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: edit.url(options),
    method: 'put',
})

edit.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: edit.url(options),
    method: 'patch',
})

const editForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: edit.url(options),
    method: 'post',
})

editForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: edit.url(options),
    method: 'post',
})

editForm.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: edit.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

edit.form = editForm

export const destroy = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/settings/profile',
} satisfies RouteDefinition<["delete"]>

destroy.url = (options?: RouteQueryOptions) => {
    return destroy.definition.url + queryParams(options)
}

destroy.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(options),
    method: 'delete',
})

const destroyForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(options),
    method: 'post',
})

destroyForm.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const ProfileController = { edit, destroy }

export default ProfileController
