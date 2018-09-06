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
                    <Button style="top: 10px;position: absolute;right: 20px" class="button" type="primary" shape="circle"
                            v-if="sourceOrListShow" @click="standardAdd">添加</Button>
                    <Button style="top: 10px;position: absolute;left: 400px;" shape="circle" icon="reply"
                            @click="goBackList" v-if="!sourceOrListShow"></Button>
                    <Row class="margin-top-8">
                        <Button type="info" style="margin-left: 10px" @click="createTitle"
                                v-if="!sourceOrListShow && dataList.length === 0">
                            创建章节
                        </Button>

                        <div v-if="sourceOrListShow">
                            <source-table
                                    refs="table1"
                                    v-model="sourceList"
                                    :columns-list="columns1"
                                    @editShow="editShow"
                                    @updateShow="updateShow"
                                    @afresh_list="afresh_list"
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
                        <Icon type="document-text"></Icon>
                        <span>内容详情</span>
                    </p>
                    <Button type="info" @click="saveContent" style="top: 10px;position: absolute;right: 50px;">保存
                    </Button>
                    <Row style="margin-top: -20px">
                        <Col span="24">

                                <Form :label-width="80">
                                    <div class="article-link-con">
                                        <transition name="fixed-link">
                                            <FormItem v-show="showLink" label="固定链接">
                                    <span>
                                        <span key="pathfixedtext">{{ fixedLink }}</span><span key="pathText" v-if="!editLink">{{ articlePath }}</span>
                                        <Input key="pathInput" v-model="articlePath" style="display:inline-block;width:auto"  v-else/>
                                    </span>
                                                <span style="float:right;">
                                        <Button :type="editPathButtonType" @click="editArticlePath">{{ editPathButtonText }}</Button>
                                    </span>
                                            </FormItem>
                                        </transition>
                                    </div>
                                </Form>
                                <div class="margin-top-20">
                                    <textarea id="articleEditor"></textarea>
                                </div>


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
                            <Icon type="bookmark"></Icon>
                            <span>简述</span>
                        </Col>
                    </Row>
                    <Row class="margin-top-8">
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
                                    style="float: left;margin:4px 10px 0 30px">分词
                            </Button>
                        </Col>
                        <Col span="24" class="margin-top-8" style="margin-left: 17px;margin-bottom: 12px">
                            <div :class="'tag'+index">
                                <Tag v-for="(item,key) in sentenceData.tags"  type="border" closable color="yellow"  @on-close="handleClose2(index, item)" checkable  style="margin:5px 5px">{{ item }}</Tag>
                                <Button icon="ios-plus-empty" type="dashed" size="small" @click="handleAdd(index)" v-if="sentenceData.tags && sentenceData.tags.length<=10">添加标签</Button>
                            </div>
                        </Col>
                        <Col span="24" class="margin-top-8" style="margin-left: 12px;margin-bottom: 12px">
                            <Cascader :data="knowledges" v-model="sentenceData.knowledge" change-on-select
                                      style="width: 22%;float: left;margin:0 10px" placeholder="请选择知识点分类"></Cascader>
                            <Cascader :data="models" v-model="sentenceData.model" change-on-select
                                      style="width: 22%;float: left;margin:0 10px" placeholder="请选择标准分类"></Cascader>
                            <Cascader :data="systems" v-model="sentenceData.system" change-on-select
                                      style="width: 22%;float: left;margin:0 10px" placeholder="请选择系统分类"></Cascader>
                            <Select v-model="sentenceData.type"  style="width: 15%;float: left;">
                                <Option  value="" key="0" placeholder="请选择类型"> --   ----  ---  ---  --</Option>
                                <Option v-for="item in types" :value="item.id" :key="item.id" placeholder="请选择类型">{{ item.name
                                    }}
                                </Option>
                            </Select>
                            <span style="margin:5px 10px;font-size: 12px">是否KP点</span>
                            <i-switch v-model="sentenceData.import" @on-change="change" >
                                <span slot="open">是</span>
                                <span slot="close">否</span>
                            </i-switch>
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
            <Modal
                    v-model="standardShow"
                    title="添加知识点来源"
                    @on-ok="addStandard('standardData')"
                    :loading="loading">
                <Form :model="standardData" :label-width="100" :rules="standardline" ref="standardData">
                    <FormItem label="知识点来源：" prop="name">
                        <Input v-model="standardData.name" type="text" placeholder="请输入子分类" style="width: 80%"></Input>
                    </FormItem>
                    <FormItem label="收集人：" prop="user">
                        <Input v-model="standardData.user" type="text" placeholder="收集人" style="width: 80%"></Input>
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
    import $  from 'jquery';
    import tinymce from 'tinymce';



    function tableAddBorder() {

    }

    export default {
        name: 'searchable-table',
        components: {
            canEditTable,
            sourceTable
        },
        data() {
            return {
                articleTitle: '',
                articleError: '',
                showLink: false,
                fixedLink: '',
                articlePath: '',
                articlePathHasEdited: false,
                editLink: false,
                editPathButtonType: 'ghost',
                editPathButtonText: '编辑',


                standardShow:false,
                standardData:{
                    name: '',
                    user: '',
                },
                standardline: {
                    name: [
                        {required: true, message: '请输入知识点来源', trigger: 'blur'},
                    ],
                    user: [
                        {required: true, message: '请输入收集人', trigger: 'blur'},
                    ],
                },
                columns1: table.columns1, // 表头
                sourceList: [],// 查询结果
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
                standardPost:true,
                knowledges: [],
                models: [],
                systems: [],
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
                        system: [],
                        model: [],
                        tags: [],
                        type: [],
                        import: 0,
                    },
                ],
                sourceOrListShow: true,

                types: {},
               globalcounter :1,
                standard:0
            }
        },
        methods: {
            handleAdd(index){
                let key = this.sentenceDatas[index].tags.length
                this.$Modal.confirm({
                    render: (h) => {
                        return h('Input', {
                            props: {
                                value: this.value,
                                autofocus: true,
                                placeholder: 'Please enter your name...'
                            },
                            on: {
                                input: (val) => {
                                    this.$set(this.sentenceDatas[index].tags,key,val)
                                }
                            }
                        })
                    }
                })
            },
            editArticlePath () {
                this.editLink = !this.editLink;
                this.editPathButtonType = this.editPathButtonType === 'ghost' ? 'success' : 'ghost';
                this.editPathButtonText = this.editPathButtonText === '编辑' ? '完成' : '编辑';
            },
            change (status) {

            },
            updateShow(data){
                this.standardPost = false
                this.standardData.id = data.id
                this.standardData.name = data.name
                this.standardData.user = data.user
                this.standardShow = true
            },
            addStandard(name){
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        if(this.standardPost){
                            this.JAjax.postJson('standard/add', this.standardData, (res) => {
                                if (res.code) {
                                    this.$Message.success('添加成功');
                                    this.afresh_list();
                                    this.standardData = {}
                                }
                            });
                        }else {
                            this.JAjax.postJson('standard/update', this.standardData, (res) => {
                                if (res.code) {
                                    this.$Message.success('修改成功');
                                    this.afresh_list();
                                    this.standardData = {}
                                }
                            });
                        }
                        setTimeout(() => {
                            this.standardShow = false
                        }, 500);
                    } else {
                        this.loading = false;
                        setTimeout(() => {
                            this.standardShow = true
                            this.loading = true;
                        }, 100);
                        this.$Message.error('请检查您输入的信息');
                    }
                })

            },
            standardAdd(){
                this.standardPost = true
                this.standardShow = true
            },
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
                if(this.sentenceDatas.length > 1){
                    this.sentenceDatas.forEach(t => {
                        if (t.sentence === '' || t.knowledge.length === 0 ||  t.system.length === 0 || t.model.length === 0 || t.type === "" || t.tags.length === 0) {
                            a = true
                        }
                    })
                }
                if (a) {
                    return this.$Message.error("简述未填写完整")
                }

                this.content = tinymce.activeEditor.getContent();

                tableAddBorder(this.content);

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
                this.JAjax.postJson('title/content', {id: id}, (res) => {
                    this.content = res.data.detail  ? (res.data.detail.content === null ? '' : res.data.detail.content) : '';
                    tinymce.activeEditor.setContent(this.content)
                    this.title_id = res.data.id
                });
                this.JAjax.postJson('title/sentences', {id: id}, (res) => {
                    let data = res.data || [];
                    this.sentenceDatas = [
                        {}
                    ]
                    data.sentences.forEach((t, index) => {

                        this.$set(this.sentenceDatas, index, {})

                        let model = t.model_id.split(",")
                        let page = t.page_id.split(",")
                        let system = t.system_id.split(",")
                        t.import = t.import ? true : false
                        this.$set(this.sentenceDatas[index], 'sentence', t.sentence)
                        this.$set(this.sentenceDatas[index], 'type', Number(t.type))
                        this.$set(this.sentenceDatas[index], 'model', model.map(t => Number(t)))
                        this.$set(this.sentenceDatas[index], 'knowledge', page.map(t => Number(t)))
                        this.$set(this.sentenceDatas[index], 'system', system.map(t => Number(t)))
                        this.$set(this.sentenceDatas[index], 'tags', t.tags.map(t => t.tag))
                        this.$set(this.sentenceDatas[index], 'import', t.import)

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
            getSystem() {
                this.JAjax.postJson('categories/systems', {}, (res) => {
                    this.systems = res.data || [];
                    this._systemForm(this.systems)
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
            _systemForm(data) {
                data.forEach(t => {
                    t.children = t.system_child || []
                    t.value = t.id || ''
                    t.label = t.title || ''
                    this._systemForm(t.children)
                })
            },
            getSourceList() {
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
            editShow(data) {
                this.JAjax.postJson('title/lists', {id: data.id}, (res) => {
                    this.dataList = res.data || [];
                    this.source = data.id
                    this.sourceOrListShow = false
                    this.formData.title = data.name
                    this.dataList.forEach(t=>{
                        t.expand = true
                    })
                    this.$router.push({
                        name: 'enter-content',
                        params: {
                            standard:  data.id
                        }
                    });
                });
            },
            getType() {
                this.JAjax.postJson('kptypes', {}, (res) => {
                    this.types = res.data
                });
            },
            goBackList() {
                this.sourceOrListShow = true
                this.$router.push({
                    name: 'enter-content',
                    params: {
                        standard: 0
                    }
                });
            },
            afresh_list() {
                this.getlist();
                this.getSourceList();
            },
            dataListNode() {
                this.dataList = []
            },
            editInit(){
                let that = this
                tinymce.init({
                    selector: '#articleEditor',
                    branding: false,
                    elementpath: false,
                    height: 200,
                    // invalid_elements : 'img',
                    language: 'zh_CN.GB2312',
                    menubar: 'edit insert view format table tools',
                    theme: 'modern',
                    plugins: [
                        // 'advlist autolink lists link image charmap print preview hr anchor pagebreak imagetools',
                        // 'searchreplace visualblocks visualchars code fullscreen fullpage',
                        'insertdatetime media nonbreaking save table contextmenu directionality',
                        // 'emoticons paste textcolor colorpicker textpattern imagetools codesample'
                        'code paste',
                    ],
                    // toolbar1: '  forecolor backcolor bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image emoticons media codesample',
                    // toolbar:'code',
                    autosave_interval: '20s',
                    // image_advtab: true,
                    paste_data_images: true,

                    paste_preprocess: function(plugin, args) {
                        args.content = args.content.replace("<img", "<img id=\"pasted_image_" + parseInt(that.globalcounter) + "\"");

                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function(){
                            if (this.readyState == 4 && this.status == 200){

                                upload( this.response);
                            }
                        };

                        xhr.open('GET', args.content.split('"')[3]);
                        xhr.responseType = 'blob';
                        xhr.send();

                        function upload(BlobFile){

                            var x = new XMLHttpRequest();
                            x.onreadystatechange = function(){
                                if( this.readyState == 4 && this.status == 200 ){

                                    let data = this.responseText;

                                    let id = parseInt(that.globalcounter++);

                                    // function setimg(id, data){
                                    //     if( document.getElementById("pasted_image_" + id)  == null){
                                    //         setTimeout( setimg , 5000);
                                    //     }else{
                                    //         document.getElementById("pasted_image_" + id).setAttribute("src", data);
                                    //     }
                                    // }
                                    document.getElementById("articleEditor_ifr").contentWindow.document.getElementById("pasted_image_" + id).setAttribute("src", data);
                                }
                            };
                            const formData = new FormData()
                            formData.append('file', BlobFile)
                            x.open('POST', '/api/upload/image');
                            x.send(formData);
                        }

                    },
                    table_default_styles: {
                        width: '100%',
                        borderCollapse: 'collapse',
                        border:'1px solid #333'
                    },
                    table_default_attributes:{
                        border: '1'
                    },
                });
            },
            routePush(){
                this.standard = this.$route.params.standard ? this.$route.params.standard : this.standard
                this.$router.push({
                    name: 'enter-content',
                    params: {
                        standard: this.standard
                    }
                });
                if(Number(this.standard) !== 0 ){
                    this.JAjax.postJson('title/lists', {id: this.standard}, (res) => {
                        this.dataList = res.data || [];
                        this.source = this.standard
                        this.sourceOrListShow = false
                        this.dataList.forEach(t=>{
                            t.expand = true
                        })
                    });
                }
            }
        },
        mounted() {
            // this.getlist();
            console.log(1111111);

            this.getType();
            this.getSource();
            this.getSourceList();
            this.getModel();
            this.getSystem();
            this.getKnowledges();
            this.editInit()
            this.routePush()



        },





        destroyed () {
            tinymce.get('articleEditor').destroy();
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
