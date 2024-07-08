<template>
    <div class="w-full p-5 drop-shadow-lg">
        <DataTable class="display shadow-lg rounded">
            <thead>
                <tr>
                    <th v-for="(item, index) in columns" :key="index">{{ item.title }}</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </DataTable>
    </div>
</template>

<script>
import { DataTable } from 'datatables.net-vue3';
// import 'datatables.net-dt/css/jquery.dataTables.css';  // Ensure the CSS is included correctly
import Select from 'datatables.net-select';

export default {
    components: {
        DataTable
    },
    data() {
        
        const data = [
            [1, 2],
            [3, 4],
        ];
        return {
            dataTableOptions: {
                fixedColumns: true,
                scrollX: true,
            },
            data,
            columns: ''
        };
    },
    created() {
        const thiss = this;
        thiss.columns = [{
            title: 'Province',
        }, {
            title: 'Municipality/City',
        }, {
            title: 'Barangay',
        }, {
            title: 'EPR',
        }, {
            title: 'EPR_UNC',
        }, {
            title: 'EPR_Trend',
        }];
        thiss.columns = [{
            title: 'Province',
        }, {
            title: 'Municipality/City',
        }, {
            title: 'Barangay',
        }, {
            title: 'NSM',
        }, {
            title: 'NSM_highest',
        }, {
            title: 'NSM_trend',
        }];
        DataTable.use(Select);  // Initialize the Select plugin
    },
};
</script>

<style>
/* Include any additional styles you need here */
</style>
