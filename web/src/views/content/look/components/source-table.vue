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


    const editButton = (vm, h, currentRow, index) => {
        return h('Button', {
            props: {
                type: currentRow.status === 2 ? 'default' :'info',
                size: 'small',
                disabled: (currentRow.status === 1 || currentRow.status === 2)  ? true : false
            },
            style: {
                margin: '0 5px'
            },
            directives: [
                {
                    name: 'permission',
                    value: ['note-month-commit'],
                }
            ],
            on: {
                'click': () => {

                    console.log('修改：', currentRow);
                    vm.$emit('updateShow', currentRow);
                }
            }
        }, '修改');
    };
    const updateButton = (vm, h, currentRow, index) => {
        return h('Button', {
            props: {
                type: 'primary',
                size: 'small',
                disabled: (currentRow.status === 2 || currentRow.status === 1) ? true : false
            },
            style: {
                margin: '0 5px'
            },
            directives: [
                {
                    name: 'permission',
                    value: ['note-month-update'],
                }
            ],
            on: {
                'click': () => {
                    vm.$emit('editShow', currentRow);
                    console.log('编辑：', currentRow);
                    // vm.$router.push({
                    //     name: 'update_task',
                    //     query: {
                    //         'date': currentRow.date,
                    //     }
                    // });
                }
            }
        }, '预览');
    };
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
                    vm.JAjax.postJson('standard/delete', {id:currentRow.id}, res => {
                        vm.$Message.success('删除成功');
                        vm.$emit('afresh_list', 'data');
                    });
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
                attributes: [
                    '隐藏',
                    '免费',
                    '收费',
                ]
            };
        },
        created () {
            this.init();
        },
        methods: {
            init () {
                let tableData = JSON.parse(JSON.stringify(this.value));
                tableData.forEach(item => {
                });
                this.thisTableData = tableData;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param) => {
                            let currentRowData = this.thisTableData[param.index];
                            let btns = [];


                            btns.push(updateButton(this, h, currentRowData, param.index));

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
