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
<!--            <ag-grid-vue style="width: 700px; height: 500px;"-->
<!--                         class="ag-theme-balham"-->
<!--                         :columnDefs="columnDefs"-->
<!--                         :rowData="rowData"-->
<!--                         rowSelection="multiple"-->
<!--                         @grid-ready="onGridReady"-->
<!--            >-->
            </ag-grid-vue>
        </div>
    </div>
</template>

<script>
    import {AgGridVue} from "ag-grid-vue";
    import 'ag-grid-enterprise';
    import {fetch} from 'whatwg-fetch';

    export default {
        name: 'Tree',
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
            onGridReady(params) {
                // const httpRequest = new XMLHttpRequest();
                // const updateData = data => {
                //     this.rowData = data;
                // };

                // httpRequest.open(
                //     'GET',
                //     'https://raw.githubusercontent.com/ag-grid/ag-grid/master/grid-packages/ag-grid-docs/src/olympicWinnersSmall.json'
                // );
                // httpRequest.send();
                // httpRequest.onreadystatechange = () => {
                //     if (httpRequest.readyState === 4 && httpRequest.status === 200) {
                //         updateData(JSON.parse(httpRequest.responseText));
                //     }
                // };
            },
        },
    }
</script>

<style lang="scss">
    @import "../../../../../../../../../node_modules/ag-grid-community/dist/styles/ag-grid.css";
    @import "../../../../../../../../../node_modules/ag-grid-community/dist/styles/ag-theme-balham.css";
    /*@import "../../../../../../../../../node_modules/ag-grid-community/dist/styles/ag-theme-alpine.css";*/
</style>
