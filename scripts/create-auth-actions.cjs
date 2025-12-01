const fs = require('fs');
const path = require('path');

// Create Auth controllers directory
const authDir = path.resolve(__dirname, '../resources/js/actions/App/Http/Controllers/Auth');
if (!fs.existsSync(authDir)) {
    fs.mkdirSync(authDir, { recursive: true });
}

// Auth controller files content
const controllers = {
    'AuthenticatedSessionController.ts': `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/login',
} satisfies RouteDefinition<["post"]>

store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

export const destroy = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: destroy.url(options),
    method: 'post',
})

destroy.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

destroy.url = (options?: RouteQueryOptions) => {
    return destroy.definition.url + queryParams(options)
}

destroy.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: destroy.url(options),
    method: 'post',
})

const destroyForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(options),
    method: 'post',
})

destroyForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(options),
    method: 'post',
})

destroy.form = destroyForm

const AuthenticatedSessionController = { create, store, destroy }

export default AuthenticatedSessionController
`,

    'EmailVerificationNotificationController.ts': `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/email/verification-notification',
} satisfies RouteDefinition<["post"]>

store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const EmailVerificationNotificationController = { store }

export default EmailVerificationNotificationController
`,

    'NewPasswordController.ts': `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

export const create = (options?: RouteQueryOptions & { token: string }): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/reset-password/:token',
} satisfies RouteDefinition<["get","head"]>

create.url = (options?: RouteQueryOptions & { token: string }) => {
    const url = create.definition.url.replace(':token', String(options?.token ?? ''))
    return url + queryParams(options)
}

create.get = (options?: RouteQueryOptions & { token: string }): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.head = (options?: RouteQueryOptions & { token: string }): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

const createForm = (options?: RouteQueryOptions & { token: string }): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

createForm.get = (options?: RouteQueryOptions & { token: string }): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

createForm.head = (options?: RouteQueryOptions & { token: string }): RouteFormDefinition<'get'> => ({
    action: create.url({
        ...(options || {}),
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    } as any),
    method: 'get',
})

create.form = createForm

export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/reset-password',
} satisfies RouteDefinition<["post"]>

store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const NewPasswordController = { create, store }

export default NewPasswordController
`,

    'PasswordResetLinkController.ts': `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/forgot-password',
} satisfies RouteDefinition<["get","head"]>

create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/forgot-password',
} satisfies RouteDefinition<["post"]>

store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const PasswordResetLinkController = { create, store }

export default PasswordResetLinkController
`,

    'RegisteredUserController.ts': `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/register',
} satisfies RouteDefinition<["post"]>

store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const RegisteredUserController = { create, store }

export default RegisteredUserController
`,

    'index.ts': `import AuthenticatedSessionController from './AuthenticatedSessionController'
import EmailVerificationNotificationController from './EmailVerificationNotificationController'
import NewPasswordController from './NewPasswordController'
import PasswordResetLinkController from './PasswordResetLinkController'
import RegisteredUserController from './RegisteredUserController'

const Auth = {
    AuthenticatedSessionController: Object.assign(AuthenticatedSessionController, AuthenticatedSessionController),
    EmailVerificationNotificationController: Object.assign(EmailVerificationNotificationController, EmailVerificationNotificationController),
    NewPasswordController: Object.assign(NewPasswordController, NewPasswordController),
    PasswordResetLinkController: Object.assign(PasswordResetLinkController, PasswordResetLinkController),
    RegisteredUserController: Object.assign(RegisteredUserController, RegisteredUserController),
}

export default Auth

export {
    AuthenticatedSessionController,
    EmailVerificationNotificationController,
    NewPasswordController,
    PasswordResetLinkController,
    RegisteredUserController,
}
`
};

// Write all Auth controller files
Object.entries(controllers).forEach(([filename, content]) => {
    const filePath = path.join(authDir, filename);
    fs.writeFileSync(filePath, content, 'utf-8');
});

console.log('✅ Auth controller actions created');

// Create appearance routes file
const routesDir = path.resolve(__dirname, '../resources/js/routes');
const appearanceContent = `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../wayfinder'

export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/settings/appearance',
} satisfies RouteDefinition<["get","head"]>

edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

const editForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(options),
    method: 'get',
})

editForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(options),
    method: 'get',
})

editForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

const appearance = { edit }

export default appearance
`;

fs.writeFileSync(path.join(routesDir, 'appearance.ts'), appearanceContent, 'utf-8');
console.log('✅ Appearance routes created');

// Create Settings controllers directory
const settingsDir = path.resolve(__dirname, '../resources/js/actions/App/Http/Controllers/Settings');
if (!fs.existsSync(settingsDir)) {
    fs.mkdirSync(settingsDir, { recursive: true });
}

// Settings controller files
const settingsControllers = {
    'PasswordController.ts': `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

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
`,
    'ProfileController.ts': `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../../../../../wayfinder'

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
`,
    'index.ts': `import PasswordController from './PasswordController'
import ProfileController from './ProfileController'

const Settings = {
    PasswordController: Object.assign(PasswordController, PasswordController),
    ProfileController: Object.assign(ProfileController, ProfileController),
}

export default Settings

export {
    PasswordController,
    ProfileController,
}
`
};

// Write all Settings controller files
Object.entries(settingsControllers).forEach(([filename, content]) => {
    const filePath = path.join(settingsDir, filename);
    fs.writeFileSync(filePath, content, 'utf-8');
});

console.log('✅ Settings controller actions created');

// Create verification routes file
const verificationRoutesContent = `import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from '../wayfinder'

export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/email/verification-notification',
} satisfies RouteDefinition<["post"]>

send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

const sendForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: send.url(options),
    method: 'post',
})

sendForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: send.url(options),
    method: 'post',
})

send.form = sendForm

const verification = { send }

export default verification
`;

fs.writeFileSync(path.join(routesDir, 'verification.ts'), verificationRoutesContent, 'utf-8');
console.log('✅ Verification routes created');

// Read existing index.ts to append home and dashboard
const indexPath = path.join(routesDir, 'index.ts');
let indexContent = fs.readFileSync(indexPath, 'utf-8');

// Add home and dashboard routes if not already present
if (!indexContent.includes('export const home')) {
    const homeRoute = `
/**
 * Home route - redirects to tasks
 * @route '/'
 */
export const home = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})

home.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

home.url = (options?: RouteQueryOptions) => {
    return home.definition.url + queryParams(options)
}

home.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})

home.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: home.url(options),
    method: 'head',
})
`;
    
    indexContent += homeRoute;
    console.log('✅ Home route added to index.ts');
}

if (!indexContent.includes('export const dashboard')) {
    const dashboardRoute = `
/**
 * Dashboard route - tasks page
 * @route '/tasks'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/tasks',
} satisfies RouteDefinition<["get","head"]>

dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})
`;
    
    indexContent += dashboardRoute;
    console.log('✅ Dashboard route added to index.ts');
}

fs.writeFileSync(indexPath, indexContent, 'utf-8');

// Add password.request route to password/index.ts
const passwordIndexPath = path.join(routesDir, 'password', 'index.ts');
if (fs.existsSync(passwordIndexPath)) {
    let passwordIndexContent = fs.readFileSync(passwordIndexPath, 'utf-8');
    
    if (!passwordIndexContent.includes('export const request')) {
        // Add request route before the default export
        const requestRoute = `
/**
 * Password reset request page
 * @route '/forgot-password'
 */
export const request = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: request.url(options),
    method: 'get',
})

request.definition = {
    methods: ["get","head"],
    url: '/forgot-password',
} satisfies RouteDefinition<["get","head"]>

request.url = (options?: RouteQueryOptions) => {
    return request.definition.url + queryParams(options)
}

request.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: request.url(options),
    method: 'get',
})

request.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: request.url(options),
    method: 'head',
})

`;
        
        // Insert before "const password = {"
        passwordIndexContent = passwordIndexContent.replace(
            'const password = {',
            requestRoute + 'const password = {'
        );
        
        // Add to password object
        passwordIndexContent = passwordIndexContent.replace(
            'const password = {',
            'const password = {\n    request: Object.assign(request, request),'
        );
        
        fs.writeFileSync(passwordIndexPath, passwordIndexContent, 'utf-8');
        console.log('✅ Password request route added');
    }
    
    // Also add edit route for settings/password
    passwordIndexContent = fs.readFileSync(passwordIndexPath, 'utf-8');
    if (!passwordIndexContent.includes('export const edit')) {
        const editRoute = `
/**
 * Password settings edit page
 * @route '/settings/password'
 */
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/settings/password',
} satisfies RouteDefinition<["get","head"]>

edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

`;
        
        // Insert before "const password = {"
        passwordIndexContent = passwordIndexContent.replace(
            /const password = \{/,
            editRoute + 'const password = {'
        );
        
        // Add to password object (find the line with "request:" and add edit after it)
        passwordIndexContent = passwordIndexContent.replace(
            /(request: Object\.assign\(request, request\),)/,
            '$1\n    edit: Object.assign(edit, edit),'
        );
        
        fs.writeFileSync(passwordIndexPath, passwordIndexContent, 'utf-8');
        console.log('✅ Password edit route added');
    }
}

// Add two-factor.show route to two-factor/index.ts
const twoFactorIndexPath = path.join(routesDir, 'two-factor', 'index.ts');
if (fs.existsSync(twoFactorIndexPath)) {
    let twoFactorIndexContent = fs.readFileSync(twoFactorIndexPath, 'utf-8');
    
    if (!twoFactorIndexContent.includes('export const show')) {
        const showRoute = `
/**
 * Two-factor authentication settings page
 * @route '/settings/two-factor'
 */
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/settings/two-factor',
} satisfies RouteDefinition<["get","head"]>

show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

`;
        
        // Insert before "const twoFactor = {"
        twoFactorIndexContent = twoFactorIndexContent.replace(
            'const twoFactor = {',
            showRoute + 'const twoFactor = {'
        );
        
        // Add to twoFactor object
        twoFactorIndexContent = twoFactorIndexContent.replace(
            'const twoFactor = {',
            'const twoFactor = {\n    show: Object.assign(show, show),'
        );
        
        fs.writeFileSync(twoFactorIndexPath, twoFactorIndexContent, 'utf-8');
        console.log('✅ Two-factor show route added');
    }
}

console.log('✅ All missing action files created successfully');
