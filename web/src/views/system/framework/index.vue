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
                    系统架构
                </p>
                <Row>


                    <div class="depart-header">
                        KnowledgePoint
                        <Button v-permission="['system-framework-add']" class="button" type="primary" shape="circle" @click="createDepart">创建新分支</Button>
                    </div>

                    <Collapse accordion v-model="isShow[index]" v-for="(depart,index) in departs">
                        <Panel name="1">
                            <span>{{ depart.title }}</span>
                            <primary-button :item="depart"
                                            @depart_rename="depart_rename"
                                            @depart_child="depart_child"
                                            @depart_delete="depart_delete"
                                            @depart_top="depart_top"
                                            @depart_down="depart_down">
                            </primary-button>
                            <div slot="content">
                                <Collapse accordion v-model="isChildShow[key]"  v-for="(item,key) in depart.children">
                                    <Panel name="1-1">
                                        <span>{{ item.title }}</span>
                                        <small-button :item="item"
                                                      @depart_rename="depart_rename"
                                                      @depart_child="depart_child"
                                                      @depart_delete="depart_delete"
                                                      @depart_top="depart_top"
                                                      @depart_down="depart_down">
                                        </small-button>
                                        <div slot="content">
                                            <div slot="content">
                                                <div class="ivu-collapse" v-for="son in item.children">
                                                    <div class="ivu-collapse-item">
                                                        <div class="ivu-collapse-header">
                                                            <span style="float: left">{{ son.title }}</span>
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
                                        </div>
                                    </Panel>
                                </Collapse>
                            </div>
                        </Panel>
                    </Collapse>

                </Row>
            </Card>
            </Col>
        </Row>
        <new-depart
                :newModel="newModel"
                @afresh_list="afresh_list">
        </new-depart>
        <rename-depart
                :renameModel="renameModel"
                :depart_id="depart_id"
                :name="name"
                :ident="ident"
                :route="route"
                @afresh_list="afresh_list">
        </rename-depart>
        <child-depart
                :childModel="childModel"
                :depart_id="depart_id"
                :name="name"
                :ident="ident"
                :route="route"
                @afresh_list="afresh_list">
        </child-depart>

    </div>
</template>

<script>
    import NewDepart from './components/new-depart';
    import RenameDepart from './components/rename-depart';
    import ChildDepart from  './components/child-depart'
    import SmallButton from  './components/small-button'
    import PrimaryButton from './components/primary-button'
    import SonButton from './components/son-button'
    import Cookies from 'js-cookie'
    export default {
        data () {
            return {
                isShow:[],
                isChildShow:[],
                isUseShow:[],
                departs: {},
                newModel: false,
                renameModel: false,
                childModel: false,
                transfer:true,
                depart_id: 0,
                name:'',
                ident:0,
                route:'',
                data:{}
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
                this.JAjax.postJson('role/permissions', {}, (res) => {
                    this.departs = res.data || {};
                    Cookies.set('access',res.user.permissions)
                });
            },
            createDepart () {
                this.newModel = !this.newModel;
            },
            afresh_list () {
                this.init();
            },
            depart_top (data) {
                // this.JAjax.postJson('framework/up',data,res=>{
                //     this.$Message.success(res.message);
                //     this.init()
                // })
            },
            depart_down (data) {
                // this.JAjax.postJson('framework/down',data,res=>{
                //     this.$Message.success(res.message);
                //     this.init()
                // })
            },
            depart_delete (data) {
                this.JAjax.postJson('framework/delete',data,res=>{
                    this.$Message.success(res.message);
                    this.init()
                })
            },
            depart_child (data) {
                this.depart_id = data.id
                this.ident = data.ident
                this.route = data.route || data.child_route || data.use_route
                this.name = data.title
                this.childModel = !this.childModel;
            },
            depart_rename (data) {
                this.depart_id = data.id
                this.ident = data.ident
                this.route = data.route || data.child_route || data.use_route
                this.name = data.title
                this.renameModel = !this.renameModel;
            },
        },
        mounted () {
            this.init();
        }
    };
</script>
