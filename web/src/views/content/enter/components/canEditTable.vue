<style lang="less">
    @import './editable-table.less';
</style>

<template>
    <div>
        <Tree :ref="refs" :data="dataList" :render="renderContent"></Tree>
        <Modal
                v-model="show"
                title="添加子分类"
                @on-ok="addNode('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                <FormItem label="子分类：" prop="name">
                    <Input v-model="formData.name" type="text" placeholder="请输入子分类" style="width: 80%"></Input>
                </FormItem>
            </Form>
        </Modal>
    </div>
</template>

<script>


    export default {
        name: 'canEditTable',
        props: {
            refs: String,
            dataList: Array,
        },
        data() {
            return {
                formData: {
                    name: '',
                },
                formInline: {
                    name: [
                        {required: true, message: '请输入子分类', trigger: 'blur'},
                    ],
                },
                show: false,
                loading: true,
                data: {},
                children: {}
            };
        },

        methods: {
            renderContent(h, {root, node, data}) {
                return h('span', {
                    style: {
                        display: 'inline-block',
                        width: '100%'
                    }
                }, [
                    h('span', [
                        h('Icon', {
                            props: {
                                type: 'ios-paper-outline'
                            },
                            style: {
                                marginRight: '8px'
                            }
                        }),
                        h('span', data.title)
                    ]),
                    h('span', {
                        style: {
                            display: 'inline-block',
                            float: 'right',
                            marginRight: '32px'
                        }
                    }, [
                        h('Button', {
                            props: Object.assign({}, this.buttonProps, {
                                icon: 'ios-plus-empty',
                                type: 'success',
                            }),
                            style: {
                                marginRight: '8px'
                            },
                            on: {
                                click: () => {
                                    this.append(data)
                                }
                            }
                        }),
                        h('Button', {
                            props: Object.assign({}, this.buttonProps, {
                                icon: 'ios-minus-empty',
                                type: 'error',
                                disabled: data.pid === 0 ? true: false
                            }),

                            on: {
                                click: () => {
                                    this.remove(root, node, data)
                                }
                            }
                        })
                    ])
                ]);
            },
            append(data) {
                this.show = true
                this.$set(data, 'expand', 1)
                this.children = data.children || {};
                this.data = data

            },
            remove(root, node, data) {
                this.confirm(root, node, data);
            },

            addNode(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {

                        let data = this.data
                        let children = this.children

                        let formData = {
                            id: data.id,
                            name: this.formData.name,
                            type: data.type
                        }
                        let url = (  data.type === 'page' ? 'categories/add/page' : 'categories/add/model' )
                        this.JAjax.postJson(url, formData, (res) => {
                            if(res.code){
                                this.$Message.success('添加成功');
                                this.children.push({
                                    title: res.data.name,
                                    expand: true,
                                    id: res.data.id,
                                    children:[],
                                    type: res.data.type
                                });
                                this.$set(data, 'children', children);
                                this.formData.name = ''
                            }
                        });
                        setTimeout(() => {
                            this.show = false;
                        }, 500);
                    } else {
                        this.loading = false;
                        setTimeout(() => {
                            this.loading = true;
                        }, 100);
                        this.$Message.error('请检查您输入的信息');
                    }
                })
            },
            confirm (root, node, data) {
                this.$Modal.confirm({
                    title: '提示',
                    content: '<p>确认删除吗？</p><p></p>',
                    onOk: () => {
                        this.JAjax.postJson('categories/delete/category/'+data.id,{}, (res) => {
                            if (res.code) {
                                const parentKey = root.find(el => el === node).parent;
                                const parent = root.find(el => el.nodeKey === parentKey).node;
                                const index = parent.children.indexOf(data);
                                parent.children.splice(index, 1);
                                this.$Message.success('删除成功');
                            }
                        });

                    },
                });
            },

        },

        watch: {
            value(data) {
                this.init();
            }
        }
    };
</script>
