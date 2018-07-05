import Vue from 'vue';
import Cookies from 'js-cookie';
import Util from '@/libs/util';
Vue.directive('permission', {
    bind: function (el, binding, vnode) {
        // let path = binding.value.route.path.replace(/\//g,"-");
        // if( path.charAt(0) === '-' ){
        //     path = path.substring(1)
        // }
        // path = path + '-' + binding.value.action

        // console.log(access)
        // console.log(binding.value[0])

    }
})
