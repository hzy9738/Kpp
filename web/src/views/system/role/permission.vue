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
                    权限分配 (  {{ role  }}  )
                </p>

                <Row>
                    <Form :model="formData" :label-width="100" ref="formData" style="padding-left: 10%">
                        <Tree :data="permissions" show-checkbox ref="tree" style="margin-bottom: 20px"></Tree>
                        <Button  @click="goBack" style="width:100px;margin-right: 50px;">取消</Button>
                        <Button :loading="loading" style="width:100px;" type="primary"  @click="handleSubmit('formData')">
                            <span v-if="!loading">保存</span>
                            <span v-else>Loading...</span>
                        </Button>
                    </Form>
                </Row>
            </Card>
            </Col>
        </Row>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formData: {
                    route: [],
                    child_route: [],
                    use_route: [],
                },
                role: '',
                pages: [],
                childPages: [],
                uses: [],
                permissions:[],
                loading:false
            };
        },
        methods: {
            handleSubmit(name) {
                if(this.loading){
                    return false;
                }else{
                    this.loading = true;
                }
                //请求接口
                let route = [];
                let child_route = [];
                let use_route = [];
                let nodes = this.$refs.tree.getCheckedNodes();
                console.log(nodes)
                nodes.forEach((item)=>{
                    if( item.ident === 1){
                        route.push(item.id)
                    }else if (item.ident === 2){
                        child_route.push(item.id)
                    }else if (item.ident === 3){
                        use_route.push(item.id)
                    }
                })
                this.formData.route = route
                this.formData.child_route = child_route
                this.formData.use_route = use_route
                this.JAjax.postJson('role/permissions/add/'+this.$route.query.id, this.formData, (res) => {
                    this.$Message.success(res.message)
                    this.init()
                    this.initAccess()
                    setTimeout(()=>{
                        this.loading = false
                    },500)
                });
            },
            goBack (){
                this.$router.push({
                    name: 'role',
                });
            },
            // 获取树形权限
            getPermssions () {
                this.JAjax.postJson('role/permissions', {}, (res) => {
                    this.permissions = res.data;
                    this.permissions.forEach(page=>{
                        console.log(this.pages)
                        if(this.pages.indexOf(page.id) !== -1){
                            this.$set(page,'checked',true)
                        }
                        page.children.forEach(childPage=>{
                            if(this.childPages.indexOf(childPage.id) !== -1){
                                this.$set(childPage,'checked',true)
                            }
                            childPage.children.forEach(use=>{
                                if(this.uses.indexOf(use.id) !== -1) {
                                    this.$set(use,'checked',true)
                                    // use.checked = true
                                }
                            })
                        })
                    })
                });
            },
            // 获取当前角色的权限
            getTheRolePermission () {
                this.JAjax.postJson('role/permissions/'+this.$route.query.id, {}, (res) => {
                    this.role = res.data.role;
                    this.pages = res.data.pages.map(item=>item.id);
                    this.childPages = res.data.child_pages.map(item=>item.id);
                    this.uses = res.data.uses.map(item=>item.id);
                    this.getPermssions()
                });
            },
            init () {
                this.getTheRolePermission()
            },
            initAccess (){
                this.JAjax.postJson('role/permissions', {}, (res) => {
                    this.departs = res.data || {};
                    Cookies.set('access',res.user.permissions)
                });
            }
        },
        mounted () {
            this.init();
        }
    };
</script>
