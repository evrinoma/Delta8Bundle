<template>
    <div>
        <hot-table :data="data" rowHeaders="true" colHeaders="true" licenseKey="non-commercial-and-evaluation"></hot-table>
    </div>
</template>

<script>
    import {HotTable} from '@handsontable/vue';

    export default {
        name: 'HandsonTreeVue',
        data: function () {
            return {
                data: [
                    ["", "Ford", "Volvo", "Toyota", "Honda"],
                    ["2016", 10, 11, 12, 13],
                    ["2017", 20, 11, 14, 13],
                    ["2018", 30, 15, 12, 13]
                ],
            };
        },
        components: {
            HotTable,
        }
    }
</script>

<style lang="scss">
    @import "../../../../../../../../node_modules/handsontable/dist/handsontable.full.css";
</style>

