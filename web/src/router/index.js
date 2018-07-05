import Vue from 'vue';
import iView from 'iview';
import axios from 'axios';
import Util from '../libs/util';
import VueRouter from 'vue-router';
import Cookies from 'js-cookie';
import {routers, otherRouter, appRouter} from './router';
import store from '../store';

Vue.use(VueRouter);

// 路由配置
const RouterConfig = {
    // mode: 'history',
    routes: routers
};

export const router = new VueRouter(RouterConfig);

router.beforeEach((to, from, next) => {
    iView.LoadingBar.start();
    Util.title(to.meta.title);

    Vue.prototype.baseURL = 'api/';
    Vue.prototype.$commonAjax = axios.create({
        baseURL: Vue.prototype.baseURL,
        timeout: 5000,
        headers: {
            Accept: 'application/json',
        }
    });
    Vue.prototype.JAjax = {
        postJson: function (url, obj, success, fail) {
            Vue.prototype.$commonAjax.post(url, obj).then(
                (data) => {
                    let res = data.data;
                    if (res.code == 1) {
                        success && success(res);
                    } else if (res.code == '402') {
                        Vue.prototype.$Message.error(res.message);
                    } else if (res.code == '10001') {
                        //Cookies.remove('user');
                        store.commit('logout', Vue);
                        Vue.prototype.BaseData.newData = {};
                        Vue.prototype.BaseData.accesses = [];
                        next({
                            name: 'login'
                        });
                    } else {
                        Vue.prototype.$Message.error(res.msg);
                        fail && fail();
                    }
                }).catch(function (err) {
                if (err.response) {
                    console.log(url + ':' + err.response.status);
                    if (err.response.status === 401) {
                        store.commit('logout', Vue);
                        Cookies.remove('token');
                        Cookies.remove('user');
                        Cookies.remove('user_id');
                        next({
                            name: 'login'
                        });
                    }else if (err.response.status === 500) {
                        Vue.prototype.$Message.error('系统错误');
                    }

                }
            });
        },
        getJson: function (url, obj, success, fail) {
            let pram = qs.stringify(obj);
            url = url + '?' + pram;
            Vue.prototype.$commonAjax.get(url).then(
                (data) => {
                    let res = data.data;
                    if (res.code == 1) {
                        success && success(res);
                    } else if (res.code == '10001') {
                        // Cookies.remove('user');
                        store.commit('logout', Vue);
                        Vue.prototype.BaseData.newData = {};
                        Vue.prototype.BaseData.accesses = [];
                        next({
                            name: 'login'
                        });
                    } else {
                        Vue.prototype.$Message.error(res.msg);
                        fail && fail();
                    }
                }).catch(function (err) {
                console.log(url + ':' + err);
            });
        },
        deleteJson: function (url, obj, success, fail) {
            Vue.prototype.$commonAjax.delete(url).then(
                (data) => {
                    let res = data.data;
                    if (res.code == 1) {
                        success && success(res);
                    } else if (res.code == '10001') {
                        //Cookies.remove('user');
                        store.commit('logout', Vue);
                        Vue.prototype.BaseData.newData = {};
                        Vue.prototype.BaseData.accesses = [];
                        next({
                            name: 'login'
                        });
                    } else {
                        Vue.prototype.$Message.error(res.msg);
                        fail && fail();
                    }
                }).catch(function (err) {
                console.log(url + ':' + err);
            });
        }
    };
    if (Cookies.get('locking') === '1' && to.name !== 'locking') { // 判断当前是否是锁定状态
        next({
            replace: true,
            name: 'locking'
        });
    } else if (Cookies.get('locking') === '0' && to.name === 'locking') {
        next(false);
    } else {
        if (!Cookies.get('user') && to.name !== 'login') { // 判断是否已经登录且前往的页面不是登录页
            next({
                name: 'login'
            });
        } else if (Cookies.get('user') && to.name === 'login') { // 判断是否已经登录且前往的是登录页
            Util.title();
            next({
                name: 'home_index'
            });
        } else {
            const curRouterObj = Util.getRouterObjByName([otherRouter, ...appRouter], to.name);

            if (curRouterObj && curRouterObj.permission !== undefined) { // 需要判断权限的路由
                let access = JSON.parse(Cookies.get('access'));
                if (access.indexOf( curRouterObj.permission ) === -1) {
                    next({
                        replace: true,
                        name: 'error-403'
                    });
                }else {
                    Util.toDefaultPage([...routers], to.name, router, next);
                }
            } else { // 没有配置权限的路由, 直接通过
                Util.toDefaultPage([...routers], to.name, router, next);
            }
        }
    }
});

router.afterEach((to) => {
    Util.openNewPage(router.app, to.name, to.params, to.query);
    iView.LoadingBar.finish();
    window.scrollTo(0, 0);
});
