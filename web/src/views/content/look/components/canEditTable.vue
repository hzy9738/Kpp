<style lang="less">
    @import './editable-table.less';
</style>

<template>
    <div>
        <Tree :ref="refs" :data="dataList" :render="renderContent"></Tree>
        <Modal
                v-model="show"
                title="添加章节目录"
                @on-ok="addNode('formData')"
                :loading="loading">
            <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                <FormItem label="目录名称：" prop="name">
                    <Input v-model="formData.name" type="text" placeholder="请输入目录名称" style="width: 80%"></Input>
                </FormItem>
            </Form>
        </Modal>


    </div>
</template>

<script>
    import $ from 'jquery'

    function saveValue(value,className) {
        $('input.'+className).val(value)
    }

    function saveSpanText(value,className) {
        $('span'+className).text(value)
    }
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
                        {required: true, message: '请输入目录名称', trigger: 'blur'},
                    ],
                },
                standardShow:false,
                standardData:{
                    name: '',
                    user: '',
                },
                standardline: {
                    name: [
                        {required: true, message: '请输入目录名称', trigger: 'blur'},
                    ],
                    user: [
                        {required: true, message: '请输入目录名称', trigger: 'blur'},
                    ],
                },
                updateOrCreate:false,
                show: false,
                loading: true,
                title: '',
                titleId: '',
                styles: [],
                data: {},
                children: {},
                button: [],
                pid: 0
            };
        },

        methods: {

            renderContent(h, {root, node, data}) {
                var self = this
                return h('span', {
                    style: {
                        display: 'inline-block',
                        width: '100%',
                        padding:'2px  0 2px 2px ',
                        borderRadius:'5px',
                        border:'1px solid #999'
                    }
                }, [
                    h('span', [
                        h(this.styles[data.id] ? "Button" : 'Icon', {
                            props: {
                                type: this.styles[data.id] ? 'primary' : 'ios-paper-outline',
                                size: this.styles[data.id] ? 'small' : ''
                            },
                            on: {
                                click: () => {
                                    this.addNode(data.id)
                                },
                            },
                            style: {
                                marginRight: '8px',

                            }
                        }, this.styles[data.id] ? '保存' : ''),
                        h(this.styles[data.id] === 1 ? 'input' : 'span', {
                                style: {
                                    width: '250px',
                                    height: '30px'
                                },
                                class:"inputSpan"+data.id,
                                on: {
                                    input: function (event) {
                                        self.title = event.target.value
                                    },
                                },

                            },
                            data.title
                        )
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
                                icon: 'arrow-right-a',
                                type: this.button[data.id] ? 'info' : 'default',
                                size: 'small'
                            }),
                            style: {
                                marginRight: '-20px'
                            },
                            on: {
                                click: () => {
                                    this.detail(root, node, data)
                                }
                            }
                        }),
                    ])
                ]);
            },
            append(data) {
                if (this.styles.length === 0 && this.styles.indexOf(1) === -1) {
                    this.$set(data, 'expand', 1)
                    this.children = data.children || {};
                    this.data = data
                    this.children.push({
                        title: '双击输入目录名',
                        expand: true,
                        id: 0,
                        pid: data.id,
                        children: [],
                    });
                    this.$set(this.styles, 0, 1)
                    this.pid = data.id
                }
            },
            inputStyle(data, event) {
                if (!this.styles[0] && this.styles.indexOf(1) === -1) {
                    this.titleId = data.id
                    this.$set(this.styles,data.id,1)
                    setTimeout(() => {
                        saveValue(data.title,'inputSpan'+this.titleId);
                    }, 200);
                    this.title = data.title
                }
            },


            remove(root, node, data) {
                this.confirm(root, node, data);
            },

            addNode() {

                let data = this.data
                let children = this.children

                if (this.title !== '') {
                    let formData = {}
                    let url = ''
                    if(this.updateOrCreate){
                        formData = {
                            id: this.titleId,
                            title: this.title,
                        }
                         url = "title/update"
                    }else {
                         url = "title/add"
                        formData = {
                            id: data.id,
                            title: this.title,
                            level: data.level + 1,
                            standard: data.standard_id,
                        }
                    }
                    this.JAjax.postJson(url, formData, (res) => {
                        if (res.code) {
                            let $message = this.updateOrCreate ? '修改成功' : '添加成功'
                            this.$Message.success($message);

                            if(this.updateOrCreate){
                                let className = '.inputSpan'+this.titleId

                                console.log(this.title)
                                this.styles.splice(this.titleId, 1)
                                setTimeout(() => {
                                    saveSpanText(this.title,className)
                                }, 200);
                            }else {
                                this.children.splice(this.children.length - 1);
                                this.children.push({
                                    title: res.data.title,
                                    expand: true,
                                    id: res.data.id,
                                    pid: this.pid,
                                    standard_id: data.standard_id,
                                    level: data.level + 1,
                                    children: [],
                                    type: res.data.type
                                });
                                this.$set(data, 'children', children);
                                this.formData.name = ''
                                this.styles.splice(0, 1)
                            }


                        }
                    });
                }
            },
            confirm(root, node, data) {

                if (data.id === 0) {
                    const parentKey = root.find(el => el === node).parent;
                    const parent = root.find(el => el.nodeKey === parentKey).node;
                    const index = parent.children.indexOf(data);
                    parent.children.splice(index, 1);
                    this.styles.splice(0, 1)
                } else {
                    this.$Modal.confirm({
                        title: '提示',
                        content: '<p>确认删除吗？</p><p></p>',
                        onOk: () => {
                            this.JAjax.postJson('title/delete', {id:data.id}, (res) => {
                                if (res.code) {
                                    if (data.pid != 0) {
                                        const parentKey = root.find(el => el === node).parent;
                                        const parent = root.find(el => el.nodeKey === parentKey).node;
                                        const index = parent.children.indexOf(data);
                                        parent.children.splice(index, 1);
                                    } else {
                                        this.$emit('dataListNode', 1)
                                    }
                                    this.$Message.success('删除成功');
                                }
                            });

                        },
                    });
                }
            },
            detail(root, node, data) {
                this.button = [];
                this.$set(this.button, data.id, true)
                this.$emit('detail', data.id)
            }

        },

        watch: {
            value(data) {
                this.init();
            }
        }
    };
</script>
