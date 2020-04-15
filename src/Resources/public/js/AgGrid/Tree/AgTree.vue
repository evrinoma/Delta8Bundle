<template>
    <div>
        <div style="height: 100%">
            <ag-grid-vue
                    style="width: 100%; height: 100%;"
                    class="ag-theme-balham"
                    :gridOptions="gridOptions"
                    @grid-ready="onGridReady"
                    :columnDefs="columnDefs"
                    :defaultColDef="defaultColDef"
                    :autoGroupColumnDef="autoGroupColumnDef"
                    :groupMultiAutoColumn="true"
                    :enableRangeSelection="true"
                    :animateRows="true"
                    :rowData="rowData"
            >
            </ag-grid-vue>
        </div>
    </div>
</template>

<script>
    import {AgGridVue} from "ag-grid-vue";
    import 'ag-grid-enterprise';
    import {fetch} from 'whatwg-fetch';

    export default {
        name: 'AgTreeVue',
        components: {
            AgGridVue,
        },
        data: function () {
            return {
                gridOptions: null,
                gridApi: null,
                columnApi: null,
                columnDefs: null,
                defaultColDef: null,
                autoGroupColumnDef: null,
                rowData: null,
            };
        },
        beforeMount() {
            this.gridOptions = {};
            this.columnDefs = [
                {
                    field: 'country',
                    rowGroup: true,
                    hide: true,
                },
                {
                    field: 'year',
                    rowGroup: true,
                    hide: true,
                },
                {
                    field: 'sport',
                    minWidth: 200,
                },
                {
                    field: 'athlete',
                    minWidth: 200,
                },
                {field: 'gold'},
                {field: 'silver'},
                {field: 'bronze'},
                {field: 'total'},
                {field: 'age'},
                {
                    field: 'date',
                    minWidth: 140,
                },
            ];
            this.defaultColDef = {
                flex: 1,
                minWidth: 100,
                sortable: true,
                resizable: true,
            };
            this.autoGroupColumnDef = {minWidth: 200};
        },
        mounted() {
             this.gridApi = this.gridOptions.api;
             this.gridColumnApi = this.gridOptions.columnApi;
        },
        methods: {
            loadRowData() {
                fetch(location.protocol + '//' + location.hostname + '/evrinoma/api/delta8/ag_data_tree')
                    .then(result => result.json())
                    .then(rowData => this.rowData = rowData);
            },
            onGridReady(params) {
                this.loadRowData();
            },
        },
    }
</script>

<style lang="scss">
    @import "../../../../../../../../../node_modules/ag-grid-community/dist/styles/ag-grid.css";
    @import "../../../../../../../../../node_modules/ag-grid-community/dist/styles/ag-theme-balham.css";
</style>
