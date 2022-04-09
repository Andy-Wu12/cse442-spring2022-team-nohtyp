import VueRouter from "vue-router";
import UserHome from '../page/UserHome'
import SignupPage from '../page/SignupPage'
import LoginPage from '../page/LoginPage'

export default new VueRouter({
    routes: [
        {
            path: '/',
            component: UserHome
        },{
            path: '/signup',
            component: SignupPage
        }, {
            path: '/login',
            component: LoginPage
        }
    ]
})