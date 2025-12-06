import AuthController from './AuthController'
import GoogleAuthController from './GoogleAuthController'
import TaskController from './TaskController'
import CategoryController from './CategoryController'
import AdminController from './AdminController'
const Controllers = {
    AuthController: Object.assign(AuthController, AuthController),
GoogleAuthController: Object.assign(GoogleAuthController, GoogleAuthController),
TaskController: Object.assign(TaskController, TaskController),
CategoryController: Object.assign(CategoryController, CategoryController),
AdminController: Object.assign(AdminController, AdminController),
}

export default Controllers