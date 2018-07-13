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
                    <!--<Select v-model="source"-->
                            <!--filterable-->
                            <!--remote-->
                            <!--:remote-method="remoteMethod"-->
                            <!--:loading="loading1"-->
                            <!--@on-change="selectSource"-->
                            <!--style="top: 10px;position: absolute;left: 200px;width: 300px">-->
                        <!--<Option v-for="(option, index) in sources" :value="option.value" :key="index">{{option.label}}-->
                        <!--</Option>-->
                    <!--</Select>-->
                    <Button  style="top: 10px;position: absolute;left: 400px;"  shape="circle" icon="reply" @click="goBackList" v-if="!sourceOrListShow"></Button>
                    <Row class="margin-top-8">
                        <Button type="info" style="margin-left: 10px" @click="createTitle" v-if="!sourceOrListShow && dataList.length === 0">
                            创建章节
                        </Button>

                       <div v-if="sourceOrListShow">
                           <source-table
                                   refs="table1"
                                   v-model="sourceList"
                                   :columns-list="columns1"
                                   @editShow="editShow"
                                   class="margin-bottom-10">
                               >
                           </source-table>
                           <Row class="center">
                               <Page :total="total" show-total @on-change="changePage" :page-size="pageSize"
                                     :page-size-opts="pageSizeOpts" show-elevator
                                     @on-page-size-change="changeSize"></Page>
                           </Row>
                       </div>


                        <can-edit-table
                                v-if="!sourceOrListShow && dataList.length !== 0"
                                refs="table1"
                                :dataList="dataList"
                                @detail="detail"
                                @dataListNode="dataListNode"
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
                            <i class="ivu-icon ivu-icon-minus-circled" @click="removeSentence(index)"
                               style="cursor: pointer;color: red;float: left;margin-top: 7px"></i>
                            <i-input v-model="sentenceData.sentence" placeholder="Enter something..."
                                   style="width: 400px;float: left;margin:0 10px"></i-input>
                            <i class="ivu-icon ivu-icon-plus-circled" @click="appendSentence(index)"
                               style="cursor: pointer;color: #00a854;float: left;margin-top: 7px"></i>
                            <Button type="primary" shape="circle" size="small" @click="getWordBySentence(index)"
                                    style="float: left;margin:4px 10px 0 10px">分词
                            </Button>
                            <Cascader :data="knowledges" v-model="sentenceData.knowledge" change-on-select
                                      style="width: 200px;float: left;margin:0 10px" placeholder="请选择知识点分类"></Cascader>
                            <Cascader :data="models" v-model="sentenceData.model" change-on-select
                                      style="width: 240px;float: left;margin:0 10px" placeholder="请选择标准分类"></Cascader>
                            <Input v-model="sentenceData.user" placeholder="姓名"
                                   style="width: 80px;float: left"></Input>
                        </Col>
                        <Col span="24">
                            <div style="padding: 10px 40px">
                                <Tag v-for="item in sentenceData.tags" :key="item" :name="item" closable
                                     @on-close="handleClose2(index,item)"
                                     style="margin:5px 10px">{{ item }}
                                </Tag>
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
    import sourceTable from './components/source-table.vue';
    import * as table from './data/search';


    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
            sourceTable
        },
        data() {
            return {
                columns1: table.columns1, // 表头
                sourceList:[],// 查询结果
                pageSize: 20, // 每页多少条
                total: 0, // 总共多少条数据
                status: null, // 课程状态
                page: 1, // 当前页码
                pageSizeOpts: [20, 25, 30, 40, 50],
                formData: {
                    title: '',
                },
                formInline: {
                    title: [
                        {required: true, message: '请输入目录名称', trigger: 'blur'},
                    ],
                },
                knowledges: [],
                models: [],
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
                        sentence: '',
                        knowledge: [],
                        model: [],
                        tags: [],
                        user: ""
                    },
                ],
                sourceOrListShow:true,
            }
        },
        methods: {
            getWordBySentence(index) {
                let content = this.sentenceDatas[index].sentence
                if (content !== '') {
                    this.JAjax.postJson('word/tags', {content: content}, (res) => {
                        this.$set(this.sentenceDatas[index], 'tags', res.data)
                    });
                } else {
                    this.$set(this.sentenceDatas[index], 'tags', [])
                }
            },
            handleClose2(index, name) {
                const key = this.sentenceDatas[index].tags.indexOf(name);
                this.sentenceDatas[index].tags.splice(key, 1);
            },
            removeSentence(index) {
                if (this.sentenceDatas.length >= 2) {
                    this.sentenceDatas.splice(index, 1)
                }
            },
            appendSentence() {
                let array = {
                    sentence: '',
                    knowledge: [],
                    model: [],
                    tags: []
                }
                this.sentenceDatas.push(array)
            },
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
                let a = true
                if (a && this.title_id === '') {
                    a = false
                    this.$Message.error('请选择章节目录')
                    this.content = ""
                }
            },
            saveContent() {
                let a = false
                this.sentenceDatas.forEach(t => {
                    if (t.sentence === '' || t.knowledge.length === 0 || t.model.length === 0 || t.user === "") {
                        a = true
                    }
                })
                if (a) {
                    return this.$Message.error("简述未填写完整")
                }
                let formData = {
                    content: this.content,
                    title: this.title_id,
                    sentences: this.sentenceDatas
                }
                if (this.title_id === '') {
                    // this.$Message.error('请选择章节目录')
                    return
                }
                this.JAjax.postJson('content/save', formData, (res) => {
                    this.$Message.success("保存成功")
                });
            },

            detail(id) {
                this.JAjax.postJson('title/content/' + id, {}, (res) => {
                    this.content = res.data.detail ? res.data.detail.content : '';
                    this.title_id = res.data.id
                });
                this.JAjax.postJson('title/sentences/' + id, {}, (res) => {
                    let data = res.data || [];
                    this.sentenceDatas = [
                        {

                        }
                    ]
                    data.sentences.forEach((t,index)=>{

                        this.$set(this.sentenceDatas,index,{})
                        // console.log(t.page_id.join(","))
                        let model  = t.model_id.split(",")
                        let page  = t.page_id.split(",")

                        this.$set(this.sentenceDatas[index],'sentence',t.sentence)
                        this.$set(this.sentenceDatas[index],'user',t.user)
                        this.$set(this.sentenceDatas[index],'model', model.map(t=>  Number(t) ) )
                        this.$set(this.sentenceDatas[index],'knowledge',  page.map(t=>  Number(t) ) )
                        this.$set(this.sentenceDatas[index],'tags',t.tags.map(t=>t.tag))
                    })
                });

            },
            getlist() {
                let postdata = {};
                this.JAjax.postJson('title/lists', postdata, (res) => {
                    this.dataList = res.data || [];
                });
            },
            getKnowledges() {
                this.JAjax.postJson('categories/pages', {}, (res) => {
                    this.knowledges = res.data || [];
                    this._kownForm(this.knowledges)
                });
            },
            getModel() {
                this.JAjax.postJson('categories/models', {}, (res) => {
                    this.models = res.data || [];
                    this._modelForm(this.models)
                });
            },
            _modelForm(data) {
                data.forEach(t => {
                    t.children = t.model_child || []
                    t.value = t.id || ''
                    t.label = t.title || ''
                    this._modelForm(t.children)
                })
            },
            _kownForm(data) {
                data.forEach(t => {
                    t.children = t.page_child || []
                    t.value = t.id || ''
                    t.label = t.title || ''
                    this._kownForm(t.children)
                })
            },
            getSourceList(){
                let postdata = {};
                postdata.page = this.page;
                postdata.pageSize = this.pageSize;
                this.JAjax.postJson('standard/lists', postdata, (res) => {
                    this.sourceList = res.data.data || [];
                    this.total = res.data.total;
                    this.pageSize = res.data.per_page;
                });
            },
            changePage(page) {
                this.page = page;
                this.getSourceList();
            },
            changeSize(size) {
                this.pageSize = size;
                this.getSourceList();
            },
            editShow(data){
                this.JAjax.postJson('title/lists', {id: data.id}, (res) => {
                    this.dataList = res.data || [];
                    this.source = data.id
                    this.sourceOrListShow = false
                    this.formData.title = data.name
                });
            },
            goBackList(){
                this.sourceOrListShow = true
            },
            afresh_list() {
                this.getlist();
            },
            dataListNode(){
               this.dataList =[]
            }
        },
        mounted() {
            // this.getlist();
            this.getSource();
            this.getSourceList();
            this.getModel();
            this.getKnowledges();
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
