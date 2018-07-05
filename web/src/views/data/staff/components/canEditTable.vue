<style lang="less">
    @import './editable-table.less';
</style>

<template>
    <div>
        <Table :ref="refs" :columns="columnsList" :data="thisTableData" border disabled-hover></Table>
    </div>
</template>

<script>
    import qs from 'qs';
    import Cookies from 'js-cookie';

    const lookButton = (vm, h, currentRow, index) => {
        return h('Button', {
            props: {
                type: currentRow.is_active ? 'warning':'success',
                size: 'small'
            },
            style: {
                margin: '0 5px'
            },
            directives: [
                {
                    name: 'permission',
                    value: ['data-staff-status'],
                }
            ],
            on: {
                'click': () => {
                    console.log(currentRow.is_active ? '离职: ':'续职：', currentRow);
                    vm.JAjax.postJson('staff/leave/'+currentRow.id,{},res=>{
                        vm.$Message.success(res.message)
                        vm.$emit('afresh_list','data')
                    })
                }
            }
        }, currentRow.is_active ? '离职':'续职');
    };
    const updateButton = (vm, h, currentRow, index) => {
        return h('Button', {
            props: {
                type: 'primary',
                size: 'small'
            },
            style: {
                margin: '0 5px'
            },
            directives: [
                {
                    name: 'permission',
                    value: ['data-staff-update'],
                }
            ],
            on: {
                'click': () => {
                    console.log('修改：', currentRow);
                    vm.$emit('updateStaff',currentRow)
                }
            }
        }, '修改');
    };
    const deleteButton = (vm, h, currentRow, index) => {
        return h('Poptip', {
            props: {
                confirm: true,
                title: '您确定要删除吗?',
                transfer: true
            },
            directives: [
                {
                    name: 'permission',
                    value: ['data-staff-delete'],
                }
            ],
            on: {
                'on-ok': () => {
                    vm.JAjax.postJson('staff/delete/'+currentRow.id,{},res=>{
                        vm.$Message.success(res.message)
                        vm.$emit('afresh_list','data')
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
                    size: 'small'
                }
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
                thisTableData: []
            };
        },
        created () {
            this.init();
        },
        methods: {
            init () {
                let tableData = JSON.parse(JSON.stringify(this.value));
                tableData.forEach(item => {

                    item.created_at = this.toDate(item.created_at);
                    item.depart = '';
                    item.departs.forEach(value => {
                        item.depart += ( value.depart + '/')
                    })
                    item.depart = item.depart.substring(0,item.depart.length-1)
                });
                this.thisTableData = tableData;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param) => {
                            let currentRowData = this.thisTableData[param.index];
                            let btns = [];
                            btns.push(lookButton(this, h, currentRowData, param.index));
                            if (!currentRowData.status) {
                                btns.push(updateButton(this, h, currentRowData, param.index));
                            }
                            btns.push(deleteButton(this, h, currentRowData, param.index));
                            return h('div', btns);
                        };
                    }
                });
            },
            handleBackdata (data) {

            }
        },
        watch: {
            value (data) {
                this.init();
            }
        }
    };
</script>
