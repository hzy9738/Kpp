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
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {
                    console.log('查看：', currentRow);
                    vm.$router.push({
                        name: 'search_publish',
                        query: {id: currentRow.id}
                    });
                }
            }
        }, '查看');
    };
    const updateButton = (vm, h, currentRow, index) => {
        return h('Button', {
            props: {
                type: 'primary'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {
                    console.log('修改：', currentRow);
                    vm.$router.push({
                        name: 'update_publish',
                        query: {id: currentRow.id}
                    });
                }
            }
        }, '修改');
    };
    const deleteButton = (vm, h, currentRow, index) => {
        let status = currentRow.status ? '下架' : '上架';
        return h('Poptip', {
            props: {
                confirm: true,
                title: '您确定要' + status + '吗?',
                transfer: true
            },
            on: {
                'on-ok': () => {
                    var formData = {};
                    formData.publishId = currentRow.id;
                    formData.status = String(Number(!currentRow.status));
                    let thisTableData = vm.thisTableData;
                    vm.$commonAjax.post('sys/addOrUpdatePublish', qs.stringify(formData)).then(
                        (data) => {
                            if (data.data.code == 1) {
                                thisTableData[index].status = Number(!thisTableData[index].status);
                                thisTableData[index].statusName = Number(!thisTableData[index].status) ? '下架' : '上架';
                                vm.thisTableData = thisTableData;
                            }
                        }).catch(function (err) {
                        console.log(err);
                    });
                }
            }
        }, [
            h('Button', {
                style: {
                    margin: '0 5px'
                },
                props: {
                    type: 'primary',
                    placement: 'top'
                }
            }, currentRow.status ? '下架' : '上架')
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
                    item.statusName = item.status ? '上架' : '下架';
                    item.created_at = this.toTime(item.created_at);
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
