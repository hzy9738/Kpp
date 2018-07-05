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
                    权限设置
                </p>
                <Button v-permission="['system-role-add']" style="top: 10px;position: absolute;right: 10px" class="button" type="primary" shape="circle" @click="addRole">+创建新角色</Button>
                <Row>
                    <Collapse accordion v-model="isShow[index]" v-for="(role,index) in roles">
                        <div class="ivu-collapse">
                            <div class="ivu-collapse-item">
                                <div class="ivu-collapse-header">
                                    <span>{{ role.role }}</span>
                                    <primary-button :item="role"
                                                    @role_rename="role_rename"
                                                    @role_delete="role_delete"
                                                    @role_permission="role_permission"
                                                    @role_watch="role_watch"
                                                    v-if="role.role !== '系统管理员'"
                                    >

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
        <add-role
                :addModel="addModel"
                @afresh_list="afresh_list">
        </add-role>
        <rename :renameModel="renameModel"
                :name="name"
                :role_id="role_id"
                @afresh_list="afresh_list">
        </rename>
        <watch-permission
                :permissionModel="permissionModel"
                :role_id="role_id"
                @afresh_list="afresh_list">
        </watch-permission>
    </div>
</template>

<script>
    import Rename from './components/rename';
    import PrimaryButton from './components/primary-button'
    import AddRole from  './components/add-role'
    import WatchPermission from './components/watch-permission'
    export default {
        data () {
            return {
                isShow:[],
                roles: {},
                addModel:false,
                renameModel: false,
                permissionModel:false,
                transfer:true,
                role_id: 0,
                name:''
            };
        },
        components: {
            Rename,
            PrimaryButton,
            AddRole,
            WatchPermission
        },
        methods: {
            addRole () {
                this.addModel = !this.addModel
            },
            init () {
                this.JAjax.postJson('role/list', {}, (res) => {
                    this.roles = res.data || {};
                });
            },
            afresh_list () {
                this.init();
            },
            role_watch (id) {
                this.role_id = id
                this.permissionModel = !this.permissionModel
            },
            role_delete (id) {
                this.JAjax.postJson('role/delete/'+id,{},res=>{
                    this.$Message.success(res.message);
                    this.init()
                })
            },
            role_rename (id,name) {
                this.role_id = id
                this.name = name
                this.renameModel = !this.renameModel;
            },
            role_permission (id) {
                this.role_id = id
                this.permissionModel = !this.permissionModel;
            }
        },
        mounted () {
            this.init();
        }
    };
</script>
