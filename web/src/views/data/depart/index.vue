<style lang="less">
    @import "./home.less";
    @import "../../../styles/common.less";
</style>
<template>
    <div class="home-main" >
        <Row :gutter="10">
            <Col span="24">
            <Card>
                <p slot="title">
                    <Icon type="cube"></Icon>
                    组织架构
                </p>
                <Row>


                    <div class="depart-header">
                        KnowledgePoint
                        <Button v-permission="['data-depart-add']" class="button" type="primary" shape="circle" @click="createDepart">创建新部门</Button>
                    </div>

                    <Collapse accordion v-model="isShow[index]" v-for="(depart,index) in departs">
                        <Panel name="1" v-if="depart.children.length !== 0">
                            <span>{{ depart.depart }}</span>
                            <primary-button :item="depart"
                                            @depart_rename="depart_rename"
                                            @depart_child="depart_child"
                                            @depart_delete="depart_delete"
                                            @depart_top="depart_top"
                                            @depart_down="depart_down">
                            </primary-button>
                            <div slot="content">
                                <Collapse accordion v-model="isChildShow[key]"  v-for="(item,key) in depart.children">
                                    <Panel name="1-1" v-if="item.children.length !== 0">
                                        <small-button :item="item"
                                                      @depart_rename="depart_rename"
                                                      @depart_child="depart_child"
                                                      @depart_delete="depart_delete"
                                                      @depart_top="depart_top"
                                                      @depart_down="depart_down">
                                        </small-button>

                                        <div slot="content">
                                            <Collapse accordion>
                                                <Panel name="1-1" v-for="child in item.children" v-if="child.children.length !== 0">
                                                    <small-button :item="child"
                                                                  @depart_rename="depart_rename"
                                                                  @depart_child="depart_child"
                                                                  @depart_delete="depart_delete"
                                                                  @depart_top="depart_top"
                                                                  @depart_down="depart_down">
                                                    </small-button>

                                                    <div slot="content">
                                                        <div class="ivu-collapse" v-for="son in child.children">
                                                            <div class="ivu-collapse-item">
                                                                <div class="ivu-collapse-header">
                                                                    <son-button :item="son"
                                                                                  @depart_rename="depart_rename"
                                                                                  @depart_child="depart_child"
                                                                                  @depart_delete="depart_delete"
                                                                                  @depart_top="depart_top"
                                                                                  @depart_down="depart_down">
                                                                    </son-button>
                                                                </div>
                                                                <div class="ivu-collapse-content" style="display: none;">
                                                                    <div class="ivu-collapse-content-box"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </Panel>

                                                <div class="ivu-collapse" v-for="child in item.children"
                                                     v-if="child.children.length === 0">
                                                    <div class="ivu-collapse-item">
                                                        <div class="ivu-collapse-header">
                                                            <small-button :item="child"
                                                                          @depart_rename="depart_rename"
                                                                          @depart_child="depart_child"
                                                                          @depart_delete="depart_delete"
                                                                          @depart_top="depart_top"
                                                                          @depart_down="depart_down">
                                                            </small-button>
                                                        </div>
                                                        <div class="ivu-collapse-content" style="display: none;">
                                                            <div class="ivu-collapse-content-box"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Collapse>
                                        </div>
                                    </Panel>

                                    <div class="ivu-collapse"
                                         v-if="item.children.length === 0">
                                        <div class="ivu-collapse-item">
                                            <div class="ivu-collapse-header">
                                                <small-button :item="item"
                                                              @depart_rename="depart_rename"
                                                              @depart_child="depart_child"
                                                              @depart_delete="depart_delete"
                                                              @depart_top="depart_top"
                                                              @depart_down="depart_down">
                                                </small-button>
                                            </div>
                                            <div class="ivu-collapse-content" style="display: none;">
                                                <div class="ivu-collapse-content-box"></div>
                                            </div>
                                        </div>
                                    </div>

                                </Collapse>
                            </div>
                        </Panel>

                        <div class="ivu-collapse"
                             v-if="depart.children.length === 0">
                            <div class="ivu-collapse-item">
                                <div class="ivu-collapse-header">
                                    <span>{{ depart.depart }}</span>
                                    <primary-button :item="depart"
                                                    @depart_rename="depart_rename"
                                                    @depart_child="depart_child"
                                                    @depart_delete="depart_delete"
                                                    @depart_top="depart_top"
                                                    @depart_down="depart_down">
                                    </primary-button>
                                </div>
                                <div class="ivu-collapse-content" style="display: none;">
                                    <div class="ivu-collapse-content-box"></div>
                                </div>
                            </div>
                        </div>

                    </Collapse>

                </Row>
            </Card>
            </Col>
        </Row>
        <new-depart :newModel="newModel" @afresh_list="afresh_list"></new-depart>
        <rename-depart :renameModel="renameModel" :depart_id="depart_id" :name="name"  @afresh_list="afresh_list"></rename-depart>
        <child-depart :childModel="childModel" :depart_id="depart_id"   @afresh_list="afresh_list"></child-depart>

    </div>
</template>

<script>
    import NewDepart from './components/new-depart';
    import RenameDepart from './components/rename-depart';
    import ChildDepart from  './components/child-depart'
    import SmallButton from  './components/small-button'
    import PrimaryButton from './components/primary-button'
    import SonButton from './components/son-button'
    export default {
        data () {
            return {
                isShow:[],
                isChildShow: [],
                departs: {},
                newModel: false,
                renameModel: false,
                childModel: false,
                transfer:true,
                depart_id: 0,
                name:''
            };
        },
        components: {
            NewDepart,
            RenameDepart,
            ChildDepart,
            SmallButton,
            PrimaryButton,
            SonButton
        },
        methods: {
            init () {
                this.JAjax.postJson('depart/tree-list', {}, (res) => {
                    this.departs = res.data || {};
                });
            },
            createDepart () {
                this.newModel = !this.newModel;
            },
            afresh_list () {
                this.init();
            },
            depart_top (id) {
                this.JAjax.postJson('depart/up/'+id,{},res=>{
                    this.$Message.success(res.message);
                    this.init()
                })
            },
            depart_down (id) {
                this.JAjax.postJson('depart/down/'+id,{},res=>{
                    this.$Message.success(res.message);
                    this.init()
                })
            },
            depart_delete (id) {
                this.JAjax.postJson('depart/delete/'+id,{},res=>{
                    this.$Message.success(res.message);
                    this.init()
                })
            },
            depart_child (id) {
                this.depart_id = id
                this.childModel = !this.childModel;
            },
            depart_rename (id,name) {
                this.depart_id = id
                this.name = name
                this.renameModel = !this.renameModel;
            },
        },
        mounted () {
            this.init();
        }
    };
</script>
