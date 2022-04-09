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
            component: UserHome
        }, {
            name: 'SignupPage',
            path: '/signup',
            component: SignupPage
        }, {
            name: 'LoginPage',
            path: '/login',
            component: LoginPage
        }, {
            name: 'SettingPage',
            path: '/settings',
            component: SettingPage
        }
    ]
})