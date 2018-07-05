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

    const excelButton = (vm, h, currentRow, index) => {
        return h('Poptip', {
            props: {
                confirm: true,
                title: '导出' + currentRow.date +'绩效考核表吗?',
                transfer: true,
            },
            on: {
                'on-ok': () => {
                    console.log('导出：', currentRow);
                    window.open('/api/note/excel?date='+currentRow.date)
                }
            }
        }, [
            h('Button', {
                style: {
                    margin: '0 5px'
                },
                props: {
                    type: 'success',
                    placement: 'top',
                    size: 'small',
                    // disabled: currentRow.status === 2 ? true : false
                },
            }, '导出')
        ]);
    };


    const lookButton = (vm, h, currentRow, index) => {
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
                    value: ['note-month-detail'],
                }
            ],
            on: {
                'click': () => {
                    console.log('详情：', currentRow);
                    vm.$router.push({
                        name: 'note_task_detail',
                        query: {
                            'date': currentRow.date
                        }
                    });
                }
            }
        }, '详情');
    };

    const checkButton = (vm, h, currentRow, index) => {
        return h('Button', {
            props: {
                type: 'primary',
                size: 'small',
                disabled: (currentRow.status === 2 || currentRow.status === 0) ? true : false
            },
            style: {
                margin: '0 5px'
            },
            directives: [
                {
                    name: 'permission',
                    value: ['note-month-check'],
                }
            ],
            on: {
                'click': () => {
                    console.log('审核：', currentRow);
                    if (currentRow.note_tasks_count !== currentRow.count) {
                        vm.$Message.error('尚有未提交的项目/部门，无法审核');
                        return false;
                    }
                    // if (currentRow.status === 2) {
                    //     vm.$Message.error('已提交，不能重复提交');
                    //     return false;
                    // }
                    vm.$router.push({
                        name: 'note_task_check',
                        query: {
                            'date': currentRow.date
                        }
                    });
                }
            }
        }, '审核');
    };

    const commitButton = (vm, h, currentRow, index) => {
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

                    console.log('提交审核：', currentRow);
                    if (currentRow.status === 2) {
                        vm.$Message.error('已提交，不能重复提交');
                        return false;
                    }
                    if (currentRow.note_tasks_count !== currentRow.count) {
                        vm.$Message.error('尚有未提交的项目/部门，无法提交审核');
                        return false;
                    }
                    vm.JAjax.postJson('note/month/commit/' + currentRow.id, {}, res => {
                        vm.$Message.success(res.message);
                        vm.$emit('afresh_list', 'data');
                    });
                }
            }
        }, (currentRow.status === 1 || currentRow.status === 2) ? '已提交' : '提交审核');
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
                    if (currentRow.status === 2) {
                        vm.$Message.error('已通过审核，无法修改')
                        return
                    }
                    console.log('修改：', currentRow);
                    vm.$router.push({
                        name: 'update_task',
                        query: {
                            'date': currentRow.date,
                        }
                    });
                }
            }
        }, '修改');
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
                    vm.JAjax.postJson('note/delete/' + currentRow.id, {}, res => {
                        vm.$Message.success(res.message);
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
                    '录入中',
                    '待审核',
                    '完毕',
                    '审核拒绝',
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
                    item.date = this.toMonth(item.date);
                    item.commit = item.note_tasks_count + ' / ' + item.count;
                    item.status = item.attribute;
                    item.attribute = this.attributes[item.attribute];
                });
                this.thisTableData = tableData;
                this.columnsList.forEach(item => {
                    if (item.handle) {
                        item.render = (h, param) => {
                            let currentRowData = this.thisTableData[param.index];
                            let btns = [];

                            btns.push(lookButton(this, h, currentRowData, param.index));
                            btns.push(checkButton(this, h, currentRowData, param.index));

                            btns.push(commitButton(this, h, currentRowData, param.index));

                            btns.push(updateButton(this, h, currentRowData, param.index));

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
