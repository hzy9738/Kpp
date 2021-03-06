import Main from '@/views/Main.vue';

// 不作为Main组件的子页面展示的页面单独写，如下
export const loginRouter = {
    path: '/login',
    name: 'login',
    meta: {
        title: 'Login - 登录'
    },
    component: () => import('@/views/login.vue')
};

export const page404 = {
    path: '/*',
    name: 'error-404',
    meta: {
        title: '404-页面不存在'
    },
    component: () => import('@/views/error-page/404.vue')
};

export const page403 = {
    path: '/403',
    meta: {
        title: '403-权限不足'
    },
    name: 'error-403',
    component: () => import('@//views/error-page/403.vue')
};

export const page500 = {
    path: '/500',
    meta: {
        title: '500-服务端错误'
    },
    name: 'error-500',
    component: () => import('@/views/error-page/500.vue')
};

export const preview = {
    path: '/preview',
    name: 'preview',
    component: () => import('@/views/form/article-publish/preview.vue')
};

export const locking = {
    path: '/locking',
    name: 'locking',
    component: () => import('@/views/main-components/lockscreen/components/locking-page.vue')
};



// 作为Main组件的子页面展示但是不在左侧菜单显示的路由写在otherRouter里
export const otherRouter = {
    path: '/',
    name: 'otherRouter',
    redirect: '/home',
    component: Main,
    children: [
        { path: 'home', title: {i18n: 'home'}, name: 'home_index', component: () => import('@/views/home/home.vue') },
        { path: 'ownspace', title: '个人中心', name: 'ownspace_index', component: () => import('@/views/own-space/own-space.vue') },


    ],

};

// 作为Main组件的子页面展示并且在左侧菜单显示的路由写在appRouter里
export const appRouter = [
    {
        path: '/category',
        icon: 'social-buffer',
        name: 'category',
        title: '分类',
        component: Main,
        children: [
            {
                path: 'model',
                icon: 'compose',
                name: 'category-model',
                title: '标准',
                component: () => import('@/views/category/control/model.vue')
            },
            {
                path: 'knowledge',
                icon: 'pound',
                name: 'category-knowledge',
                // permission: 'note-responsible-watch',
                title: '知识点',
                component: () => import('@/views/category/control/kown.vue')
            },
            {
                path: 'system',
                icon: 'compose',
                name: 'category-system',
                // permission: 'note-responsible-watch',
                title: '系统',
                component: () => import('@/views/category/control/system.vue')
            },
        ]
    },

    {
        path: '/control',
        icon: 'social-buffer',
        name: 'type',
        title: '类型',
        component: Main,
        children: [
            {
                path: 'type',
                icon: 'compose',
                name: 'kown-type',
                title: '类型',
                component: () => import('@/views/ketype/type/index.vue')
            },

        ]
    },

    {
        path: '/content',
        icon: 'social-buffer',
        name: 'content',
        title: '内容',
        component: Main,
        children: [
            {
                path: 'enter/:standard',
                icon: 'compose',
                name: 'enter-content',
                title: '内容',
                component: () => import('@/views/content/enter/index.vue')
            },
        ]
    },
    // {
    //     path: '/book',
    //     icon: 'social-buffer',
    //     name: 'book',
    //     title: '预览',
    //     component: Main,
    //     children: [
    //         {
    //             path: 'look',
    //             icon: 'ios-book-outline',
    //             name: 'look-book',
    //             title: '预览',
    //             component: () => import('@/views/content/look/index.vue')
    //         },
    //     ]
    // },
    {
        path: '/search',
        icon: 'social-buffer',
        name: 'search',
        title: '查询',
        component: Main,
        children: [
            {
                path: "kkp/:type",
                icon: 'search',
                name: 'search-index',
                title: '查询',
                component: () => import('@/views/search/index/index.vue')
            },

        ]
    },
    {
        path: '/export',
        icon: 'social-buffer',
        name: 'export',
        title: '导出',
        component: Main,
        children: [
            {
                path: "excel",
                icon: 'android-download',
                name: 'excel-export',
                title: '导出',
                component: () => import('@/views/search/export/index.vue')
            },

        ]
    },
    //
    // {
    //     path: '/data',
    //     icon: 'social-buffer',
    //     name: 'note',
    //     title: '内容',
    //     component: Main,
    //     children: [
    //         {
    //             path: 'month',
    //             icon: 'compose',
    //             name: 'note-month',
    //             title: '知识点管理',
    //             component: () => import('@/views/note/month/index.vue')
    //         },
    //     ]
    // },
];

// 所有上面定义的路由都要写在下面的routers里
export const routers = [
    loginRouter,
    otherRouter,
    preview,
    locking,
    ...appRouter,
    page500,
    page403,
    page404
];
