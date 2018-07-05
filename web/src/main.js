import Vue from 'vue';
import iView from 'iview';
import {router} from './router/index';
import {appRouter} from './router/router';
import store from './store';
import App from './app.vue';
import '@/locale';
import 'iview/dist/styles/iview.css';
import VueI18n from 'vue-i18n';
import util from './libs/util';
import permission from './directive/permission'

Vue.use(VueI18n);
Vue.use(iView);

function toMonth (string) {
    let date = new Date(string);
    let year = date.getFullYear();
    let month = date.getMonth() + 1;
    return year + '-' +changeNum(month);
}
function toDate (string) {
    let date = new Date(string);
    let year = date.getFullYear();
    let month = date.getMonth() + 1;
    let day = date.getDate();
    return year + '-' +changeNum(month) + '-' + changeNum(day);
}
function toTime (string) {
    let date = new Date(string);
    let year = date.getFullYear();
    let month = date.getMonth() + 1;
    let day = date.getDate();
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let second = date.getSeconds();
    return year + '-' +changeNum(month) + '-' + changeNum(day) + ' ' + changeNum(hours) + ':' + changeNum(minutes) + ':' + changeNum(second);
}
function changeNum(num){
    if(num<10){
        return '0'+num;
    }
    return num
}
Vue.prototype.toDate = toDate;
Vue.prototype.toTime = toTime;
Vue.prototype.toMonth = toMonth;

new Vue({
    el: '#app',
    router: router,
    store: store,
    render: h => h(App),
    data: {
        currentPageName: ''
    },
    mounted () {
        this.currentPageName = this.$route.name;
        // 显示打开的页面的列表
        this.$store.commit('setOpenedList');
        this.$store.commit('initCachepage');
        // 权限菜单过滤相关
        this.$store.commit('updateMenulist');
        // iview-admin检查更新
        util.checkUpdate(this);
    },
    created () {
        let tagsList = [];
        appRouter.map((item) => {
            if (item.children.length <= 1) {
                tagsList.push(item.children[0]);
            } else {
                tagsList.push(...item.children);
            }
        });
        this.$store.commit('setTagsList', tagsList);
    }
});
