<style lang="less">
    @import './editable-table.less';
</style>

<template>
    <div>
        <Table :ref="refs" :columns="columnsList" :data="thisTableData"  border disabled-hover></Table>
    </div>
</template>

<script>
    import qs from 'qs';
    import Cookies from 'js-cookie';




    export default {
        name: 'canEditTable',
        props: {
            refs: String,
            columnsList: Array,
            value: Array,
            url: String
        },
        data () {
            return {
                columns: [],
                thisTableData: [],
            };
        },
        created () {
            this.init();
        },
        methods: {
            exportData () {
                   this.$emit('exportExcel')
            },
            init () {
                this.getCategory()


                let tableData = JSON.parse(JSON.stringify(this.value));
                tableData.forEach(item => {
                    let pages = item.page_id.split(',')
                    pages = pages.map(t=>this.category[t])
                    item.page = pages.join(' / ')

                    let models = item.model_id.split(',')
                    models = models.map(e=>this.category[e])
                    item.model = models.join(' / ')


                    item.typeId = 23
                });
                this.thisTableData = tableData;

            },
            getCategory() {
                this.JAjax.postJson('categories', {}, (res) => {
                    this.category = res.data || []
                });
            }
        },
        watch: {
            value (data) {
                this.init();
            }
        }
    };
</script>
