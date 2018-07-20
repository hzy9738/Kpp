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

    const deleteButton = (vm, h, currentRow, index) => {
        return h('Poptip', {
            props: {
                confirm: true,
                title: '您确定要删除吗?',
                transfer: true,
            },
            on: {
                'on-ok': () => {
                    console.log('删除：', currentRow);
                    vm.value.forEach((t,index)=>{
                        if(t.id === currentRow.id &&  t.sentence_id === currentRow.sentence_id){
                            vm.value.splice(index,1)
                            vm.$emit('spliceExport',currentRow.index)
                        }
                    })
                }
            }
        }, [
            h('Button', {
                style: {
                    margin: '0 5px'
                },
                props: {
                    type: 'error',
                    placement: 'top',
                    size: 'small',
                    disabled: currentRow.status === 2 ? true : false
                },
                directives: [
                    {
                        name: 'permission',
                        value: ['note-month-delete'],
                    }
                ],
            }, '删除')
        ]);
    };


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
                    item.typeId = item.type_id
                });
                this.thisTableData = tableData;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param) => {
                            let currentRowData = this.thisTableData[param.index];
                            let btns = [];

                            // btns.push(updateButton(this, h, currentRowData, param.index));
                            btns.push(deleteButton(this, h, currentRowData, param.index));
                            return h('div', btns);
                        };
                    }
                });
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
