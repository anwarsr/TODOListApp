import PasswordController from './PasswordController'
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
