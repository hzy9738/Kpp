<style lang="less">
    @import '../../../styles/common.less';
    @import './components/table.less';

</style>

<template>
    <div>
        <Row :gutter="10">
            <Col span="8">
                <Card>
                    <p slot="title">
                        <Icon type="cube"></Icon>
                        <span>章节目录</span>
                    </p>
                    <Select v-model="source"
                            filterable
                            remote
                            :remote-method="remoteMethod"
                            :loading="loading1"
                            @on-change="selectSource"
                            style="top: 10px;position: absolute;left: 200px;width: 300px">
                        <Option v-for="(option, index) in sources" :value="option.value" :key="index">{{option.label}}
                        </Option>

                    </Select>

                    <Row class="margin-top-8">
                        <Button type="info" style="margin-left: 10px" @click="createTitle" v-if="dataList.length === 0">
                            创建章节
                        </Button>

                        <can-edit-table
                                v-if="dataList.length !== 0"
                                refs="table1"
                                :dataList="dataList"
                                @detail="detail"
                                class="margin-bottom-10">
                        </can-edit-table>
                    </Row>
                </Card>
            </Col>

            <Col span="16">
                <Card>
                    <p slot="title">
                        <Icon type="cube"></Icon>
                        <span>内容详情</span>
                    </p>
                    <Button type="info" @click="saveContent" style="top: 10px;position: absolute;right: 50px;">保存
                    </Button>
                    <Row class="margin-top-8">
                        <Col span="24">
                            <Input v-model="content" type="textarea" :autosize="{minRows: 6,maxRows: 3}"
                                   @on-keyup="contentKeyup"
                                   placeholder="Enter something..."></Input>
                        </Col>
                        <!--<Col span="6">-->
                        <!--<Tag v-for="item in tags" :key="item" :name="item" closable @on-close="handleClose2"-->
                        <!--style="margin:5px 10px">{{ item }}-->
                        <!--</Tag>-->

                        <!--</Col>-->

                    </Row>

                    <Row class="margin-top-8">
                        <Col span="18">

                            <!--<Button type="info" style="margin-left: 20px" @click="getTag">分词</Button>-->
                        </Col>
                    </Row>

                    <Row class="margin-top-8">
                        <Col span="24">
                            <Icon type="arrow-down-a" style="margin: auto"></Icon>
                            <span>简述</span>
                        </Col>
                    </Row>

                    <Row class="margin-top-8" v-for="(sentenceData ,index) in sentenceDatas">
                        <Col span="24">
                            <Icon type="plus-circled" style="cursor: pointer;color: red;float: left;margin-top: 7px"></Icon>
                            <Input v-model="sentenceData.sentence" placeholder="Enter something..." style="width: 300px;float: left;margin:0 10px"></Input>
                            <Icon type="plus-circled" style="cursor: pointer;color: #00a854;float: left;margin-top: 7px"></Icon>
                            <Button type="primary" shape="circle"  size="small" style="float: left;margin:4px 10px 0 10px">分词</Button>
                            <Cascader :data="knowledges" v-model="sentenceData.knowledge" style="width: 230px;float: left;margin:0 10px" placeholder="请选择知识点分类" ></Cascader>
                            <Cascader :data="models" v-model="sentenceData.model" style="width: 230px;float: left;margin:0 10px" placeholder="请选择标准分类" ></Cascader>
                        </Col>
                        <Col span="24">
                            <div style="padding: 10px 40px">
                                <Tag v-for="item in tags" :key="item" :name="item" closable @on-close="handleClose2" style="margin:5px 10px">{{ item }}</Tag>
                            </div>
                        </Col>
                        <Col span="24">
                            <hr>
                        </Col>
                    </Row>



                </Card>
            </Col>
            <Modal
                    v-model="createModel"
                    title="创建章节目录"
                    @on-ok="createNode('formData')"
                    :loading="loading">
                <Form :model="formData" :label-width="100" :rules="formInline" ref="formData">
                    <FormItem label="目录名称：" prop="title">
                        <Input v-model="formData.title" type="text" placeholder="请输入目录名称" style="width: 80%"></Input>
                    </FormItem>
                </Form>
            </Modal>
        </Row>
    </div>
</template>

<script>
    import canEditTable from './components/canEditTable.vue';


    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
        },
        data() {
            return {
                formData: {
                    title: '',
                },
                formInline: {
                    title: [
                        {required: true, message: '请输入目录名称', trigger: 'blur'},
                    ],
                },
                knowledges:[],
                models:[],
                dataList: [],
                content: '',
                tags: [],
                title_id: '',
                category_id: '',
                sources: [],
                source: '',
                loading1: false,
                loading: false,
                createModel: false,
                sentenceDatas: [
                    {
                        sentence:'',
                        knowledge:[],
                        model:[],
                        tags:[]
                    },
                ]
            }
        },
        methods: {
            createNode() {
                let formData = {
                    title: this.formData.title,
                    level: 0,
                    standard: this.source,
                }

                this.$refs['formData'].validate((valid) => {
                    if (valid) {
                        this.JAjax.postJson("title/create", formData, res => {
                            this.$Message.success('创建成功');
                            this.formData.title = ""
                            this.JAjax.postJson('title/lists', {id: this.source}, (res) => {
                                this.dataList = res.data || [];
                            });
                        })
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
            createTitle() {
                this.createModel = true

            },
            remoteMethod(query) {
                if (query !== '') {
                    this.loading1 = true;
                    setTimeout(() => {
                        this.loading1 = false;
                        const list = this.list.map(item => {
                            // console.log(item.name.toLowerCase())
                            return {
                                value: Number(item.id),
                                label: item.name,
                            };
                        });
                        this.sources = list.filter(item => item.label.toLowerCase().indexOf(query.toLowerCase()) > -1);
                    }, 200);
                } else {
                    this.sources = [];
                }
            },
            getSource() {
                this.JAjax.postJson('standard', {}, (res) => {
                    this.list = res.data
                });
            },
            selectSource(data) {
                this.JAjax.postJson('title/lists', {id: data}, (res) => {
                    this.dataList = res.data || [];
                });
            },
            contentKeyup() {
                if (this.title_id === '') {
                    this.$Message.error('请选择章节目录')
                    this.content = ""
                }
            },
            saveContent() {
                let formData = {
                    content: this.content,
                    title: this.title_id,
                    tags: this.tags
                }
                if (this.title_id === '') {
                    // this.$Message.error('请选择章节目录')
                    return
                }
                this.JAjax.postJson('content/save', formData, (res) => {
                    this.$Message.success("保存成功")
                });
            },
            handleClose2(event, name) {
                const index = this.tags.indexOf(name);
                this.tags.splice(index, 1);
            },
            getTag() {
                this.JAjax.postJson('word/tags', {content: this.content}, (res) => {
                    this.tags = res.data
                });
            },
            detail(id) {
                this.JAjax.postJson('title/content/' + id, {}, (res) => {
                    this.content = res.data.detail ? res.data.detail.content : '';
                    this.title_id = res.data.id
                });
                this.JAjax.postJson('title/tags/' + id, {}, (res) => {
                    let data = res.data.tags || [];
                    this.tags = [];
                    data.forEach(t => {
                        this.tags.push(t.tag)
                    })
                });

            },
            getlist() {
                let postdata = [];
                this.JAjax.postJson('title/lists', postdata, (res) => {
                    this.dataList = res.data || [];
                });
            },
            getKnowledges(){

            },
            getModel(){

            },
            afresh_list() {
                this.getlist();
            },

        },
        mounted() {
            this.getlist();
            this.getSource();

        }
    };
</script>
<style>
    .center {
        text-align: center;
    }

    .ivu-page {
        display: inline-block;
    }
</style>
