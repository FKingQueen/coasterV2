import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';
import router from './router';
import ViewUIPlus from 'view-ui-plus';
import Antd from 'ant-design-vue';
import 'view-ui-plus/dist/styles/viewuiplus.css';
import locale from 'view-ui-plus/dist/locale/en-US';
import CKEditor from '@ckeditor/ckeditor5-vue';
import Highcharts from "highcharts";
import HighchartsVue from 'highcharts-vue';
import StockModule from "highcharts/modules/stock";
import windbarb from 'highcharts/modules/windbarb'
windbarb(Highcharts)

import DataTable from 'datatables.net-vue3'

import store from './store';  // Import the store

StockModule(Highcharts);
require('./bootstrap');

const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(ViewUIPlus, {locale: locale});
app.use(router);
app.use(DataTable);
app.use(Antd);
app.use(CKEditor);
app.use(store);
app.use(HighchartsVue);
app.mount('#app');
