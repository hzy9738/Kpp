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
                type: currentRow.is_active ? 'warning' : 'success',
                size: 'small'
            },
            style: {
                margin: '0 5px'
            },
            on: {
                'click': () => {
                    vm.active(currentRow)
                    console.log(currentRow.is_active ? '停用' : '激活' +'：', currentRow);
                }
            },
            directives: [
                {
                    name: 'permission',
                    value: ['system-admin-active'],
                }
            ],
        }, currentRow.is_active ? '停用' : '激活');
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
            on: {
                'click': () => {
                    console.log('修改：', currentRow);
                    vm.$emit('update-admin',currentRow)
                }
            },
            directives: [
                {
                    name: 'permission',
                    value: ['system-admin-update'],
                }
            ],
        }, '修改');
    };
    const passwordButton = (vm, h, currentRow, index) => {
        return h('Poptip', {
            props: {
                confirm: true,
                title: '您确定要重置'+currentRow.name+'的密码吗?',
                transfer: true
            },
            on: {
                'on-ok': () => {
                    vm.JAjax.postJson('admin/rePassword/'+currentRow.id,{},res=>{
                        vm.$Message.success({
                            content: res.message,
                            duration: 5
                        })
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
                    type: 'primary',
                    placement: 'top',
                    size: 'small',
                    permission: ['password']
                },
                directives: [
                    {
                        name: 'permission',
                        value: ['system-admin-password'],
                    }
                ],
            }, '重置密码')
        ]);
    };

    const deleteButton = (vm, h, currentRow, index) => {
        return h('Poptip', {
            props: {
                confirm: true,
                title: '您确定要删除吗?',
                transfer: true
            },
            on: {
                'on-ok': () => {
                    vm.JAjax.postJson('admin/delete/'+currentRow.id,{},res=>{
                         vm.$Message.success(res.message)
                         vm.$emit('afresh_list','data')
                    })
                }
            }
        }, [
            h('Button', {
                style: {
                    margin: '0 5px',
                },
                props: {
                    type: 'error',
                    placement: 'top',
                    size: 'small'
                },
                directives: [
                    {
                        name: 'permission',
                        value: ['system-admin-delete'],
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
                // departs:[]
            };
        },
        created () {
            this.init();
            // this.getDeparts();
        },
        methods: {
            // getDeparts () {
            //     this.JAjax.postJson('depart/list', {}, (res) => {
            //         this.departs = res.data;
            //     });
            // },
            active(user) {
                 this.JAjax.postJson('admin/active/'+user.id,{},res=>{
                     this.$Message.success(res.message);
                     this.$emit('afresh_list','data');
                 })
            },
            init () {
                let tableData = JSON.parse(JSON.stringify(this.value));
                tableData.forEach(item => {
                    item.statusName = '修改';
                    item.created_at = this.toDate(item.created_at);
                });
                this.thisTableData = tableData;
                this.columnsList.forEach((item) => {
                    if (item.handle) {
                        item.render = (h, param) => {
                            let currentRowData = this.thisTableData[param.index];
                            let btns = [];
                            if(currentRowData.name !== 'admin'){
                                btns.push(lookButton(this, h, currentRowData, param.index));
                                if (!currentRowData.status) {
                                    btns.push(updateButton(this, h, currentRowData, param.index));
                                }
                            }

                            btns.push(passwordButton(this, h, currentRowData, param.index));

                            if(currentRowData.name !== 'admin'){
                                btns.push(deleteButton(this, h, currentRowData, param.index));
                            }
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
