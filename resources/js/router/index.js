import { createRouter, createWebHistory } from 'vue-router'
import store from '../store'; // Import Vuex store

// Authentication
import Login from '../components/admin/auth/login.vue'

// Dashboard
import dashboard from '../components/admin/dashboard.vue';

// Article
import articlePlatform from '../components/admin/article/articlePlatform.vue';
import addArticleForm from '../components/admin/article/addForm.vue';
import editArticleForm from '../components/admin/article/editForm.vue';

// Inventory
import inventoryPlatform from '../components/admin/inventory/inventoryPlatform.vue';
import addInventoryForm from '../components/admin/inventory/addForm.vue';
import editInventoryForm from '../components/admin/inventory/editForm.vue';

// User
import userPlatform from '../components/admin/user/userPlatform.vue';
import addUserForm from '../components/admin/user/addForm.vue';
import editUserForm from '../components/admin/user/editForm.vue';

// User Account Setting
import userAccount from '../components/admin/userAccount/userAccount.vue';

// Monitoring System
import buoyPlatform from '../components/admin/monitoringSystem/buoy/buoyPlatform.vue';
import waterlevelPlatform from '../components/admin/monitoringSystem/waterLevel/waterlevelPlatform.vue';

// Main 
import Main from '../components/main.vue'

// Home Page
import Home from '../components/pages/homePage/home.vue';
import Article  from '../components/pages/homePage/articlePage/article.vue';
import moreArticle  from '../components/pages/homePage/articlePage/moreArticle.vue';
import Search  from '../components/pages/homePage/articlePage/search.vue';

// Projects
import Project1 from '../components/pages/homePage/projectsPage/project1.vue';
import Project2 from '../components/pages/homePage/projectsPage/project2.vue';
import Project3 from '../components/pages/homePage/projectsPage/project3.vue';
import Project4 from '../components/pages/homePage/projectsPage/project4.vue';

// Monitoring Page
import MonitoringSystem from '../components/pages/monitoringSystemPage/monitoringSystem.vue';

// Map
import Map from '../components/pages/mapPage/map.vue';

// Swan
import Swan from '../components/pages/swanPage/swan.vue';

// TestApi
import Test from '../components/test/test.vue';

const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
    },
    {
        name: 'test',
        path: '/test',
        component: Test,
    },
    {
        path: '/',
        component: Main,
        children:[
            // Home Page
            {
                name: 'home',
                path: '/',
                component: Home ,
            },
            {
                name: 'article',
                path: '/:article/:title/:id',
                component: Article ,
                props:true 
            },
            {
                name: 'moreArticle',
                path: '/:article',
                component: moreArticle ,
                props:true 
            },
            {
                name: 'search',
                path: '/search/:search',
                component: Search  
            },
            // Projects
            {
                name: 'project1',
                path: '/projects/project1',
                component: Project1,
                props:true 
            },
            {
                name: 'project2',
                path: '/projects/project2',
                component: Project2,
                props:true 
            },
            {
                name: 'project3',
                path: '/projects/project3',
                component: Project3,
                props:true 
            },
            {
                name: 'project4',
                path: '/projects/project4',
                component: Project4,
                props:true 
            },
            // Monitoring System Page
            {
                name: 'MonitoringSystem',
                path: '/monitoringSystem',
                component: MonitoringSystem,
            },
            // SWAN
            {
                name: 'swan',
                path: '/swan',
                component: Swan,
            },
            // MAP
            {
                name: 'map',
                path: '/map',
                component: Map,
            },
        ]
    },
    {
        path: '/admin',
        component: dashboard,
        meta: { requiresAuth: true },
        children: [
            // Article
            {
                name: 'articlePlatform',
                path: 'articlePlatform',
                component: articlePlatform
            },
            {
                name: 'addArticleForm',
                path: 'articlePlatform/addForm',
                component: addArticleForm
            },
            {
                name: 'editArticleForm',
                path: 'articlePlatform/editForm/:id',
                component: editArticleForm,
                props: true
            },
            // Inventory
            {
                name: 'inventoryPlatform',
                path: '/admin/inventoryPlatform',
                component: inventoryPlatform
            },
            {
                name: 'addInventoryForm',
                path: '/admin/inventoryPlatform/addForm',
                component: addInventoryForm
            },
            {
                name: 'editInventoryForm',
                path: '/admin/inventoryPlatform/editForm/:id',
                component: editInventoryForm,
                props: true
            },
            //User 
            {
                name: 'userPlatform',
                path: '/admin/userPlatform',
                component: userPlatform,
                meta: { role: '1' }
            },
            {
                name: 'addUserForm',
                path: '/admin/userPlatform/addForm',
                component: addUserForm,
                meta: { role: '1' }
            },
            {
                name: 'editUserForm',
                path: '/admin/userPlatform/editForm/:id',
                component: editUserForm,
                meta: { role: '1' },
                props: true
            },
            // User Setting
            {
                name: 'userAccount',
                path: '/admin/userAccount',
                component: userAccount
            },
            // Monitoring System
            {
                name: 'buoyPlatform',
                path: '/admin/buoyPlatform',
                meta: { role: '1' },
                component: buoyPlatform
            },
            {
                name: 'waterlevelPlatform',
                path: '/admin/waterlevelPlatform',
                meta: { role: '1' },
                component: waterlevelPlatform
            },
        ]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior(to, from, savedPosition) {
        return { top: 0, behavior: 'smooth' }
    }
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.getters.isAuthenticated;
    const userRole = localStorage.getItem('userRole');

    if (to.meta.requiresAuth && !isAuthenticated) {
        if (to.name !== 'login') {
            next({ name: 'login' });
        } else {
            next();
        }
    } else if (isAuthenticated && to.name === 'login') {
        next({ path: '/admin/articlePlatform' });
    } else {
        if (to.matched.some(record => record.meta.role)) {
            const requiredRole = to.matched.find(record => record.meta.role).meta.role;
            if (userRole === requiredRole) {
                next();
            } else {
                next({ path: '/unauthorized' });
            }
        } else {
            next();
        }
    }
});

export default router;
