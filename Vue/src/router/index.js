import VueRouter from "vue-router";
import UserHome from '../page/UserHome'
import SignupPage from '../page/SignupPage'
import LoginPage from '../page/LoginPage'
import SettingPage from '../page/SettingPage'

export default new VueRouter({
    routes: [
        {
            name: 'UserHome',
            path: '/',
            component: UserHome,
            meta: { transition: 'slide-left' }
        }, {
            name: 'SignupPage',
            path: '/signup',
            component: SignupPage,
            meta: { transition: 'slide-right' }
        }, {
            name: 'LoginPage',
            path: '/login',
            component: LoginPage,
            meta: { transition: 'slide-left' }
        }, {
            name: 'SettingPage',
            path: '/settings',
            component: SettingPage,
            meta: { transition: 'slide-right' }
        }
    ]
})