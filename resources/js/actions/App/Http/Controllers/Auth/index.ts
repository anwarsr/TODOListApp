import AuthenticatedSessionController from './AuthenticatedSessionController'
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
