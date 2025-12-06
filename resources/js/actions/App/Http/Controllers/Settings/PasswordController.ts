import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

export const edit = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: edit.url(options),
    method: 'put',
})

edit.definition = {
    methods: ["put","patch"],
    url: '/settings/password',
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

const PasswordController = { edit }

export default PasswordController
